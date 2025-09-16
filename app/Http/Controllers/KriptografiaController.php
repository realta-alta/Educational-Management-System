<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kriptografia;


class KriptografiaController extends Controller
{
    public function createForm(){
        return view('professor/kriptografiadd');
      }

      public function kriptografiTable(){
        $fileModel = Kriptografia::all();
        return view('../professor.kriptografi', ['fileModel' => $fileModel]);

        }

        public function kriptografiStudentTable(){
            $fileModel = Kriptografia::all();
            return view('../student.kriptografia', ['fileModel' => $fileModel]);
         }


    public function fileUpload(Request $req){
            $req->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            'title' => 'required|min:3',
            'text' => 'required|min:3'
            ]);
            $title = $req->title;
            $text = $req->text;

            $fileModel = new Kriptografia();
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

       public function editKriptografi($id){
        $fileModel = Kriptografia::where('id','=',$id)->first();
        return view('../professor/kriptografiedit',compact('fileModel'));
    }

    public function updateKriptografi(Request $request ){
        $id = $request->id;

    $fileModel = Kriptografia::find($id);
    $fileModel->title = $request->input('title');
    $fileModel->text = $request->input('text');

    if ($request->hasFile('file')) {
        $destination = '/storage/' .$fileModel->name;
        if(Kriptografia::exists($destination)){
            Kriptografia::delete($destination);
        }
        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
        $fileModel->name = $fileName;
        $fileModel->file_path = '/storage/' . $filePath;
    }

    $fileModel->update();



    return redirect('professor/kriptografi');

    }


    public function deleteKriptografi($id){
        Kriptografia::where('id', '=',$id)->delete();
        return redirect()->back();

    }
}
