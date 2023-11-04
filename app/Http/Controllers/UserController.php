<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Relative;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        // return response($data, $status = 200);
        return response()->json($data);
        // return User::paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // dd($request->album_id);
        // Check if password and confirmPassword field match
        if ($input['password1'] !== $input['password2']) {
            return response($message = 'Passwords does not match');
        }

        // Encrypt password
        $input['password1'] = bcrypt($request->password1);

        $user = new User();
        $user->name = $input['first_name'] . ' ' . $input['last_name'];
        $user->email = $input['email'];
        $user->password = $input['password1'];
        $user->user_type = $input['user_type'];
        // $user->status = $input['status'];
        $user->save();
        // Send email after user is created
        // Event::dispatch(new SendMail($user));

        // Check the role of user
        if ($input['user_type'] === 'relative') {
            $account = new Relative();
        } else {
            $account = new Employee();
        }

        $account->user_id = $user->id;
        $account->first_name = $input['first_name'];
        $account->last_name = $input['last_name'];
        $account->email = $input['email'];
        $account->gender = $input['gender'];
        
        $account->address = $input['address'];
        $account->phonenum = $input['phonenum'];

        // $fileName = time() . $request->file('img_path')->getClientOriginalName();
        // $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        // $input["img_path"] = '/storage/' . $path;
        // $account->img_path = $input["img_path"];

        $account->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'User Created Successfully.',
            'user' => $user,
            'status' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->user_type === "relative") {
            $account =
                Relative::where("user_id", $user->id)->firstOrFail();
        } else {
            $account = Employee::where("user_id", $user->id)->firstOrFail();
        }

        return response()->json([
            'user' => $user,
            'account' => $account,
            'status' => 200,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateUser(Request $request, string $id)
    {
        $user = User::find($id);

        if ($user->user_type == "relative") {
            $account = Relative::where("user_id", $id)->firstOrFail();
        } else {
            $account = Employee::where("user_id", $id)->firstOrFail();
        }
        $user->name = $request->fname . " " . $request->lname;
        $user->email = $request->email;
        $user->save();

        // For image upload
        // if ($request->hasFile('img_path')) {
        //     $fileName = time() . $request->file('img_path')->getClientOriginalName();
        //     $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        //     $input["img_path"] = '/storage/' . $path;
        //     $account->img_path = $input["img_path"];
        // }

        $account->first_name = $request->first_name;
        $account->last_name = $request->last_name;
        $account->address = $request->address;
        $account->email = $request->email;
        $account->phonenum = $request->phonenum;
        $account->save();
      



        return response()->json(['message' => 'User updated successfully',
            // 'status' => $user,
            'changes' => $id,
            'user' => $user,
            'account' => $account,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->user_type === 'relative') {
                $relative = Relative::where("user_id", $user->id)->firstOrFail();
                // $relative->pets()->delete();
            }
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        $user->delete();
        return response()->json([
            'message' => 'User Deleted Successfully',
            'status' => 200,
        ]);
    }
}
