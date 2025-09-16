<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
          if(auth()->user()->role == 1){
            $user = User::where('email','=',$request->email)->first();
          if($user){
          $request->session()->put('adminEmail', $user->email);
          $request->session()->put('adminName', $user->name);
          $request->session()->put('adminRole', $user->role);
          $request->session()->put('adminId', $user->id);
          }
          return redirect()->route('login.custom');
          }else if(auth()->user()->role == 0){
             $user = User::where('email','=',$request->email)->first();
             if($user){
             $request->session()->put('studentEmail', $user->email);
             $request->session()->put('studentName', $user->name);
             $request->session()->put('studentRole', $user->role);
             $request->session()->put('studentId', $user->id);
             }
            return redirect('student/courses');
          }else if(auth()->user()->role == 2){
            $user = User::where('email','=',$request->email)->first();
            if($user){
            $request->session()->put('professorEmail', $user->email);
            $request->session()->put('professorName', $user->name);
            $request->session()->put('professorRole', $user->role);
            $request->session()->put('professorId', $user->id);
            }
            return redirect('professor/courses');
          }
    }
    return redirect('login');
}
}
