<?php

namespace App\Http\Resources\Responses;

use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
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
            'user' => $this->token->user->name,
            'email' => $this->token->user->email,
            'token' => $this->accessToken,
            'tokenType' => 'Bearer',
            'verified' => ($this->token->user->email_verified_at) ? true : false,
//            'profiles' => $this->token->user->profiles()->pluck('description')->all(),
            'clients' => ClientResource::collection($this->token->user->userClients()->with('subsidiary')->get())
//            'modules' => array_unique($modules)
        ];
    }
}
