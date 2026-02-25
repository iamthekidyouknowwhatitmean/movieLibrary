<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'films',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'tagline' => $this->tagline,
                'overview' => $this->overview,
                'release_date' => $this->release_date,
                'poster_path' => $this->poster_path,
                'backdrop_path' => $this->backdrop_path,
                'vote_average' => $this->vote_average,
                'vote_count' => $this->vote_count,
                'runtime' => $this->runtime
            ]
        ];
    }
}
