<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ProjectViewController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'url' => 'required',
            'foto' => 'required|image',

        ]);

        // Upload gambar utama
        $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->foto->move(public_path('fotoproject/'), $imageName);


        // Upload semua icon tech
        $techPaths = [];


        if ($request->hasFile('tech')) {
            foreach ($request->file('tech') as $techImg) {
                if ($techImg->isValid()) {
                    $filename = time() . '_' . $techImg->getClientOriginalName();
                    $techImg->move(public_path('techstack/'), $filename);
                    $techPaths[] = asset('techstack/' . $filename);
                }
            }
        }


        Project::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'url' => $request->url,
            'foto' => $imageName,
            'image_url' => asset('fotoproject/' . $imageName),
            'slug' => Str::slug($request->judul),
            'author_id' => 1,
            'tech' => json_encode($techPaths),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'url' => $request->url,
            'tech' => json_encode($request->tech),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus');
    }
}
