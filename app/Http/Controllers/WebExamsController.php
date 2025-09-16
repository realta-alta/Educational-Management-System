<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebExams;
use App\Models\subjects;

class WebExamsController extends Controller
{
    public function ExamsTable(){
        $web = "Web";
        $exams = WebExams::all()->where('subject', '=',$web);
        return view('../professor.WebExams', ['exams' => $exams]);
     
    }

    public function ShkiExamsTable(){
        $shki = "Shkenca Kompjuterike";
        $exams = WebExams::all()->where('subject', '=',$shki);
        return view('../professor.shkiExams', ['exams' => $exams]);
     
    }

    public function LabExamsTable(){
        $lab = "Lab 1";
        $exams = WebExams::all()->where('subject', '=',$lab);
        return view('../professor.LabExams', ['exams' => $exams]);
     
    }

    public function ProgramimExamsTable(){
        $programim = "Programim i Lojrave";
        $exams = WebExams::all()->where('subject', '=',$programim);
        return view('../professor.ProgramimExams', ['exams' => $exams]);
     
    }

    public function KriptografiExamsTable(){
        $kriptografi = "Kriptografi";
        $exams = WebExams::all()->where('subject', '=',$kriptografi);
        return view('../professor.KriptoExams', ['exams' => $exams]);
     
    }


    public function Transcript(){
        $email = Session()->get('studentEmail');
        $exam =  WebExams::all()->where('email', '=',$email);
        return view('../student.transcript', ['exam' => $exam]);
     
    }



    public function studentSubjects(){
        $subject = subjects::all();
        $email = Session()->get('studentEmail');
        

        return view('../student.WebExam', ['subject' => $subject], );
     
    }

    public function deleteExams($subject){
        $email = Session()->get('studentEmail');

        WebExams::where('subject', $subject)->where('email', $email)->delete();
        return redirect()->back();

    }

    public function cancelExams($id){
        WebExams::where('id', '=',$id)->update([
            'grade' => null,
        ]);

        return redirect()->back();

    }

    public function DoExam(Request $request){
        $email = Session()->get('studentEmail');
        $name = Session()->get('studentName');
        $id = $request->id;
        $subjects = subjects::where('id', '=',$id)->first();

        $exam = new WebExams();
        $exam->email = $email;
        $exam->name = $name;
        $exam->subject = $subjects -> subject;
        $exam->save();

        return back()->with('status', 'You dont have access');

    }



    public function editExams($id){
        $exams = WebExams::where('id','=',$id)->first();
        return view('../professor/WebExamsEdit',compact('exams'));
    }
    
    public function updateExams(Request $request){
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $grade = $request->grade;
        
        WebExams::where('id', '=',$id)->update([
            'id'=> $id,
            'name' => $name,
            'email' => $email,
            'grade' => $grade,
        ]);


        return redirect('professor/courses');

    }
}
