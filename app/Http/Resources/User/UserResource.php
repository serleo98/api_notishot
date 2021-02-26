<?php

namespace App\Http\Resources\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!isset($this->id)){
            return null;
        }

        return array(
            'id' => $this->id,
            'nick_name' => $this->nick_name,
            'email' => $this->email,
            'role' => new RoleResource($this->role),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'profile' => new ProfileResource($this->profile),
        );
    }
}
