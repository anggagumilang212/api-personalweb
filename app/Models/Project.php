<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'judul',
        'deskripsi',
        'url',
        'author_id',
        'slug',
        'foto',
        'image_url',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
