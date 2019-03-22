<?php
/**
 * Created by PhpStorm.
 * User: igomis
 * Date: 2019-03-04
 * Time: 12:02
 */

namespace App\Http\Controllers\Api;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ApiBaseResourceController extends Controller
{
    protected $resource;
    protected $class;
    protected $relationShip;


    public function __construct(){
       $this->resource = 'App\Http\Resources\\'.$this->model.'Resource';
       $this->class = 'App\Entities\\'.$this->model;
    }

    public function index(){
        return $this->resource::collection($this->class::all());
    }

    public function show($id){
        return new $this->resource($this->class::find($id));
    }

    public function destroy($id)
    {
        if ($this->class::destroy($id)) return response(1,200);

        return response("No he pogut Esborrar $id",400);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $registro = $this->class::create($request->all());
        if ($this->relationShip) $this->manageRelation($registro,$request);

        return response($this->show($registro->id),200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        $registro = $this->class::find($id);
        $registro->update($request->all());
        if ($this->relationShip) $this->manageRelation($registro,$request);
        return response($this->show($registro->id),200);
    }

    protected function manageRelation($registro,Request $request)
    {
        $relation = $this->relationShip;
        $registro->$relation()->sync($request->$relation);
    }


}