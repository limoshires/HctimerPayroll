<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SickLeave;
use Illuminate\Http\Request;
use App\Models\VacationLeave;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Attendence;
use Illuminate\Support\Facades\Auth;

class SickLeaveController extends Controller
{
    public function sick_leave()
    {
        return view('Employee.sick_leave');
    }


    public function insert_sick_leave(Request $request)
    {
        $title = $request->title;
        $leave_date = $request->leave_date;
        $description = $request->description;
        $user_id = Auth::user()->id;
        $countWorkDays = Attendence::where('user_id', $user_id)->count();
        if ($countWorkDays > 110) {
            $c_year = Carbon::now()->year;
            $getLeaveCount = User::where('id', $user_id)->first();

            $curr_year = Carbon::now()->year;
            if ($curr_year -  (int)$getLeaveCount->c_year >= 1) {
                $getLeaveCount->annual_sick_leave = 10;
                $getLeaveCount->c_year = $curr_year;
                $getLeaveCount->save();
            }
            $s_c = $getLeaveCount->annual_sick_leave;
            if ($s_c <= 0) {
                return redirect()->back()->with('error', 'You have no more Leave Left to Apply For this Year!');
            }
            if ($s_c == 10) {
                $getLeaveCount->sick_leave_date = $leave_date;
                $getLeaveCount->c_year = $c_year;
                $getLeaveCount->annual_sick_leave = $s_c - 1;
                $getLeaveCount->save();

                $insert_sick_leave = new SickLeave();
                $insert_sick_leave->user_id = $user_id;
                $insert_sick_leave->title = $title;
                $insert_sick_leave->leave_date = $leave_date;
                $insert_sick_leave->description = $description;
                $insert_sick_leave->c_year = $c_year;
                $insert_sick_leave->status = 0;
                $insert_sick_leave->save();

                return redirect()->back()->with('success', 'Your Sick leave apply Successfully!');
            } else {
                $appliedDateSick = $getLeaveCount->sick_leave_date;
                $current_data = Carbon::now();
                $days_diff = $current_data->diffInDays($appliedDateSick);
                $leftDays = 0;
                if ($days_diff >= 22) {
                    $insert_sick_leave = new SickLeave();
                    $insert_sick_leave->user_id = $user_id;
                    $insert_sick_leave->title = $title;
                    $insert_sick_leave->leave_date = $leave_date;
                    $insert_sick_leave->description = $description;
                    $insert_sick_leave->c_year = $c_year;
                    $insert_sick_leave->status = 0;
                    $getLeaveCount->annual_sick_leave = $s_c - 1;
                    $getLeaveCount->sick_leave_date = $leave_date;
                    $getLeaveCount->save();
                    $insert_sick_leave->save();
                    return redirect()->back()->with('success', 'Your Sick leave apply Successfully!');
                } else {
                    $leftDays = 22 - $days_diff;
                    return redirect()->back()->with('error', 'You still have' . $leftDays . " days left to submit Sick Leave");
                }
            }
        } else {
            $leftDays = 110 - $countWorkDays;
            return redirect()->back()->with('error', 'You still have' . $leftDays . " days left to submit Sick Leave");
        }
    }
    ///////////////////////Vacation  function////////////////////////////////

    public function vacation_leave()
    {
        return view('Employee.vacation_leave');
    }

    public function insert_vacation_leave(Request $request)
    {
        // get leave data start
        $title = $request->title;
        $leave_date = $request->leave_date_start;
        $description = $request->description;

        $user_id = Auth::user()->id;
        $countWorkDays = Attendence::where('user_id', $user_id)->count();
        if ($countWorkDays > 220) {
            $c_year = Carbon::now()->year;
            $getLeaveCount = User::where('id', $user_id)->first();

            $curr_year = Carbon::now()->year;
            if ($curr_year -  (int)$getLeaveCount->v_c_year >= 1) {
                $current_vac = $getLeaveCount->annual_vacation_leave;
                $getLeaveCount->annual_vacation_leave = $current_vac + 10;
                $getLeaveCount->v_c_year = $curr_year;
                $getLeaveCount->save();
            }
            $s_c = $getLeaveCount->annual_vacation_leave;
            if ($s_c <= 0) {
                return redirect()->back()->with('error', 'You have no more Leave Left to Apply For this Year!');
            }
            if ($s_c == 10) {
                $getLeaveCount->v_leave_date = $leave_date;
                $getLeaveCount->v_c_year = $curr_year;
                $getLeaveCount->annual_vacation_leave = $s_c - 1;
                $getLeaveCount->save();

                $insert_vacation_leave = new VacationLeave();
                $insert_vacation_leave->user_id = $user_id;
                $insert_vacation_leave->title = $title;
                $insert_vacation_leave->leave_date = $leave_date;
                $insert_vacation_leave->description = $description;
                $insert_vacation_leave->c_year = $curr_year;
                $insert_vacation_leave->status = 0;
                $insert_vacation_leave->save();

                return redirect()->back()->with('success', 'Your Sick leave apply Successfully!');
            } else {
                $appliedDateSick = $getLeaveCount->v_leave_date;
                $current_data = Carbon::now();
                $days_diff = $current_data->diffInDays($appliedDateSick);
                $leftDays = 0;
                if ($days_diff >= 22) {
                    $insert_sick_leave = new VacationLeave();
                    $insert_sick_leave->user_id = $user_id;
                    $insert_sick_leave->title = $title;
                    $insert_sick_leave->leave_date = $leave_date;
                    $insert_sick_leave->description = $description;
                    $insert_sick_leave->c_year = $curr_year;
                    $insert_sick_leave->status = 0;
                    $getLeaveCount->annual_vacation_leave = $s_c - 1;
                    $getLeaveCount->v_leave_date = $leave_date;
                    $getLeaveCount->save();
                    $insert_sick_leave->save();
                    return redirect()->back()->with('success', 'Your Sick leave apply Successfully!');
                } else {
                    $leftDays = 22 - $days_diff;
                    return redirect()->back()->with('error', 'You still have' . $leftDays . " days left to submit Sick Leave");
                }
            }
        } else {
            $leftDays = 220 - $countWorkDays;
            return redirect()->back()->with('error', 'You still have' . $leftDays . " days left to submit Sick Leave");
        }

        $insert_vacation_leave = new VacationLeave();
        $insert_vacation_leave->user_id = $user_id;
        $insert_vacation_leave->title = $title;
        $insert_vacation_leave->leave_date_start = $leave_date_start;
        $insert_vacation_leave->leave_date_end = $leave_date_end;
        $insert_vacation_leave->description = $description;
        $insert_vacation_leave->c_year = $c_year;
        $insert_vacation_leave->allow_leave = $diff_in_days_vacation;
        $insert_vacation_leave->status = 0;
        $insert_vacation_leave->save();
        return redirect()->back()->with('success', 'Your Vacation leave apply Successfully!');
        return redirect()->back()->with('error', 'Your can apply Vacation leave after ' . $diff_in_days_vacation . ' days !');

        return view('Employee.vacation_leave');
    }
}
