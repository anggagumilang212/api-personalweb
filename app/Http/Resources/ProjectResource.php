<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'foto' => $this->foto,
            'deskripsi' => $this->deskripsi,
            'image_url' => $this->image_url,
            'slug' => $this->slug,
            'url' => $this->url,
            'author' => $this->author,
            Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            Carbon::parse($this->updated_at)->format('d-m-Y'),
        ];
    }
}
