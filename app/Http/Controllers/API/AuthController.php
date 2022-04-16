<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\ResetPasswordRequest;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    /**
     * @var service
     */
    private $authService;

    /**
     * Instantiate a new RoleController instance.
     * @param RoleRepository $authRepositoryInterface
     */
    public function __construct(AuthRepository $authRepositoryInterface)
    {
        $this->middleware(['auth:api'])->except(['login','reset_password']);
        $this->authService = $authRepositoryInterface;
    }



    /**
     * Log in user resource in to application.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {

            $response = $this->authService->login($request->all());

            return response()->json(['status' => 'success', 'message' => null, 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    /**
     * Get authentificated user information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        try {

            $response =  $this->authService->user();

            return response()->json(['status' => 'success', 'message' => null, 'data' => $response], Response::HTTP_OK);
        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Reset the resource user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_user_account(Request $request)
    {
        try {

            $response = $this->authService->check_user_account($request->all());

            return response()->json(['status' => 'success', 'message' => null, 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Reset the resource user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_reset_password_code(Request $request)
    {
        try {

            $response = $this->authService->verify_reset_password_code($request->all());

            return response()->json(['status' => 'success', 'message' => null, 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Reset the resource user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset_password(ResetPasswordRequest $request, $id)
    {
        try {

            $response = $this->authService->reset_password($request->all(), $id);

            return response()->json(['status' => 'success', 'message' => null, 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Logout the authenticate resource user  and remove session.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            
            $this->authService->logout();

            return response()->json(['status' => 'success', 'message' => 'Vous êtes déconnecté'], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verify_account(Request $request)
    {
        
        try {

            $response = $this->authService->verify_account($request->all());

            return response()->json(['status' => 'success', 'message' => 'Done', 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function confirm_account_verification_access(Request $request)
    {
        
        try {

            $response = $this->authService->confirm_account_verification_access($request->all());

            return response()->json(['status' => 'success', 'message' => 'Done', 'data' => $response], Response::HTTP_OK);

        } catch (\Throwable $th) {

            return response()->json(['status' => 'error', 'message' => $th->getMessage(), 'errors' => []], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
