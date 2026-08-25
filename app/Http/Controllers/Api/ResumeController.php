<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resume;

class ResumeController extends Controller
{
    /**
     * GET /api/resume/active
     * Returns the currently active CV/Resume URL for the frontend.
     */
    public function active()
    {
        $resume = Resume::active()->latest()->first();

        if (!$resume) {
            return response()->json([
                'message' => 'No active resume found.',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'message' => 'Active resume fetched successfully.',
            'data'    => [
                'id'        => $resume->id,
                'file_name' => $resume->file_name,
                'file_url'  => $resume->file_url,
                'is_active' => $resume->is_active,
                'created_at' => $resume->created_at,
            ],
        ]);
    }

    /**
     * GET /api/resumes
     * Returns all resumes (for admin use).
     */
    public function index()
    {
        $resumes = Resume::latest()->get();
        return response()->json([
            'message' => 'Resumes fetched successfully.',
            'data'    => $resumes,
        ]);
    }
}
