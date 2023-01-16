<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'title' => $this->title,
            'column_id' => $this->column_id,
            'description' => $this->description,
            'position' => $this->position,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
