<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
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
            'id' => $this->id,
            'cif' => $this->cif,
            'nombre' => $this->nombre,
            'domicilio' => $this->domicilio,
            'localidad' => $this->localidad,
            'contacto' => $this->contacto,
            'web' => $this->web,
            'telefono' => $this->telefono,
            'email' => $this->User->email,
            'descripcion' => $this->descripcion
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
