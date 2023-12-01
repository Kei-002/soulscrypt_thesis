<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Relative;
use App\Models\User;
// use App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;
class AuthController extends Controller
{
    //
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('auth:api', ['except'=> ['login', 'register']]);
    }

    public function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'user'=> auth()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    // View user token information
    public function profile() {
        return response()->json(auth()->user());
    }

    public function login(Request $request)
    {
      
        // Get only the email and password from the form
        $credentials = $request->only(['email', 'password']);


        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);

        // $user = User::where('email', $request->email)->first();
        // $role = $user->role;
        // return $this->success(['user' => $user,
        //     'role' => $role,
        //     'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        // ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
        ]);

        $full_name = $request->first_name . " " . $request->last_name;

        $user = User::create([
            'name' => $full_name,
            'email' => $request->email,
            'user_type' => 'relative',
            'password' => Hash::make($request->password),
        ]);

        $relative = Relative::create([
            'user_id' => $user->id,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'address' => $request->address,
            'phonenum' => $request->phonenum,
        ]);

        // Auth::login($user);

        return $this->success([
            'user' => $user,
            'relative' => $relative,
            // 'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return $this->success(['message'=> "User successfully logged out."]);
    }


}
