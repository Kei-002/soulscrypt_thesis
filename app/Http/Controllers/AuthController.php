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

class AuthController extends Controller
{
    //
    use HttpResponses;

    public function login(Request $request)
    {
        $request->validated($request->all());

        // if (Auth::attempt($request)) {
        //     $user = Auth::user();
        //     $token = md5(time()).".".md5($request->email);
        //     $user->forceFill([
        //         'api_token' => $token
        //     ])->save();
        //     return response()->json([
        //         'token' => $token
        //     ]);
        // }

        // return response()->json([
        //     'message' => 'Credentials does not match our records'
        // ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();
        $role = $user->role;
        return $this->success(['user' => $user,
            'role' => $role,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
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

        $customer = Relative::create([
            'user_id' => $user->id,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'address' => $request->address,
            'phonenum' => $request->phonenum,
        ]);

        // $pet = Pet::create([
        //     'pet_name' => $user->id,
        //     'age' => $request->age,
        //     'customer_id' => $customer->id,
        // ]);

        Auth::login($user);

        return $this->success([
            'user' => $user,
            'role' => 'customer',
            'customer' => $customer,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {

        // $request->user()->forceFill([
        //     'api_token' => null
        // ])->save();

        $user = User::find(Auth::id());
        $user->tokens()->delete();
        auth()->guard('web')->logout();
        return $this->success(['message' => "User successfully logged out.",
        ]);
    }


}
