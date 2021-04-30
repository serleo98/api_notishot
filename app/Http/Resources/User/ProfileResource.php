<?php

namespace App\Http\Resources\User;

use App\Entities\User\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'  => $this->name,
            'last_name'  => $this->last_name,
            'cel_phone'  => $this->cel_phone,
            'phone'  => $this->phone,
            'profile_photo'  => $this->profile_photo,
            'facebook_url'  => $this->facebook_url,
            'instagram_url'  => $this->instagram_url,
            'twitter_url'  => $this->twitter_url,
            'blog_personal_url'  => $this->blog_personal_url,
            'city'  => $this->city,
            'province'  => $this->province,
            'country'  => $this->country,
            'postal_code'  => $this->postal_code,
            'accepted'  => $this->accepted,
            'accepted_by'  => ($this->accepted) ? new UserResource($this->acceptedBy) : null,
            'accepted_at'  => Carbon::parse($this->accepted_at)->format('Y-m-d'),
        ];
    }
}
