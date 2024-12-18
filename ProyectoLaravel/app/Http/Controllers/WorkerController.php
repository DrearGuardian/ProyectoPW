<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkersController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:Workers,name|min:3',
            'description' => 'min:10'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'status' => 400,
                'errors' => $validator->errors()
            ],400);
        }

        $Worker = Worker::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? '0'
            ]);

        return new JsonResponse([
            'status' => 200,
            'msg' => 'Se Guardo correctamente',
            'Workers' => $Worker
        ],200);

    }

    public function getWorkers()
    {
        $Workers = Worker::all();

        return new JsonResponse([
            'status' =>200,
            'Workers' => $Workers
        ],200);
    }

    public function getWorker($id)
    {
        $Worker = Worker::find($id);

        if(!$Worker){
            return new JsonResponse([
                'status' =>404,
                'msg' => 'No se encontro el Worker con el id: ' . $id
            ],404);
        }

        return new JsonResponse([
            'status' =>200,
            'Workers' => $Worker
        ],200);
    }

        public function updateWorker(Request $request, $id)
        {
            $Worker = Worker::find($id);

        if(!$Worker){
            return new JsonResponse([
                'status' =>404,
                'msg' => 'No se encontro el Worker con el id: ' . $id
            ],404);

            }

            $validator = Validator::make($request->all(),[
                'name' => 'min:3',
                'description' => 'min:10'
            ]);

            if($validator->fails()){
                return new JsonResponse([
                    'status' => 400,
                    'errors' => $validator->errors()
                ],400);
            }

            $Worker->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);

            return new JsonResponse([
                'status' => 200,
                'msg' => 'Worker Actualizado',
                'Worker' => $Worker
            ],200);
        }

        public function delete($id)
        {
            $Worker = Worker::find($id);

            if (!$Worker){
                return new JsonResponse([
                    'status' => 404,
                    'msg' => 'No se encontro el Worker con el id:' .$id
                ]);
            }

            $Worker->delete();
            return new JsonResponse([
                'status' => 200,
                'msg' => 'El Worker ha sido eliminado',
                'Worker' => $Worker
            ],200);
        }
    }
