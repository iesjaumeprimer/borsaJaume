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
        $data = [
            'id' => $this->id,
            'cif' => $this->cif,
            'nombre' => $this->nombre,
            'domicilio' => $this->domicilio,
            'localidad' => $this->localidad,
            'web' => $this->web,
            'descripcion' => $this->descripcion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        if (!AuthUser()->isAlumno()) {
            $data['contacto'] = $this->contacto;
            $data['telefono'] = $this->telefono;
            $data['email'] = $this->User->email;
            $data['prova']="provando";
        } else {
            $data['prova']="alumno";
        }
        return $data;
    }
}
