<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * @var service
     */
    private $userService;

    /**
     * Instantiate a new RoleController instance.
     * @param RoleRepository $userRepositoryInterface
     */
    public function __construct(UserRepository $userRepositoryInterface)
    {
        //$this->middleware(['auth:api']);
        $this->userService = $userRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $users = $this->userService->all();

            return response()->json(['status' => 'success', 'message' => count($users) ==0 ? 'Aucune donnée' : null, 'data' => $users], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allWithTrashed()
    {

        try {

            $users = $this->userService->allWithTrashed();

            return response()->json(['status' => 'success', 'message' => null, 'data' => $users], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = $this->userService->create($request->all());

            DB::commit(); // commit all modification in database

            return response()->json(['status' => 'success', 'message' => "Le compte utilisateur a bien été crée", 'data' => $user], Response::HTTP_OK);
            
        } catch (\Throwable $th) {

            DB::rollback(); // roll back all modification from database

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Cofirm user account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm_user(Request $request)
    {
        try {

            $response = $this->userService->confirm_user($request->all());

            return response()->json(['status' => 'success', 'message' => null, 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $user = $this->userService->find($id);

            return response()->json(['status' => 'success', 'message' => "Le compte utilisateur a bien été crée", 'data' => $user], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $user = $this->userService->update($request->all(), $id);

            DB::commit(); // commit all modification in database

            return response()->json(['status' => 'success', 'message' => "Le compte utilisateur a bien été modifié", 'data' => $user], Response::HTTP_OK);

        } catch (\Throwable $th) {

            DB::rollback(); // roll back all modification from database

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = $this->userService->delete($id);

            return response()->json(['status' => 'success', 'message' => "Le compte utilisateur a bien été supprimé", 'data' => $user], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        try {

            $user = $this->userService->destroy($id);

            return response()->json(['status' => 'success', 'message' => "Le compte utilisateur a totalement été supprimé de la base", 'data' => $user], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
