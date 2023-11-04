<?php

namespace App\Http\Controllers;

use App\Models\Relative;
use App\Models\User;
use Illuminate\Http\Request;

class RelativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Relative::all();
        // return response($data, $status = 200);
        return response()->json($data);
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
        
        $account = new Relative();
        

        $account->user_id = $user->id;
        $account->first_name = $input['first_name'];
        $account->last_name = $input['last_name'];
        $account->email = $input['email'];
        $account->gender = $input['gender'];
        // $account->position = $input['position'];
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
            'relative' => $account,
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
        $account = Relative::findOrFail($id);
        $user = $account->user;
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

    public function updateRelative(Request $request, string $id) {
        // $data = $request->all();
       // dd($request);
       $account = Relative::findOrFail($id);
       $user = User::where("id", $account->user_id)->firstOrFail();

       // $user = User::find($id);
       // $account = Customer::where("user_id", $id)->firstOrFail();
       // $img_path = "none";
       // if ($request->hasFile('img_path')) {
       //     $fileName = time() . $request->file('img_path')->getClientOriginalName();
       //     $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
       //     $input["img_path"] = '/storage/' . $path;
       //     $account->img_path = $input["img_path"];
       // }
       $user->name = $request->fname . " " . $request->lname;
       $user->email = $request->email;
       $user->save();
       // $account->;

       $account->first_name = $request->first_name;
       $account->last_name = $request->last_name;
       $account->addressline = $request->addressline;
       $account->phone = $request->phone;
    //    $account->position = $request->position;
       $account->save();

       return response()->json([
           'message' => 'Relative updated successfully',
           // 'status' => $user,
           'changes' => $request->all(),
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
            $account = Relative::findOrFail($id);
            $user = User::where("id", $account->user_id)->firstOrFail();
            $user->delete();
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        return response()->json([
            'message' => 'Relative Deleted Successfully',
            'status' => 200,
        ]);
    }
}
