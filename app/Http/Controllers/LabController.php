<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lab;

class LabController extends Controller
{
    public function createForm(){
        return view('professor/laboratoradd');
      }

      public function labTable(){
        $fileModel = lab::all();
        return view('../professor.laborator', ['fileModel' => $fileModel]);
     
        }

        public function LabStudentTable(){
            $fileModel = lab::all();
            return view('../student.lab1', ['fileModel' => $fileModel]);
         }


    public function fileUpload(Request $req){
            $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            'title' => 'required|min:3',
            'text' => 'required|min:3'
            ]);
            $title = $req->title;
            $text = $req->text;
            
            $fileModel = new lab();
            $fileModel->title =$title;
            $fileModel->text =$text;

            if($req->file()) {
                $fileName = time().'_'.$req->file->getClientOriginalName();
                $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
                $fileModel->name = time().'_'.$req->file->getClientOriginalName();
                $fileModel->file_path = '/storage/' . $filePath;
                $fileModel->save();
                return back()
                ->with('success','File has been uploaded.')
                ->with('file', $fileName);
            }
       }

       public function editLab($id){
        $fileModel = lab::where('id','=',$id)->first();
        return view('../professor/laboratoredit',compact('fileModel'));
    }

    public function updateLab(Request $request ){
        $id = $request->id;

    $fileModel = lab::find($id);
    $fileModel->title = $request->input('title');
    $fileModel->text = $request->input('text');

    if ($request->hasFile('file')) {
        $destination = '/storage/' .$fileModel->name;
        if(lab::exists($destination)){
            lab::delete($destination);
        }
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = $fileName;
        $fileModel->file_path = '/storage/' . $filePath;
    }

    $fileModel->update();



    return redirect('professor/laborator');

    }


    public function deleteLab($id){
        lab::where('id', '=',$id)->delete();
        return redirect()->back();

    }
}
