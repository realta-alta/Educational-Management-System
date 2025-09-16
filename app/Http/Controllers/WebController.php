<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\web;

class WebController extends Controller
{
    public function createForm(){
        return view('professor/inxhinieriadd');
      }

      public function webTable(){
        $fileModel = web::all();
        return view('../professor.inxhinieri', ['fileModel' => $fileModel]);
     
        }

        public function WebStudentTable(){
            $fileModel = web::all();
            return view('../student.web', ['fileModel' => $fileModel]);
         }


    public function fileUpload(Request $req){
            $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            'title' => 'required|min:3',
            'text' => 'required|min:3'
            ]);
            $title = $req->title;
            $text = $req->text;
            
            $fileModel = new web();
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

       public function editWeb($id){
        $fileModel = web::where('id','=',$id)->first();
        return view('../professor/inxhinieriedit',compact('fileModel'));
    }

    public function updateWeb(Request $request ){
        $id = $request->id;

    $fileModel = web::find($id);
    $fileModel->title = $request->input('title');
    $fileModel->text = $request->input('text');

    if ($request->hasFile('file')) {
        $destination = '/storage/' .$fileModel->name;
        if(web::exists($destination)){
            web::delete($destination);
        }
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = $fileName;
        $fileModel->file_path = '/storage/' . $filePath;
    }

    $fileModel->update();



    return redirect('professor/inxhinieri');

    }


    public function deleteWeb($id){
        web::where('id', '=',$id)->delete();
        return redirect()->back();

    }
}
