<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPostController extends Controller
{
    public function __construct(private readonly PostService $service)
    {
    }

    public function index(): View
    {
        $posts = Post::withTrashed()
            ->with(['author', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.create', $this->formData());
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['author_id'] = $request->user()->id;

        $this->service->create($data, $request->file('image'));

        return to_route('admin.posts.index')->with('success', 'Entrada creada correctamente.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', ['post' => $post] + $this->formData());
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->service->update($post, $data, $request->file('image'));

        return to_route('admin.posts.index')->with('success', 'Entrada actualizada correctamente.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->service->delete($post);

        return back()->with('success', 'Entrada eliminada.');
    }

    public function restore(Post $post): RedirectResponse
    {
        $post->restore();

        return back()->with('success', 'Entrada restaurada.');
    }

    private function formData(): array
    {
        return [
            'categories' => Category::active()->orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ];
    }
}
