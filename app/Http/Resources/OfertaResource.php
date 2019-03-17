<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfertaResource extends JsonResource
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
            'id'=>$this->id,
            'id_empresa' => $this->id_empresa,
            'descripcion' => $this->descripcion,
            'puesto' => $this->puesto,
            'tipo_contrato' => $this->tipo_contrato,
            'activa' => $this->activa,
            'contacto' => $this->contacto,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'validada' => $this->validada,
            'any' => $this->any,
            'archivada' => $this->archivada,
            'ciclos' => $this->myCiclos
        ];
    }



}
