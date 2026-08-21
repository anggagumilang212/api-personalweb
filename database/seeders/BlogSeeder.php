<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        Blog::truncate();
        
        Blog::create([
            'title' => 'Begini Cara Saya Upload Aplikasi di App Store dan Play Store',
            'slug' => 'begini-cara-saya-upload-aplikasi',
            'description' => 'Panduan lengkap upload aplikasi ke App Store dan Play Store agar proses review berjalan lebih cepat.',
            'cover_image' => 'https://res.cloudinary.com/dnlrqdzbv/image/upload/v1698930091/Angga/wa996smmq4yv0wgkoz0q.png',
            'body_markdown' => '# Panduan App Store\n\nIni adalah contoh isi artikel blog yang diambil dari database Laravel.',
            'comments_count' => 0,
            'published_at' => now(),
        ]);
        
        Blog::create([
            'title' => 'Membangun REST API dengan Laravel',
            'slug' => 'membangun-rest-api-dengan-laravel',
            'description' => 'Belajar membuat RESTful API menggunakan framework Laravel 10.',
            'cover_image' => 'https://res.cloudinary.com/dnlrqdzbv/image/upload/v1698930091/Angga/wa996smmq4yv0wgkoz0q.png',
            'body_markdown' => '# Belajar API Laravel\n\nIni adalah contoh kedua artikel di database lokal.',
            'comments_count' => 2,
            'published_at' => now()->subDays(2),
        ]);
    }
}
