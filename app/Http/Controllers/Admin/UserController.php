<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function usersTable(){
        $users = User::all();
        return view('../admin.admin', ['users' => $users]);
     
    }

    public function deleteUser($id){
        User::where('id', '=',$id)->delete();
        return redirect()->back();

    }

    public function editUser($id){
        $user = User::where('id','=',$id)->first();
        return view('../admin/usersedit',compact('user'));
    }

    public function addUser(){
        return view('useradd');
    }
    

    public function saveUser(Request $request){
        $request->validate([
            'name' =>   'required|string|min:3|max:20',
            'email' =>  'required|email|unique:users,email',
            'password' => 'required|min:6',
            'cpassword'=>'required|same:password',
            'role' => 'required|max:1'
         ]);
        
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $cpassword = Hash::make($request->cpassword);
        $role = $request->role;


        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->cpassword = $cpassword;
        $user->role = $role;
        $user->save();
        
        return redirect('../admin/admin');

    }

    public function updateUser(Request $request){
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $cpassword = Hash::make($request->cpassword);
        $role = $request->role;
        
        User::where('id', '=',$id)->update([
            'id'=> $id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'cpassword' => $cpassword,
            'role' => $role
        ]);
        return redirect('../admin/admin');

    }
}
