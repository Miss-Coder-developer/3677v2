<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function signup(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string|same:password',
            'interested_category' => 'string'
        ]);

        $user = new User([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'interested_categroy' => $request->interested_category
        ]);

        try{
            $user->save();
            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);
        }catch (\Exception $exception){
            return response()->json([
                'message' => 'Error'
            ], 401);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateUserProfile(Request $request, $id){

//        $data = $request->all();

        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'interested_category' => 'string',
            'nickname' => 'string'
        ]);
//        dd('jhjkhj');
        try{
            User::where('id', $id)->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'interested_category' => $request->interested_category,
                'nickname' => $request->nickname
            ]);
            return response()->json([
                'message' => 'Successfully updated Profile!'
            ], 201);

        }catch (\Exception $e){
            return response()->json([
                'message' => 'Error'
            ], 401);
        }
    }

    public function destroyUser($user_id){
        User::where('id', $user_id)->delete();
        return response()->json([
            'message' => 'Successfully delete Profile!'
        ], 201);
    }
}
