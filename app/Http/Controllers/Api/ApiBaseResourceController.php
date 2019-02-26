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
    private $resource;
    private $class;

    public function __construct(){
       $this->resource = 'App\Http\Resources\\'.$this->model.'Resource';
       $this->class = 'App\Entities\\'.$this->model;
    }
    public function index(){
        return new $this->resource($this->class::all());
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
        return response($this->class::create($request->all()),200);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, $this->rules);
        $registro = $this->class::find($id);
        $registro->update($request->all());
        $registro->save();
        return response($registro,200);
    }


}