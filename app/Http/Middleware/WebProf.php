<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\subjects;

class WebProf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $email = Session()->get('professorEmail');
       $webProf = subjects::where('email', '=',$email)->first();
        if($webProf==null || $webProf->email !== Session()->get('professorEmail')){
            return back()->with('status', 'You dont have access');
        }
        return $next($request);

    }
}
