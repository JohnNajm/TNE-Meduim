<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        ListingResource::withoutWrapping();
        dd($this->file('image')->path());
        return [
            'listing'    => [
                'title' => $this->title,
                'content' => $this->content,
                'visibility' => $this->visibility,
                'user' => $this->user_id,
                'category' => $this->category_id,
            ],
            'image'    => [
                'name' => $this->file('image')->name(),
                'path' => $this->file('image')->path(),
            ],
        ];
    }
}
