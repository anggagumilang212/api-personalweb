<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorController extends Controller
{

    public function index()
    {
        $author = Author::all();
        return AuthorResource::collection($author)->additional(['message' => 'Data authors successfully']);
    }
}
