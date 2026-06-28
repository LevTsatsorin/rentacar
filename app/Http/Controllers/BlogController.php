<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador del blog (listado y detalle de publicaciones).
 */
class BlogController extends Controller
{
    /**
     * Lista las publicaciones publicadas con filtro opcional por categoría.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $query = Post::published()->with(['author', 'category']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn (Builder $q) => $q->where('slug', $request->input('category')));
        }

        $posts = $query->latest()->paginate(6)->withQueryString();
        $categories = Category::active()->orderBy('name')->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    /**
     * Muestra el detalle de una publicación a partir de su slug.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show(string $slug): View
    {
        $post = Post::published()
            ->with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }
}
