<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'             => $this->id,
            'image_type'     => $this->image_type, 
            'image_url'      => asset('storage/'.$this->image_url),
            'updated_at'     => $this->updated_at,
            'created_at'     => $this->created_at,
        ];
    }
}
