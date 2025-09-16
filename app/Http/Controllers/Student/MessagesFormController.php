<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactForm;

class MessagesFormController extends Controller
{
  public function messagesTable(){
    $messages = ContactForm::all();
    return view('../professor.messages', ['messages' => $messages]);
    }
    public function createMessage(Request $request) {
        return view('student/messages');
      }
      // Store Contact Form data
      public function MessagesForm(Request $request) {
          // Form validation
          $this->validate($request, [
            'message' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'subject'=>'required'
           ]);
          //  Store data in database
          ContactForm::create($request->all());
          // 
          return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
      }
}
