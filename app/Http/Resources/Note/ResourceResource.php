<?php

namespace App\Http\Resources\Note;

use App\Http\Resources\Note\NoteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceResource extends JsonResource
{
    public function toArray($request)
    {
        return
            [
                'type'  => $this->type,
                'route'  => $this->route,
            ];

    }
}