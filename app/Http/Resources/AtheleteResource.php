<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AtheleteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'first_name' => $this->first_name ?? null,
            'last_name' => $this->last_name ?? null,
            'email' => $this->email ?? null,
            'role' => $this->role ? $this->role->name : null,
            'gender' => $this->gender ?? null,
            'avatar'    => $this->avatar ? asset($this->avatar) : null,
            'team' => $this->team ?? null, 
            'created_at' => $this->created_at->format('Y-m-d') ?? null,
        ];
    }
}
