<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Models\User;

use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    /**
     * uploadImage
     *
     * saves the sent image to the server
     *
     * @param {$request}: formData with the image path.
     */
    public function uploadImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profileImage' => 'image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'profileImage.max' => 'A imagem deve ser menor que 2GB.',
                'profileImage.mimes' => 'Os formatos aceitos são: jpeg, png e jpg.',
                'profileImage.image' => 'Só imagens são aceitas.'
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 422);
            } else {
                $image = $request->perfilImage;
                $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();  // Difine nome da imagem

                // Escolhe pasta de destino e gera imagem
                $destinationPath = public_path('/images/profiles');
                $img = Image::make($image->getRealPath());

                // Compressão digital para diminuir o peso das imagens
                $img->resize(300, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $input['imagename']);

                // retorna o caminho da imagem
                return response()->json(['result' => 'images/profiles/' . $input['imagename'], 'message' => 'Imagem salva com sucesso.'], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Index function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = User::orderby('created_at', 'desc')->get();

            return response()->json(['result' => $user, 'message' => 'Todos os usuários foram exibidos com sucesso.'], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Index function, filtered by status = 0
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPendences()
    {
        try {
            $user = User::orderby('created_at', 'desc')->where('status', '=', 0)->get();

            return response()->json(['result' => $user, 'message' => 'Todos os usuários foram exibidos com sucesso.'], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * getEmail function, get the email by giving a valid user Id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmail($id)
    {
        try {
            $user = User::where('id', $id)->first();

            return response()->json(['result' => $user->email, 'message' => 'E-mail capturado com sucesso.'], 202);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * listEmails function, works returning all emails from a selected sector
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listEmails($sectorId)
    {
        try {
            $user = User::where('fk_user_sector', $sectorId)->get();
            $array = array();

            foreach ($user as $value) {
                array_push($array, json_encode(array('email' => $value->email)));
            }

            return response()->json(['result' => $array, 'message' => 'E-mails do setor selecionado exibidos com sucesso.'], 202);
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

            if (File::exists($user->image) && $request->image !== $user->image) {
                File::delete($user->image);
            }

            $user->update($request->all());

            return response()->json(['result' => $user, 'message' => 'Usuário atualizado com sucesso.'], 202);
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

            return response()->json(['message' => 'Apagado com Sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
