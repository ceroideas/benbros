<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function login(Request $r)
    {
        $this->validate($r,[
            'email' => 'email|required',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required'
        ],[
            'g-recaptcha-response.required' => 'Recaptcha field is required',
        ]);

        if (Auth::attempt(['email' => $r->email, 'password' => $r->password],true)) {            
            return redirect('/');
        }else{
            return back()->with('warning','It was not possible to log in, please check your data');
        }
    }

    public function profile()
    {
        return view('profile');
    }
    public function updateProfile(Request $r)
    {
        $this->validate($r,[
            'name' => 'required',
            'email' => 'required|unique:users,id,',$r->id,
            'position' => 'required',
            'password' => 'confirmed',
        ]);

        $u = User::find($r->id);

        if ($r->hasFile('avatar')) {
            $file = $r->file('avatar');
            $name = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/avatars/',$name);
            $u->avatar = $name;
        }

        $u->name = $r->name;
        $u->email = $r->email;
        $u->position = $r->position;
        if ($r->password) {
            $u->password = $r->password;
        }
        $u->save();

        return response()->json("Ok",200);
    }
}
