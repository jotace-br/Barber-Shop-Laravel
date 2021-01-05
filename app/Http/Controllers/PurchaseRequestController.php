<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

use Mail;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $purchaseRequests = PurchaseRequest::with([
                'fk_user' => function ($q) {
                    return $q;
                }, 'fk_sector' => function ($q) {
                    return $q;
                }
            ])
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'result' => $purchaseRequests,
                    'message' => 'Todas as requisições de compras foram exibidas com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|between:2,100',
                'value' => 'required|string|between:2,100',
                'description' => 'required|string|between:2,5000',
                'observation' => 'required|string|between:2,1000',
                'fk_user' => 'nullable|numeric',
                'fk_sector' => 'nullable|numeric',
                'request_date' => 'required|date',
                'request_stage' => 'required|string|between:2,100',
                'url' => 'nullable|url',
                'quantity' => 'required|numeric|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 422);
            } else {
                $purchaseRequest = PurchaseRequest::create(array_merge(
                    $validator->validated()));
            }

            return response()->json([
                'result' => $purchaseRequest,
                'message' => 'Registrado com Sucesso'
            ], 202);

          } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
          }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  {$id}  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $purchaseRequest = PurchaseRequest::find($id);

            $user = \App\Models\User::find($purchaseRequest->fk_user);

            if ($request->request_stage !== $purchaseRequest->request_stage) {
              $data = array(
                  'name'=> $user->name,
                  'surname'=> $user->surname,
                  'request_name' => $request->product_name,
                  'request_stage' => $request->request_stage,
                  'request_date' => $request->request_date,
                  'quantity' => $request->quantity,
                  'reason' => $request->reason
                );

              Mail::send('updatepurchaserequest', $data, function($message) use ($user) {
                 $message->to($user->email, $user->name)->subject
                    ('Requisição de compra');
                 $message->from('plataforma@gmail.com','Plataforma');
              });
            }

            $purchaseRequest->update($request->all());

            return response()->json([
                'result' => $purchaseRequest,
                'message' => 'Requisição de compra atualizada com sucesso.'
            ], 202);
          } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseRequest  {$id}
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $purchaseRequest = PurchaseRequest::find($id)->delete();

            return response()->json([
                'message' => 'Requisição de compra apagada com sucesso.'
            ], 200);
          } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
          }
    }
}
