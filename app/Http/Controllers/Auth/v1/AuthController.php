<?php

namespace App\Http\Controllers\Auth\v1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $userService = null;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        $rules = [
            'cip' =>'required',
            'password' =>'required',
        ];
        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()){
            return $this->errorResponseFails(collect($validated->errors()->all()));
        }
        $data = $validated->validated();
        $data['cip'] = $this->autoCoplete($data['cip'],8);
        $user = $this->userService->findCip($data['cip']);
        if($user){
            try {
                if (! $token = JWTAuth::attempt(['cip'=>$user->cip,'password'=>$request->password])) {
                    return $this->errorResponse("Sus credenciales no son correctas",1,401);
                }
            } catch (JWTException $e) {
                return $this->errorResponse("No se logró generar el token",1,400);
            }
            return $this->respondWithToken($token);
        }else{
            return $this->errorResponse("",1,400);
        }



    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(){

        //return response()->json(auth()->user());
        return $this->respondWithToken(auth()->user()->getRememberTokenName());

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

}
