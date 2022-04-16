<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\PermissionRequest;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class PermissionController extends Controller
{

    /**
     * @var service
     */
    private $permissionService;

    /**
     * Instantiate a new PermissionController instance.
     * @param PermissionRepository $permissionRepositoryInterface
     */
    public function __construct(PermissionRepository $permissionRepositoryInterface)
    {
        //$this->middleware(['auth:api']);
        $this->permissionService = $permissionRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        

        try {
            
            $permissions = $this->permissionService->all();

            return response()->json(['status' => 'success', 'message' =>  count($permissions) ==0 ? 'Aucune donnée' : null, 'data' => $permissions], Response::HTTP_OK);
        
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
            
            $permissions = $this->permissionService->allWithTrashed();

            return response()->json(['status' => 'success', 'message' => null, 'data' => $permissions], Response::HTTP_OK);
        
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
    public function store(PermissionRequest $request)
    {
        try {
            
            $permission = $this->permissionService->create(Arr::only($request->all(),'name'));

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été crée", 'data' => $permission], Response::HTTP_OK);
        
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
            
            $permission = $this->permissionService->find($id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été crée", 'data' => $permission], Response::HTTP_OK);
        
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
        try {
            
            $permission =  $this->permissionService->update(Arr::only($request->all(),'name'),$id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été modifié", 'data' => $permission], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
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
            
            $permission = $this->permissionService->delete($id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a bien été supprimé", 'data' => $permission], Response::HTTP_OK);
        
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
            
            $permission = $this->permissionService->destroy($id);

            return response()->json(['status' => 'success', 'message' => "Le rôle a totalement été supprimé de la base", 'data' => $permission], Response::HTTP_OK);
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
