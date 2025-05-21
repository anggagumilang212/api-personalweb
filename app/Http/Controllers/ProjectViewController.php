<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;

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

        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'url' => 'required',
            'foto' => 'nullable|image',
        ]);

        // Update data dasar
        $updateData = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'url' => $request->url,
        ];

        // Update foto project jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($project->foto && File::exists(public_path('fotoproject/' . $project->foto))) {
                File::delete(public_path('fotoproject/' . $project->foto));
            }

            // Upload foto baru
            $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->foto->move(public_path('fotoproject/'), $imageName);

            // Update path foto
            $updateData['foto'] = $imageName;
            $updateData['image_url'] = asset('fotoproject/' . $imageName);
        }

        // Update tech stack icons jika ada
        if ($request->hasFile('tech')) {
            $currentTech = json_decode($project->tech) ?? [];
            $newTechPaths = [];

            // Upload icon tech baru
            foreach ($request->file('tech') as $techImg) {
                if ($techImg->isValid()) {
                    $filename = time() . '_' . $techImg->getClientOriginalName();
                    $techImg->move(public_path('techstack/'), $filename);
                    $newTechPaths[] = asset('techstack/' . $filename);
                }
            }

            // Jika keep_tech ada dan bernilai 1, gabungkan dengan tech stack yang sudah ada
            if ($request->has('keep_tech') && $request->keep_tech == 1) {
                $updateData['tech'] = json_encode(array_merge($currentTech, $newTechPaths));
            } else {
                // Hapus tech stack lama jika tidak dipertahankan
                foreach ($currentTech as $techPath) {
                    $techFilename = basename($techPath);
                    if (File::exists(public_path('techstack/' . $techFilename))) {
                        File::delete(public_path('techstack/' . $techFilename));
                    }
                }
                $updateData['tech'] = json_encode($newTechPaths);
            }
        }

        $project->update($updateData);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Hapus file foto utama
        if ($project->foto && File::exists(public_path('fotoproject/' . $project->foto))) {
            File::delete(public_path('fotoproject/' . $project->foto));
        }

        // Hapus file tech stack
        $techPaths = json_decode($project->tech) ?? [];
        foreach ($techPaths as $techPath) {
            $techFilename = basename($techPath);
            if (File::exists(public_path('techstack/' . $techFilename))) {
                File::delete(public_path('techstack/' . $techFilename));
            }
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus');
    }
}
