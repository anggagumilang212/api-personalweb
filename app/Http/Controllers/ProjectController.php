<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function index()
    {
        $project = Project::all();
        return ProjectResource::collection($project)->additional(['message' => 'Data projects successfully']);

    }

    public function detail($id)
    {
        $project = Project::with('author:id,name')->find($id);
        return new ProjectDetailResource($project);
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'url' => 'required',
            'author_id' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ], [
            'required' => ':attribute harus diisi.',
        ]);
        $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->foto->move(public_path('fotoproject/'), $imageName);
        $imageUrl = URL::to('/core/public/fotoproject/' . $imageName);
        $project = Project::create(
            [
                'judul' => $request->judul,
                'foto' => $imageName,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'author_id' => $request->author_id,
                'slug' => Str::slug($request->judul, '-'),
                'image_url' => $imageUrl,
            ]
        );
        return (new ProjectDetailResource($project))->additional(['message' => 'Data created successfully']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required',
            'url' => 'required',
            'author_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        // Pengecekan apakah file foto diunggah
        if ($request->hasFile('foto')) {
            $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('fotoproject/'), $imageName);

            // Update data proyek termasuk foto jika diunggah
            $project->update([
                'judul' => $request->judul,
                'foto' => $imageName,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'author_id' => $request->author_id,
                'slug' => Str::slug($request->judul, '-'),
            ]);
        } else {
            // Update data proyek tanpa foto jika tidak diunggah
            $project->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'url' => $request->url,
                'author_id' => $request->author_id,
                'slug' => Str::slug($request->judul, '-'),
            ]);
        }

        return (new ProjectDetailResource($project))->additional(['message' => 'Data updated successfully']);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();
        return (new ProjectDetailResource($project))->additional(['message' => 'Data deleted successfully']);
    }

}
