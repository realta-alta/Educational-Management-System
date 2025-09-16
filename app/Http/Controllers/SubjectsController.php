<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\subjects;
use App\Models\Users;
use App\Models\User;

class SubjectsController extends Controller
{
    public function subjectTable(){
        $subject = subjects::all();
        return view('../admin.subjects', ['subject' => $subject]);
     
    }
    
    public function subjectProfessorTable(){
        $subject = subjects::all();
        return view('../professor.subjects', ['subject' => $subject]);
     
    }
    public function subjectStudentTable(){
        $subject = subjects::all();
        return view('../student.subjects', ['subject' => $subject]);
     
    }

    public function deleteSubjects($id){
        subjects::where('id', '=',$id)->delete();
        return redirect()->back();

    }
    
    public function addSubject(){
        return view('../admin/subjectsadd');
    }

    public function updateUserView()
    {
        return view('../admin/subjectsedit');
    }
    
    public function saveSubjects(Request $request){
        
        $request->validate([
            'lecturer' =>   'required|string|min:3|max:20',
            'subject' =>   'required|string',
            'email' =>  'required|email',
            
         ]);
        
        
        $lecturer = $request->lecturer;
        $subject = $request->subject;
        $email = $request->email;
        $profID = Users::where('email','=',$email)->first();
        


        $sub = new subjects();
        $sub->professorID = $profID->id;
        $sub->lecturer = $lecturer;
        $sub->subject = $subject;
        $sub->email = $email;
        $sub->save();
        
        return redirect('../admin/subjects');

    }

    public function editSubject($id){
        $sub = subjects::where('id','=',$id)->first();
        return view('../admin/subjectsedit',compact('sub'));
    }
    
    public function updateSubject(Request $request){
        $id = $request->id;
        $lecturer = $request->lecturer;
        $subject = $request->subject;
        $email = $request->email;
        
        subjects::where('id', '=',$id)->update([
            'id'=> $id,
            'lecturer' => $lecturer,
            'subject' => $subject,
            'email' => $email,
        ]);
        return redirect('../admin/subjects');

    }



}
