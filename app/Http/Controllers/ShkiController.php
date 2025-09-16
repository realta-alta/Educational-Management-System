<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\shki;

class ShkiController extends Controller
{
    public function createForm(){
        return view('professor/shkenca1add');
      }

      public function shkiTable(){
        $fileModel = shki::all();
        return view('../professor.shkenca1', ['fileModel' => $fileModel]);
     
        }

        public function ShkiStudentTable(){
            $fileModel = shki::all();
            return view('../student.shk1', ['fileModel' => $fileModel]);
         }


    public function fileUpload(Request $req){
            $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            'title' => 'required|min:3',
            'text' => 'required|min:3'
            ]);
            $title = $req->title;
            $text = $req->text;
            
            $fileModel = new shki();
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

       public function editShki($id){
        $fileModel = shki::where('id','=',$id)->first();
        return view('../professor/shkenca1edit',compact('fileModel'));
    }

    public function updateShki(Request $request ){
        $id = $request->id;

    $fileModel = shki::find($id);
    $fileModel->title = $request->input('title');
    $fileModel->text = $request->input('text');

    if ($request->hasFile('file')) {
        $destination = '/storage/' .$fileModel->name;
        if(shki::exists($destination)){
            shki::delete($destination);
        }
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = $fileName;
        $fileModel->file_path = '/storage/' . $filePath;
    }

    $fileModel->update();



    return redirect('professor/shkenca1');

    }


    public function deleteShki($id){
        shki::where('id', '=',$id)->delete();
        return redirect()->back();

    }
}
