<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $data = [
                'message' => 'No hay usuarios registrados',
                'status' => 200
            ];

            return response()->json($data, 200);
        }

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mail' => 'required|email|unique:user',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'mail' => $request->mail,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);

        if (!$user) {
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'user' => $user,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'user' => $user,
            'status' => 200
        ];

        return response()->json($data, 200);
}

public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        $data = [
            'message' => 'Usuario no encontrado',
            'status' => 404
        ];
        return response()->json($data, 404);
    }
    
    $user->delete();

    $data = [
        'message' => 'Usuario eliminado',
        'status' => 200
    ];

    return response()->json($data, 200);
}

public function update(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        $data = [
            'message' => 'Usuario no encontrado',
            'status' => 404
        ];
        return response()->json($data, 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'mail' => 'required|email|unique:user',
        'phone' => 'required|digits:10',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        $data = [
            'message' => 'Error en la validación de los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data, 400);
    }

    $user->name = $request->name;
    $user->last_name = $request->last_name;
    $user->mail = $request->mail;
    $user->phone = $request->phone;
    $user->password = bcrypt($request->password);

    $user->save();

    $data = [
        'message' => 'Usuario actualizado',
        'user' => $user,
        'status' => 200
    ];

    return response()->json($data, 200);
}

}
