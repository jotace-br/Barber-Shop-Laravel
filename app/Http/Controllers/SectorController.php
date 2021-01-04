<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Sector;

class SectorController extends Controller
{
    /**
     * Index function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $sector = Sector::orderby('created_at', 'asc')->get();

            return response()->json([
                'result' => $sector,
                'message' => 'Todos os setores foram exibidos com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * getNameById function, by passing an sector id, it should return the name of it.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNameById($id) {
        try {
            $sector = Sector::where('id', $id)->first();

            return response()->json([
                'result' => $sector->name,
                'message' => 'Setor capturado com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => 'SectorID não encontrado.'], 404);
        }
    }

    /**
     * getOnlyCompanies function, it only returns the companies.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnlyCompanies() {
        try {
            $sector = Sector::where('is_company', true)->get();

            return response()->json([
                'result' => $sector,
                'message' => 'Setores que são apenas empresas capturados com sucesso.'
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
            'is_company' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        } else {
            $sector = Sector::create(array_merge(
                $validator->validated()));
        }

        return response()->json([
          'result' => $sector,
          'message' => 'Setor criado com sucesso.'
        ], 202);

    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 401);
    }
  }

  /**
     * update function, used for update a sector
     *
     * @param {$request}: JSON with params
     * @param {$id}: user Id whose will be updated
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $sector = Sector::find($id);

            $sector->update($request->all());

            return response()->json([
                'result' => $sector,
                'message' => 'Setor atualizado com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * delete function, works by deleting an existent sector
     *
     * @param {$id}: id do usuario a ser apagado
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $sector = Sector::find($id)->delete();

            return response()->json([
                'message' => 'Setor apagado com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
