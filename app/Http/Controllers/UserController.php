<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{

    /**
     * Index function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = User::orderby('created_at', 'asc')->get();

            return response()->json([
                'result' => $user,
                'message' => 'Todos os usuários foram exibidos com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * updateUser function, used for update a user (rly?)
     *
     * @param {$request}: JSON with params
     * @param {$id}: user Id whose will be updated
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            $user->update($request->all());

            return response()->json([
                'result' => $user,
                'message' => 'Usuário atualizado com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * deleteUser function, works by deleting an existent user
     *
     * @param {$id}: id do usuario a ser apagado
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser($id)
    {
        try {
            $user = User::find($id)->delete();

            return response()->json([
                'message' => 'Usuário apagado com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
