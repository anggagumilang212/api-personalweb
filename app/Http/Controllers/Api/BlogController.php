<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function show($id)
    {
        $blog = \App\Models\Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Not found'], 404);
        }
        
        // Add required user object for frontend SEO metadata
        $blog->user = [
            'name' => 'Angga Gumilang',
            'username' => 'anggagumilang212',
            'profile_image' => 'https://res.cloudinary.com/dnlrqdzbv/image/upload/c_crop,ar_1:1/v1770018519/me2_yaijiu.png'
        ];
        
        // Add fake body_html for ReaderPage
        $blog->body_html = '<p>' . nl2br(e($blog->body_markdown)) . '</p>';

        return response()->json($blog);
    }

    /**
     * GET /api/blogs
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return BlogResource::collection($blogs)->additional(['message' => 'Data blogs fetched successfully']);
    }

    /**
     * GET /api/blogs/{id}
     */
    public function detail($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        return (new BlogResource($blog))->additional(['message' => 'Blog detail fetched successfully']);
    }

    /**
     * POST /api/create-blogs
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'        => 'required|max:255',
            'description'  => 'nullable',
            'body_markdown' => 'nullable',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'published_at' => 'nullable|date',
        ], [
            'required' => ':attribute harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coverImageName = null;
        $coverImageUrl  = null;

        if ($request->hasFile('cover_image')) {
            $coverImageName = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('cover_images/'), $coverImageName);
            $coverImageUrl = URL::to('/cover_images/' . $coverImageName);
        }

        $blog = Blog::create([
            'title'          => $request->title,
            'slug'           => Str::slug($request->title, '-'),
            'description'    => $request->description,
            'body_markdown'  => $request->body_markdown,
            'cover_image'    => $coverImageName,
            'comments_count' => 0,
            'published_at'   => $request->published_at,
        ]);

        return (new BlogResource($blog))->additional(['message' => 'Blog created successfully']);
    }

    /**
     * PUT /api/update-blogs/{id}
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'        => 'required|max:255',
            'description'  => 'nullable',
            'body_markdown' => 'nullable',
            'cover_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updateData = [
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'description'   => $request->description,
            'body_markdown' => $request->body_markdown,
            'published_at'  => $request->published_at,
        ];

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama
            if ($blog->cover_image && File::exists(public_path('cover_images/' . $blog->cover_image))) {
                File::delete(public_path('cover_images/' . $blog->cover_image));
            }

            $coverImageName = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('cover_images/'), $coverImageName);
            $updateData['cover_image'] = $coverImageName;
        }

        $blog->update($updateData);

        return (new BlogResource($blog))->additional(['message' => 'Blog updated successfully']);
    }

    /**
     * DELETE /api/delete-blogs/{id}
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        if ($blog->cover_image && File::exists(public_path('cover_images/' . $blog->cover_image))) {
            File::delete(public_path('cover_images/' . $blog->cover_image));
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
