<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'description'    => $this->description,
            'body_markdown'  => $this->body_markdown,
            'body_html'      => '<p>' . nl2br(e($this->body_markdown)) . '</p>',
            'cover_image'    => $this->cover_image,
            'cover_image_url' => $this->cover_image
                ? url('cover_images/' . $this->cover_image)
                : null,
            'comments_count' => $this->comments_count,
            'page_views_count' => $this->page_views_count,
            'published_at'   => $this->published_at
                ? Carbon::parse($this->published_at)->toIso8601String()
                : null,
            'created_at'     => Carbon::parse($this->created_at)->toIso8601String(),
            'updated_at'     => Carbon::parse($this->updated_at)->toIso8601String(),
        ];
    }
}
