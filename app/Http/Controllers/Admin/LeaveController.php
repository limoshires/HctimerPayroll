<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SickLeave;
use App\Models\VacationLeave;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendence;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class LeaveController extends Controller
{
    public function sick_leave()
    {
        $view_sick_leave['all_emp'] = User::where('user_role', 'user')->select('id', 'first_name')->get();
        $view_sick_leave['view_sick_leave'] = DB::table('sick_leaves')
            ->leftjoin('users', 'users.id', '=', 'sick_leaves.user_id')
            ->select('users.first_name', 'sick_leaves.*')->orderBy('id', 'DESC')->get();

        return view('Admin.sick_leave', $view_sick_leave);
    }


    public function insert_sick_leave(Request $request)
    {
        // get leave data start
        $title = $request->title;
        $leave_date = $request->leave_date;
        $description = $request->description;
        // get leave data end


        $user_id = $request->user_id;
        $checkRec = SickLeave::where('user_id', $user_id)->where('leave_date', $leave_date)->count();

        if ($checkRec > 0) {
            return redirect()->back()->with('error', 'We already have Sick Leave Request applied for this date!');
        }
        $c_year = Carbon::now()->year;
        $insert_sick_leave = new SickLeave();
        $insert_sick_leave->user_id = $user_id;
        $insert_sick_leave->title = $title;
        $insert_sick_leave->leave_date = $leave_date;
        $insert_sick_leave->description = $description;
        $insert_sick_leave->c_year = $c_year;
        $insert_sick_leave->status = 0;
        $insert_sick_leave->save();

        return redirect()->back()->with('message', 'Your Sick leave apply Successfully!');

        return view('Admin.sick_leave');
    }

    public function sick_status_deactive($id)
    {
        $sick_status_deactive = SickLeave::find($id);
        $sick_status_deactive->status = 0;
        $sick_status_deactive->save();

        ///sick leave update emp start
        $update_emp_sick = User::find($sick_status_deactive->user_id);
        if ($update_emp_sick->annual_sick_leave < 10 && $update_emp_sick->annual_sick_leave >= 0) {
            //dd($update_emp_sick->annual_sick_leave);
            $update_emp_sick->annual_sick_leave = $update_emp_sick->annual_sick_leave + 1;
            $update_emp_sick->save();
        }

        // dd($emp_get->annual_sick_leave);
        ///sick leave update emp end
        return redirect()->back()->with('error', 'Sick Leave successfully Deactive! remaning leave -' . $update_emp_sick->annual_sick_leave . '');
    }
    public function sick_status_active($id)
    {
        $sick_status_active = SickLeave::find($id);
        $sick_status_active->status = 1;
        $sick_status_active->save();

        $leaveLeft = User::select('annual_sick_leave as ann_leave')->where('id', $sick_status_active->user_id)->first();

        $atten_check = Attendence::where('user_id', $sick_status_active->user_id)->where('date', $sick_status_active->leave_date)->first();
        if ($atten_check == null) {
            $start_time = date('H:i:s');
            $atten = new Attendence();
            $atten->user_id = $sick_status_active->user_id;
            $atten->start_time = '08:00:00';
            $atten->date = $sick_status_active->leave_date;
            $atten->work_time = '08:00:00';
            $atten->overtime = '00:00:00';
            $atten->end_time = '04:00:00';
            $atten->total_hours = 28800;
            $atten->work_and_overtime = 28800;
            $atten->status = 0;
            $atten->save();
        }
        ///attendence inserted end
        return redirect()->back()->with('success', 'Sick Leave successfully Approved! remaning leave ' . $leaveLeft->ann_leave . '');
    }
    public function  delete_sick($id)
    {
        $delete_sick = SickLeave::find($id);
        $delete_sick->delete();

        return redirect()->back()->with('error', 'Sick Leave successfully Deleted!');
    }


    ////////////////////////////sick leave function end///////////////////////////
    ////////////////////////////vacation leave function start///////////////////////////
    public function vacation_leave()
    {
        $view_vacation_leave['all_emp'] = User::where('user_role', 'user')->select('id', 'first_name')->get();
        $view_vacation_leave['view_vacation_leave'] = DB::table('vacation_leaves')
            ->leftjoin('users', 'users.id', '=', 'vacation_leaves.user_id')
            ->select('users.first_name', 'vacation_leaves.*')->orderBy('id', 'DESC')->get();

        return view('Admin.vacation_leave', $view_vacation_leave);
    }


    public function insert_vacation_leave(Request $request)
    {
        // get leave data start
        $title = $request->title;
        $leave_date = $request->leave_date;
        $description = $request->description;
        // get leave data end


        $user_id = $request->user_id;
        $checkRec = VacationLeave::where('user_id', $user_id)->where('leave_date', $leave_date)->count();

        if ($checkRec > 0) {
            return redirect()->back()->with('error', 'We already have Sick Leave Request applied for this date!');
        }
        $c_year = Carbon::now()->year;
        $insert_sick_leave = new VacationLeave();
        $insert_sick_leave->user_id = $user_id;
        $insert_sick_leave->title = $title;
        $insert_sick_leave->leave_date = $leave_date;
        $insert_sick_leave->description = $description;
        $insert_sick_leave->c_year = $c_year;
        $insert_sick_leave->status = 0;
        $insert_sick_leave->save();

        return redirect()->back()->with('message', 'Your Vacation leave apply Successfully!');

        return view('Admin.vacation_leave');
    }

    public function vacation_status_deactive($id)
    {
        $vacation_status_deactive = VacationLeave::find($id);
        $vacation_status_deactive->status = 0;
        $vacation_status_deactive->save();

        ///sick leave update emp start
        $update_emp_vacation = User::find($vacation_status_deactive->user_id);
        if ($update_emp_vacation->annual_vacation_leave < 10 && $update_emp_vacation->annual_vacation_leave >= 0) {
            //dd($update_emp_sick->annual_sick_leave);
            $update_emp_vacation->annual_vacation_leave = $update_emp_vacation->annual_vacation_leave + $vacation_status_deactive->allow_leave;
            $update_emp_vacation->save();
        }
        ///attendence inserted start
        $atten_check = Attendence::where('user_id', $vacation_status_deactive->user_id)->where('date', $vacation_status_deactive->leave_date_end)->first();
        if ($atten_check == null) {
            $start_time = date('H:i:s');
            $atten = new Attendence();
            $atten->user_id = $vacation_status_deactive->user_id;
            $atten->start_time = '00:00:00';
            $atten->date = $vacation_status_deactive->leave_date_end;
            $atten->work_time = '08:00:00';
            $atten->overtime = '00:00:00';
            $atten->end_time = 0;
            $atten->total_hours = 0;
            $atten->work_and_overtime = 0;
            $atten->status = 0;
            $atten->save();
        }
        ///attendence inserted end
        // dd($emp_get->annual_sick_leave);
        ///sick leave update emp end
        return redirect()->back()->with('error', 'Sick Leave successfully Deactive! remaning leave :' . $update_emp_vacation->annual_vacation_leave . ' Days');
    }
    public function vacation_status_active($id)
    {
        $vacation_status_active = VacationLeave::find($id);
        $vacation_status_active->status = 1;
        $vacation_status_active->save();

        $leaveLeft = User::select('annual_vacation_leave as ann_leave')->where('id', $vacation_status_active->user_id)->first();

        $atten_check = Attendence::where('user_id', $vacation_status_active->user_id)->where('date', $vacation_status_active->leave_date)->first();
        if ($atten_check == null) {
            $start_time = date('H:i:s');
            $atten = new Attendence();
            $atten->user_id = $vacation_status_active->user_id;
            $atten->start_time = '08:00:00';
            $atten->date = $vacation_status_active->leave_date;
            $atten->work_time = '08:00:00';
            $atten->overtime = '00:00:00';
            $atten->end_time = '04:00:00';
            $atten->total_hours = 28800;
            $atten->work_and_overtime = 28800;
            $atten->status = 0;
            $atten->save();
        }
        ///attendence inserted end
        return redirect()->back()->with('success', 'Vacation Leave successfully Approved! remaning leave :' . $leaveLeft->ann_leave . ' Days');
    }
    public function  delete_vacation($id)
    {
        $delete_vacation = VacationLeave::find($id);
        $delete_vacation->delete();

        return redirect()->back()->with('error', 'Vacation Leave successfully Deleted!');
    }
    ////////////////////////////vacation leave function end///////////////////////////

    public function holidays()
    {
        $holiday_date = Holiday::get();
        return view('Admin.holidays', get_defined_vars());
    }
    public function add_holiday()
    {
        return view('Admin.add_holiday');
    }
    public function add_holiday_values(Request $request)
    {
        $title = $request->title;
        $date = $request->date_;

        $holiday = new Holiday();
        $holiday->holiday_title = $title;
        $holiday->holiday_date = $date;
        $holiday->save();

        return redirect('admin/holidays');
    }
    public function delete_holiday($id)
    {
        $data = Holiday::find($id);
        $data->delete();
        return redirect()->back();
    }
    public function update_holiday($id)
    {
        $holiday_id = Holiday::find($id);
        return view('Admin.update_holiday', get_defined_vars());
    }
    public function update_holiday_values(Request $request, $id)
    {

        $h_title = $request->title;
        $h_date = $request->date;
        $data = Holiday::find($id);
        $data->holiday_title = $h_title;
        $data->holiday_date = $h_date;
        $data->save();
        return redirect('admin/holidays');
    }
}
