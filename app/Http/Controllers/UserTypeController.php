<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\UserType;

class UserTypeController extends Controller
{
    /**
     * Index function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $userType = UserType::orderby('created_at', 'asc')->get();

            return response()->json([
                'result' => $userType,
                'message' => 'Todos os tipo de usuários foram exibidos com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

     /**
   * Register function
   *
   *  @return \Illuminate\Http\JsonResponse
   */
  public function register(Request $request) {
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        } else {
            $userType = UserType::create(array_merge(
                $validator->validated()));
        }

        return response()->json([
          'result' => $userType,
          'message' => 'Registrado com Sucesso.'
        ], 200);

    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 401);
    }
  }

  /**
     * update function, used for update a userType
     *
     * @param {$request}: JSON with params
     * @param {$id}: user Id whose will be updated
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $userType = UserType::find($id);

            $userType->update($request->all());

            return response()->json([
                'result' => $userType,
                'message' => 'Tipo de usuário atualizado com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * delete function, works by deleting an existent userType
     *
     * @param {$id}: id do usuario a ser apagado
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $userType = UserType::find($id)->delete();

            return response()->json([
                'message' => 'Tipo de usuário apagado com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
