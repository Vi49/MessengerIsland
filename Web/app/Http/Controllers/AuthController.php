<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Auth\AfterregRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Services\Utils;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials, ['exp' => Carbon::now()->addDays(30)->timestamp])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {
        if($request->validated()) {

            $credentials = request(['email', 'password']);

            try {
                User::create([
                    'email' => $request['email'],
                    'password' => \Illuminate\Support\Facades\Hash::make($request['password']),
                    'user_id' => Utils::generate_user_id($request['email']),
                ]);

                // Generate a JWT token for the registered user
                $token = auth()->attempt($credentials, ['exp' => Carbon::now()->addDays(30)->timestamp]);

                return $this->respondWithToken($token);

            } catch (\Exception $ex) {
                return response()->json(['message' => 'Error creating user']);
            }
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }



    public function afterreg(AfterregRequest $request)
    {
        if($request->validated()){

            try {

                if (request()->hasfile('avatar')) {
                    $avatarName = time() . auth()->user()->user_id . '.' . $request['avatar']->getClientOriginalExtension();
                    $request['avatar']->move(public_path('avatars'), $avatarName);
                }

                $user = auth()->user();
                if(!$user){
                    throw new \Exception( 'No user logged in');
                }

                $user->avatar = $avatarName ?? NULL;
                $user->first_name = $request['first_name'];
                $user->last_name = $request['last_name'] ?? NULL;
                $user->is_afterreged = true;
                $user->save();

                return response()->json(['message'=> 'Successfully after registered']);

            } catch (\Exception $ex) {
                return response()->json(['message' => 'Error creating user']);
            }
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
