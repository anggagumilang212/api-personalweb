<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogViewController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('blogs.index', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|max:255',
            'description'  => 'nullable',
            'body_markdown' => 'nullable',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'published_at' => 'nullable|date',
        ]);

        $coverImageName = null;

        if ($request->hasFile('cover_image')) {
            $coverImageName = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('cover_images/'), $coverImageName);
        }

        Blog::create([
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'description'   => $request->description,
            'body_markdown' => $request->body_markdown,
            'cover_image'   => $coverImageName,
            'comments_count' => 0,
            'published_at'  => $request->published_at,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'        => 'required|max:255',
            'description'  => 'nullable',
            'body_markdown' => 'nullable',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'published_at' => 'nullable|date',
        ]);

        $updateData = [
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'description'   => $request->description,
            'body_markdown' => $request->body_markdown,
            'published_at'  => $request->published_at,
        ];

        if ($request->hasFile('cover_image')) {
            if ($blog->cover_image && File::exists(public_path('cover_images/' . $blog->cover_image))) {
                File::delete(public_path('cover_images/' . $blog->cover_image));
            }

            $coverImageName = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('cover_images/'), $coverImageName);
            $updateData['cover_image'] = $coverImageName;
        }

        $blog->update($updateData);

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->cover_image && File::exists(public_path('cover_images/' . $blog->cover_image))) {
            File::delete(public_path('cover_images/' . $blog->cover_image));
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus!');
    }
}
