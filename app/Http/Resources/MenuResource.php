<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'order' => $this->order,
            'Icon' => $this->Icon,
            'text' => $this->text,
            'path' => $this->path,
            'rol' => $this->rol,
            'parent' => $this->parent,
            'model' => $this->model,
            'active' => $this->active,
            'comments' => $this->comments,
            'icon_alt' => $thia->icon_alt,
        ];
    }
}
