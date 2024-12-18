<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'id_rol' => 'required|integer',
            'rol' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_rol' => $request->id_rol,
            'rol' => $request->rol,
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'Usuario creado correctamente',
            'user' => $user,
        ], 200);
    }

    public function getUsers(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'status' => 200,
            'users' => $users,
        ], 200);
    }

    public function getUser($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'msg' => 'No se encontró el usuario con el id: ' . $id,
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'user' => $user,
        ], 200);
    }

    public function updateUser(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'msg' => 'No se encontró el usuario con el id: ' . $id,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'min:3',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'id_rol' => 'integer',
            'rol' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'id_rol' => $request->id_rol ?? $user->id_rol,
            'rol' => $request->rol ?? $user->rol,
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'Usuario actualizado',
            'user' => $user,
        ], 200);
    }

    public function delete($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'msg' => 'No se encontró el usuario con el id: ' . $id,
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'El usuario ha sido eliminado',
        ], 200);
    }
}
