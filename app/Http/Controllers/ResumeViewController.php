<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ResumeViewController extends Controller
{
    public function index()
    {
        $resumes = Resume::latest()->get();
        return view('resumes.index', compact('resumes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf|max:10240',
        ], [
            'cv_file.required' => 'File CV wajib diupload.',
            'cv_file.mimes'    => 'File harus berformat PDF.',
            'cv_file.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        // Save file
        $file     = $request->file('cv_file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Create directory if it doesn't exist
        $uploadDir = public_path('cv_uploads/');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file->move($uploadDir, $fileName);

        $fileUrl  = url('cv_uploads/' . $fileName);

        // Deactivate all existing resumes
        Resume::query()->update(['is_active' => false]);

        // Create new active resume
        Resume::create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => 'cv_uploads/' . $fileName,
            'file_url'  => $fileUrl,
            'is_active' => true,
        ]);

        return redirect()->route('resumes.index')->with('success', 'CV berhasil diupload dan diaktifkan!');
    }

    public function setActive($id)
    {
        // Deactivate all
        Resume::query()->update(['is_active' => false]);

        // Activate selected
        $resume = Resume::findOrFail($id);
        $resume->update(['is_active' => true]);

        return redirect()->route('resumes.index')->with('success', 'CV "' . $resume->file_name . '" sekarang aktif!');
    }

    public function show($filename)
    {
        $path = public_path('cv_uploads/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    }

    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);

        // Delete physical file
        if (File::exists(public_path($resume->file_path))) {
            File::delete(public_path($resume->file_path));
        }

        $wasActive = $resume->is_active;
        $resume->delete();

        // If the deleted one was active, set the latest remaining as active
        if ($wasActive) {
            $latest = Resume::latest()->first();
            if ($latest) {
                $latest->update(['is_active' => true]);
            }
        }

        return redirect()->route('resumes.index')->with('success', 'CV berhasil dihapus!');
    }
}
