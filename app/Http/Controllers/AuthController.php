<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', (array)$validator->errors());
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            /** @var User $user */
            $user = User::create($input);

            $success['token'] = $user->createToken('url-shortener-api')->plainTextToken;
        } catch (\Exception $e) {
            Log::error('A problem has occurred.', [
                'message' => $e->getMessage()
            ]);
            return $this->sendError('A problem has occurred. Message ' . $e->getMessage());
        }

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            if (Auth::attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ])) {
                /** @var User $user */
                $user = Auth::user();

                $success['token'] = $user->createToken('url-shortener-api')->plainTextToken;
                $success['email'] = $user->email;

                return $this->sendResponse($success, 'User login successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Login fetch error.', [
                'message' => $e->getMessage()
            ]);
            return $this->sendError('Login fetch error. Message ' . $e->getMessage());
        }

        return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }

    /**
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function detail(Request $request, $id): JsonResponse
    {
        try {
            $user = User::find($id);
        } catch (\Exception $e) {
            Log::error('User fetch error.', [
                'message' => $e->getMessage()
            ]);
            return $this->sendError('User fetch error. Message ' . $e->getMessage());
        }

        return $this->sendResponse($user, 'User retrieved successfully.');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'Successfully logged out.');
    }
}
