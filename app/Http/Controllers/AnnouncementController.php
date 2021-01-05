<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $announcements = Announcement::with([
                'fk_user' => function ($q) {
                    return $q;
                }, 'fk_sector' => function ($q) {
                    return $q;
                }
            ])
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'result' => $announcements,
                'message' => 'Todos os comunicados foram exibidos com sucesso.'
            ], 202);
          } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
          }
    }

    /**
     * Display only the 5 latest announcements listed as
     * public in a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLastFiveOnes()
    {
        try {
            $fiveAnnouncements = Announcement::with([
                'fk_user' => function ($q) {
                    return $q;
                }, 'fk_sector' => function ($q) {
                    return $q;
                }
            ])
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'result' => $fiveAnnouncements,
                'message' => 'Apenas os 5 últimos comunicados marcados como públicos foram exibidos com sucesso.'
            ], 202);
          } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
          }
    }

        /**
     * Display only announcements listed as
     * public in a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPublicAnnouncements()
    {
        try {
            $announcements = Announcement::where('status', 1)
            ->orderby('created_at', 'asc')
            ->get();

            return response()->json([
                'result' => $announcements,
                'message' => 'Apenas os comunicados marcados como públicos foram exibidos com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Display only announcements with the
     * same sector as the logged user.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $id
     */
    public function indexOnlyMySectorAnnouncements()
    {
        try {
            $myAnnouncements = Announcement::where('fk_sector', auth()->user()->fk_user_sector)
            ->orderby('created_at', 'asc')
            ->get();

            return response()->json([
                'result' => $myAnnouncements,
                'message' => 'Apenas os comunicados feitos pelo setor do usuário logado foram exibidos com sucesso.'
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
                'name' => 'required|string|between:2,100',
                'announcement_date' => 'required|date',
                'description' => 'required|string|between:2,5000',
                'fk_user' => 'nullable|numeric',
                'fk_sector' => 'nullable|numeric',
                'status' => 'nullable|numeric',
                'url_link' => 'nullable|url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                ], 422);
            } else {
                $announcement = Announcement::create(array_merge(
                    $validator->validated()));
            }

            return response()->json([
                'result' => $announcement,
                'message' => 'Comunicado registrado com sucesso.'
            ], 202);

        } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */
    public function updadte(Request $request, $id)
    {
        try {
            $announcement = Announcement::find($id);
            $announcement->update($request->all());

            return response()->json([
                'result' => $announcement,
                'message' => 'Comunicado atualizado com sucesso.'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $announcement = Announcement::find($id)->delete();

            return response()->json([
                'message' => 'Comunicado apagado com sucesso.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
