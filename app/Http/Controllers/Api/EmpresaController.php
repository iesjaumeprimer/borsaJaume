<?php

namespace App\Http\Controllers\Api;

use App\Entities\Empresa;

class EmpresaController extends ApiBaseController
{

    public function model(){
        return 'Empresa';
    }

    public function destroy($id)
    {
        $thereIsAndOffer = Empresa::find($id)->Ofertas()->where('archivada',0)->count();
        if ($thereIsAndOffer) return response("L'empresa té ofertes. Esborra-les primer",400);

        if (Empresa::destroy($id)) return response(1,200);

        return response("No he pogut Esborrar $id",400);
    }

    public function index()
    {
        if (AuthUser()->isEmpresa())
            return EmpresaResource::collection(Empresa::where('id',AuthUser()->id)->get());
        if (AuthUser()->isAlumno())
            return EmpresaResource::collection(Empresa::OfertasCiclo(AuthUser()->id));
        if (AuthUser()->isAdmin() || AuthUser()->isResponsable()) return parent::index();
        return response('No autenticado',405);
    }
}
