<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:products,name|min:3',
            'description' => 'min:10'
        ]);

        if($validator->fails()){
            return new JsonResponse([
                'status' => 400,
                'errors' => $validator->errors()
            ],400);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price ?? '0'
            ]);

        return new JsonResponse([
            'status' => 200,
            'msg' => 'Se Guardo correctamente',
            'products' => $product
        ],200);

    }

    public function getProducts()
    {
        $products = Product::all();

        return new JsonResponse([
            'status' =>200,
            'products' => $products
        ],200);
    }

    public function getProduct($id)
    {
        $product = Product::find($id);

        if(!$product){
            return new JsonResponse([
                'status' =>404,
                'msg' => 'No se encontro el producto con el id: ' . $id
            ],404);
        }

        return new JsonResponse([
            'status' =>200,
            'products' => $product
        ],200);
    }

        public function updateProduct(Request $request, $id)
        {
            $product = Product::find($id);

        if(!$product){
            return new JsonResponse([
                'status' =>404,
                'msg' => 'No se encontro el producto con el id: ' . $id
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

            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);

            return new JsonResponse([
                'status' => 200,
                'msg' => 'Producto Actualizado',
                'product' => $product
            ],200);
        }

        public function delete($id)
        {
            $product = Product::find($id);

            if (!$product){
                return new JsonResponse([
                    'status' => 404,
                    'msg' => 'No se encontro el producto con el id:' .$id
                ]);
            }

            $product->delete();
            return new JsonResponse([
                'status' => 200,
                'msg' => 'El producto ha sido eliminado',
                'product' => $product
            ],200);
        }
    }
