<?php

namespace App\Http\Resources\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class VerificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->user->id,
            'user' => $this->user->name,
            'email' => $this->user->email,
            'resent' => $this->resent,
            'verified' => $this->verified,
        ];
    }
}
