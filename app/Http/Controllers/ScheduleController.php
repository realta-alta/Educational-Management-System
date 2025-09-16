<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function scheduleTable(){
        $schedule = Schedule::all();
        return view('../admin.Schedule', ['schedule' => $schedule]);
     
    }
    
    public function scheduleProfessorTable(){
        $schedule = Schedule::all();
        return view('../professor.schedule', ['schedule' => $schedule]);
     
    }
    public function scheduleStudentTable(){
        $schedule = Schedule::all();
        return view('../student.schedule', ['schedule' => $schedule]);
     }

    public function deleteSchedule($id){
        Schedule::where('id', '=',$id)->delete();
        return redirect()->back();

    }
    
    public function addSchedule(){
        return view('../admin/scheduleadd');
    }

    public function updateUserView()
    {
        return view('../admin/scheduleedit');
    }
    
    public function saveSchedule(Request $request){
        
        $request->validate([
            'day' =>   'required|string|min:3|max:20',
            'first' =>   'required|string|min:3|max:20',
            'second' =>   'required|string|min:3|max:20',
            'third' =>   'required|string|min:3|max:20',
            
         ]);
        
        $day = $request->day;
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;


        $sche = new Schedule();
        $sche->day = $day;
        $sche->first = $first;
        $sche->second = $second;
        $sche->third = $third;
        $sche->save();
        
        return redirect('../admin/schedule');

    }

    public function editSchedule($id){
        $sche = Schedule::where('id','=',$id)->first();
        return view('../admin/scheduleedit',compact('sche'));
    }
    
    public function updateSchedule(Request $request){
        $id = $request->id;
        $day = $request->day;
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;
        
        Schedule::where('id', '=',$id)->update([
            'id'=> $id,
            'day' => $day,
            'first' => $first,
            'second' => $second,
            'third' => $third,
        ]);
        return redirect('../admin/schedule');

    }


}
