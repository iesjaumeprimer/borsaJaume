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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


abstract class ApiBaseController extends Controller
{
    protected $resource;
    protected $entity;

    public function __construct(){
       $this->resource = 'App\Http\Resources\\'.$this->model().'Resource';
       $this->entity = 'App\Entities\\'.$this->model();
    }

    public function index(){
        return $this->resource::collection($this->entity::all());
    }

    public function show($id){
        return new $this->resource($this->entity::find($id));
    }

    public function destroy($id)
    {
        if ($this->entity::destroy($id)) return response(1,200);

        return response("No he pogut Esborrar $id",400);
    }

    public function store(Request $request)
    {
        if ($errors = $this->validate($request, $this->rules())) return $this->response($errors);

        return $this->manageResponse($this->entity::create($request->all()),$request);
    }

    public function update(Request $request, $id)
    {
        if ($errors = $this->validate($request, $this->rules())) return $this->response($errors);

        $registro = $this->entity::find($id);
        $registro->update($request->all());

        return $this->manageResponse($registro,$request);

    }

    protected function manageResponse($registro, Request $request){

        return new $this->resource($registro);
    }




    public function validate(Request $request, array $rules, array $messages = Array(), array $customAttributes = Array()){

        $validation = Validator::make($request->toArray(),$rules);

        if ($validation->fails()) return $validation->errors()->toArray();

        return false;
    }

    protected function response(array $errors)
    {
        $transformed = [];

        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0]
            ];
        }

        return response()->json([
            'errors' => $transformed
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    public abstract function model();

    public function rules(){
        return [];
    }


}