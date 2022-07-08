<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',            
            'gender' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'first_name' => $request->first_name, 
            'last_name' => $request->last_name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'gender' => $request->gender, 

        ]);
        if(!$user->role)
        {               
            return response()->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'gender' => $user->gender,
                'email' => $user->email,
                'role' => 'practitioner'
            ]);
        } else {
            return response()->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'gender' => $user->gender,
                'email' => $user->email,
                'role' => $user->role
            ]);
        }
        
    }

    public function newMemberAdd(Request $request) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',            
            'gender' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'first_name' => $request->first_name, 
            'last_name' => $request->last_name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'gender' => $request->gender, 
            'role' => $request->role
        ]);
        return $user;
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where('email',$request->email)->get();

        // all good so return the token
        return response()->json([
            'token' => compact('token'),
            'user_data' => $user
        ]);
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }
        return response(['authenticated' => true]);
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }
        return response()->json(['message' => 'Log out success'], 200);
    }
}
