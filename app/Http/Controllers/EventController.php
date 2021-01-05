<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Mail;

class EventController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
    try {
        $events = Event::with([
            'fk_user' => function ($q) {
                return $q;
            }, 'fk_sector' => function ($q) {
                return $q;
            }
        ])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'result' => $events,
            'message' => 'Todos os eventos foram exibidos com sucesso.'
        ], 202);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 401);
    }
}

    /**
     * Register a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|between:2,100',
                'auditory' => 'required|string|between:2,100',
                'event_type' => 'required|string|between:2,100',
                'description' => 'required|string|between:2,5000',
                'people_quantity' => 'required|numeric|min:1',
                'status' => 'nullable|numeric',
                'fk_user' => 'nullable|numeric',
                'fk_sector' => 'nullable|numeric',
                'start_at' => 'required|date',
                'end_at' => 'required|date',
                'items' => 'required|array',
                'emails' => 'nullable|array'
                ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 422);
            } else {
                $event = Event::create(array_merge(
                    $validator->validated()));

                foreach ($request->emails as $email) {
                    $data = array(
                        'title' => $request->title,
                        'event_type'=> $request->event_type,
                        'fk_user'=> auth()->user()->name
                    );

                    Mail::send('neweventmail', $data, function($message) use ($email) {
                        $message->to($email)->subject
                            ('Aviso de evento');
                        $message->from('plataforma@gmail.com','Plataforma');
                    });
                }
            }

            return response()->json([
                'result' => $event,
                'message' => 'Evento registrado com sucesso.'
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
            $event = Event::find($id);
            $event->update($request->all());

            return response()->json([
                'result' => $event,
                'message' => 'Evento atualizado com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event {$id} $event
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $event = Event::find($id)->delete();

            return response()->json([
                'message' => 'Evento apagado com sucesso.'
            ], 200);
            } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
