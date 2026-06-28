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

/**
 * Gestiona el CRUD de entradas del blog desde el panel de administración.
 */
class AdminPostController extends Controller
{
    /**
     * Inyecta el servicio de entradas.
     *
     * @param  \App\Services\PostService  $service
     * @return void
     */
    public function __construct(private readonly PostService $service)
    {
    }

    /**
     * Lista las entradas (incluidas las eliminadas) con autor y categoría, paginadas.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $posts = Post::withTrashed()
            ->with(['author', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Muestra el formulario de creación de una entrada.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.posts.create', $this->formData());
    }

    /**
     * Crea una nueva entrada con su imagen y redirige al listado.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['author_id'] = $request->user()->id;

        $this->service->create($data, $request->file('image'));

        return to_route('admin.posts.index')->with('success', 'Entrada creada correctamente.');
    }

    /**
     * Muestra el formulario de edición de una entrada.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', ['post' => $post] + $this->formData());
    }

    /**
     * Actualiza una entrada con su imagen y redirige al listado.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->service->update($post, $data, $request->file('image'));

        return to_route('admin.posts.index')->with('success', 'Entrada actualizada correctamente.');
    }

    /**
     * Elimina (soft delete) una entrada y vuelve atrás.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->service->delete($post);

        return back()->with('success', 'Entrada eliminada.');
    }

    /**
     * Restaura una entrada previamente eliminada y vuelve atrás.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
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
