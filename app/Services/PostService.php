<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Lógica de negocio para crear, actualizar y eliminar posts del blog.
 */
class PostService
{
    /**
     * Crea un post junto con su imagen y etiquetas asociadas.
     *
     * @param  array  $data
     * @param  \Illuminate\Http\UploadedFile|null  $image
     * @return \App\Models\Post
     *
     * @throws \Throwable
     */
    public function create(array $data, ?UploadedFile $image): Post
    {
        $data['image'] = $image?->store('posts', 'public');

        try {
            return DB::transaction(function () use ($data) {
                $tags = $data['tags'] ?? [];
                unset($data['tags']);

                $post = Post::create($data);
                $post->tags()->sync($tags);

                return $post;
            });
        } catch (\Throwable $e) {
            $this->deleteImage($data['image']);

            throw $e;
        }
    }

    /**
     * Actualiza un post y, si corresponde, reemplaza su imagen y etiquetas.
     *
     * @param  \App\Models\Post  $post
     * @param  array  $data
     * @param  \Illuminate\Http\UploadedFile|null  $image
     * @return \App\Models\Post
     *
     * @throws \Throwable
     */
    public function update(Post $post, array $data, ?UploadedFile $image): Post
    {
        $oldImage = $post->image;
        $newImage = $image?->store('posts', 'public');

        try {
            $post = DB::transaction(function () use ($post, $data, $newImage) {
                if ($newImage) {
                    $data['image'] = $newImage;
                }

                $tags = $data['tags'] ?? [];
                unset($data['tags']);

                $post->update($data);
                $post->tags()->sync($tags);

                return $post;
            });
        } catch (\Throwable $e) {
            $this->deleteImage($newImage);

            throw $e;
        }

        if ($newImage) {
            $this->deleteImage($oldImage);
        }

        return $post;
    }

    /**
     * Elimina un post.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function delete(Post $post): void
    {
        $post->delete();
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
