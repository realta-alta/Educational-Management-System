<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\subjects;

class Exams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = Session()->get('professorEmail');
        $Prof = subjects::where('email', '=',$email)->first();

        if($Prof!==null && $Prof->subject == "Web"){
            return redirect('professor/WebExams');
        }else if($Prof!==null && $Prof->subject == "Shkenca Kompjuterike"){
            return redirect('professor/shkiExams');
        }else if($Prof!==null && $Prof->subject == "Lab 1"){
            return redirect('professor/LabExams');
        }else if($Prof!==null && $Prof->subject == "Programim i Lojrave"){
            return redirect('professor/ProgramimExams');
        }else if($Prof!==null && $Prof->subject == "Kriptografi"){
            return redirect('professor/KriptoExams');
        }
        return back()->with('status', 'You dont have access');
    }
}
