<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Meeting;

use Mail;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $meeting = Meeting::with([
                'fk_user' => function ($q) {
                    return $q;
                }, 'fk_sector' => function ($q) {
                    return $q;
                }
            ])
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'result' => $meeting,
                'message' => 'Todas as reuniões foram exibidas com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
   * GetMySector function, returns all meetings with his sector by given ID
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getMySector($sectorID) {
    try {
      $meeting = Meeting::where('fk_sector', '=', $sectorID)
      ->orderby('created_at', 'asc')
      ->get();

      return response()->json([
          'result' => $meeting,
          'message' => 'Todas as reuniões do setor informado foram exibidas com sucesso.'
      ], 202);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 401);
    }
  }

    /**
   * Register a new meeting
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request) {
    try {
      $validator = Validator::make($request->all(), [
        'title' => 'required|string|between:2,100',
        'description' => 'required|string|between:2,5000',
        'motif' => 'required|string|between:2,200',
        'room' => 'required|string|between:2,100',
        'start_at' => 'required|date_format:H:i',
        'end_at' => 'required|date_format:H:i',
        'date' => 'required|date',
        'status' => 'nullable|numeric',
        'fk_user' => 'nullable|numeric',
        'fk_sector' => 'nullable|numeric'
      ]);

    //   foreach ($request->overEvent as $value) {
    //     $user = \App\Models\User::find($meeting->fk_user);
    //     $data = array(
    //     'name'=> $user->name,
    //     'lastName'=> $user->surname
    //     );

    //     Mail::send('deletemeeting', $data, function($message) use ($user) {
    //         $message->to($user->email, $user->name)
    //         ->subject('Status da reunião');
    //         $message->from('plataforma@gmail.com','Plataforma');
    //     });
    //     $this->doDelete($value);
    //   }
    if ($validator->fails()) {
        return response()->json([
            'message' => $validator->errors()->first(),
        ], 422);
    } else {
        $meeting = Meeting::create(array_merge(
            $validator->validated()));
    }

      return response()->json([
          'result' => $meeting,
          'message' => 'Reunião criada com sucesso.'
        ], 202);

    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 401);
    }
  }

    /**
     * Edit a created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $meeting = Meeting::find($id);
            $meeting->update($request->all());

            return response()->json([
                'result' => $meeting,
                'message' => 'Reunião atualizada com sucesso.'
            ], 202);
          } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  {$id}  meetingID to be deleted
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $sector = Meeting::find($id)->delete();

            return response()->json([
                'message' => 'Reunião apagada com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
