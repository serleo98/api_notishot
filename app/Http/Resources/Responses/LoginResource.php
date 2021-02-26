<?php

namespace App\Http\Resources\Responses;

use App\Http\Resources\User\ProfileResource;
use App\Http\Resources\User\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'id' => $this->token->user->id,
            'nick_name' => $this->token->user->nick_name,
            'email' => $this->token->user->email,
            'token' => $this->accessToken,
            'tokenType' => 'Bearer',
            'role' => new RoleResource($this->token->user->role),
            'profile' => new ProfileResource($this->token->user->profile),
        ];
    }
}
