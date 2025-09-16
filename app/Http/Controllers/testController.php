<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
class testController extends Controller {
    // Create Contact Form
    public function createTestForm(Request $request) {
      return view('test');
    }
    // Store Contact Form data
    public function TestForm(Request $request) {
        // Form validation
        $this->validate($request, [
            'name' =>   'required|string|min:3|max:20',
            'email' =>  'required|email|unique:users,email',
            'password' => 'required|min:6',
            'cpassword'=>'required|same:password'
         ]);
        //  Store data in database
        // Users::create($request->all());
        Users::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'cpassword' => Hash::make($request->input('cpassword'))
        ]);
        // 
        return redirect('login')->with('success');
    }
}