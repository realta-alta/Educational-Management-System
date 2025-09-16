<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\programim;


class ProgramimController extends Controller
{
    public function createForm(){
        return view('professor/programimadd');
      }

      public function programimTable(){
        $fileModel = programim::all();
        return view('../professor.programim', ['fileModel' => $fileModel]);

        }

        public function programimStudentTable(){
            $fileModel = programim::all();
            return view('../student.gaming', ['fileModel' => $fileModel]);
         }


    public function fileUpload(Request $req){
            $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            'title' => 'required|min:3',
            'text' => 'required|min:3'
            ]);
            $title = $req->title;
            $text = $req->text;

            $fileModel = new programim();
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

       public function editProgramim($id){
        $fileModel = programim::where('id','=',$id)->first();
        return view('../professor/programimedit',compact('fileModel'));
    }

    public function updateProgramim(Request $request ){
        $id = $request->id;

    $fileModel = programim::find($id);
    $fileModel->title = $request->input('title');
    $fileModel->text = $request->input('text');

    if ($request->hasFile('file')) {
        $destination = '/storage/' .$fileModel->name;
        if(programim::exists($destination)){
            programim::delete($destination);
        }
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = $fileName;
        $fileModel->file_path = '/storage/' . $filePath;
    }

    $fileModel->update();



    return redirect('professor/programim');

    }


    public function deleteProgramim($id){
        programim::where('id', '=',$id)->delete();
        return redirect()->back();

    }
}
