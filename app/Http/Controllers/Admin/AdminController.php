<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\TestMail;
use App\Models\Deduction;
use App\Models\Threshold;
use App\Models\Accumulate;
use App\Models\Attendence;
use App\Models\Proceed;

use App\Models\Department;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('Admin.dashboard');
    }
    public function department()
    {
        $department['view_department'] = Department::get();
        return view('Admin.department', $department);
    }
    public function updateThreshold(Request $request)
    {
        $htreshold = Threshold::get()->toArray();
        $count = Accumulate::get()->count();
        $currentThreshold = $htreshold[0]['amount'];
        if ($count == 0) {
            $startDate = '2021-12-21';
            $min = 13;
            $endDate = date('Y-m-d', strtotime($startDate . ' + ' . $min . ' days'));
            $addVal = new Accumulate();
            $addVal->payroll_no = $count += 1;
            $addVal->start_date = $startDate;
            $addVal->end_date = $endDate;
            $addVal->accumalative_payrol_value = $currentThreshold;
            $addVal->save();
        } else {
            $data = Accumulate::get()->last()->toArray();
            $startDate = $data['end_date'];
            $datedata = $data['end_date'];
            $lastThreshold = $data['accumalative_payrol_value'];
            $current = Date('Y-m-d');
            // dd($current, $datedata);
            $total_time_seconds = Carbon::parse($current)->diffInDays($datedata);
            $min = 1;
            $startDate = date('Y-m-d', strtotime($startDate . ' + ' . $min . ' days'));
            $date = 14;
            $endDate = date('Y-m-d', strtotime($startDate . ' + ' . $date . ' days'));

            //dd($total_time_seconds);
            //dd($total_time_seconds);
            if ($total_time_seconds == 14) {
                $addVal = new Accumulate();
                $addVal->payroll_no = $count += 1;
                $addVal->start_date = $startDate;
                $addVal->end_date = $endDate;
                $addVal->accumalative_payrol_value = $currentThreshold + $lastThreshold;
                $addVal->save();
            }
        }

        return redirect()->back();
    }
    public function  add_department(Request $request)
    {
        $add_Department = new Department();
        $add_Department->department = $request->department_name;
        $add_Department->status = 0;
        $add_Department->save();

        return redirect()->back()->with('success', 'Department successfully Addedd!');
    }
    public function  edit_department(Request $request, $id)
    {
        $edit_department = Department::find($id);
        $edit_department->department = $request->department_name;
        $edit_department->save();

        return redirect()->back()->with('success', 'Department successfully Updated!');
    }




    public function depart_status_deactive($id)
    {
        $depart_status_deactive = Department::find($id);
        $depart_status_deactive->status = 0;
        $depart_status_deactive->save();
        return redirect()->back()->with('error', 'Department successfully Deactive!');
    }
    public function depart_status_active($id)
    {
        $depart_status_active = Department::find($id);
        $depart_status_active->status = 1;
        $depart_status_active->save();
        return redirect()->back()->with('success', 'Department successfully Active!');
    }
    public function  delete_department(Request $request, $id)
    {
        $delete_department = Department::find($id);
        $delete_department->delete();

        return redirect()->back()->with('error', 'Department successfully Deleted!');
    }


    public function attendance_history()
    {
        $atten_emp['emp_atten'] = DB::table('attendences')
            ->leftjoin('users', 'users.id', '=', 'attendences.user_id')
            ->select('users.first_name', 'attendences.*')->orderBy('date', 'DESC')->get();
        //  dd($atten_emp);
        //dd($atten_emp['emp_atten']);
        return view('Admin.attendance_history', $atten_emp);
    }


    public function attendance_search(Request $request)
    {

        if ($request->start_date && $request->end_date && $request->department) {
            $atten_emp['emp_atten'] = DB::table('attendences')->where('date', '>=', $request->start_date)
                ->where('date', '<=', $request->end_date)->when('user', function ($query) use ($request) {
                    return $query->where('department', $request->department);
                })
                ->leftjoin('users', 'users.id', '=', 'attendences.user_id')
                ->select('users.first_name', 'attendences.*')->orderBy('date', 'DESC')->get();
            //  dd($atten_emp);
            //dd($atten_emp['emp_atten']);
            return view('Admin.attendance_history', $atten_emp);
        }
    }

    public function attent_status_disapprove($id)
    {
        $attent_status_disapprove = Attendence::find($id);
        $d = explode(':', $attent_status_disapprove->work_time);
        $simplework = ($d[0] * 3600) + ($d[1] * 60) + $d[2];

        $attent_status_disapprove->status = 0;
        $attent_status_disapprove->work_and_overtime = $simplework;
        $attent_status_disapprove->update();
        return redirect()->back()->with('success', 'Attendance successfully Disapproved!');
    }
    public function processedPayroll()
    {
        $processPayroll = Proceed::get();
        return view('Admin.processedPayroll', get_defined_vars());
    }
    public function admin_attendance(Request $request)
    {


        $start_time = date('h:i:s A', strtotime($request->start_time));
        $end_time = date('h:i:s A', strtotime($request->end_time));


        $startTime = Carbon::parse($start_time);
        $endTime = Carbon::parse($end_time);

        $totalDuration =  $startTime->diff($endTime)->format('%H:%I:%S');
        $d = explode(':', $totalDuration);
        $simplework = ($d[0] * 3600) + ($d[1] * 60) + $d[2];
        $total_time_seconds = Carbon::parse($request->start_time)->diffInSeconds($endTime);


        $total_seconds = $total_time_seconds - 28800;
        $add_overtime_after_approve = $total_time_seconds - $total_seconds;
        $after = gmdate("H:i:s", $add_overtime_after_approve);
        $overtime = gmdate("H:i:s", $total_seconds);
        $In_time_update = new Attendence();

        $check_atten_one_time = Attendence::where('user_id', $request->user)->where('date', $request->date)->first();
        if ($check_atten_one_time == null) {
            if ($total_time_seconds >= 28800) {
                $In_time_update->user_id = $request->user;
                $In_time_update->start_time = $start_time;
                $In_time_update->end_time = $end_time;
                $In_time_update->date = $request->date;
                $In_time_update->work_time = $after;
                $In_time_update->overtime = $overtime;
                $In_time_update->total_hours = $total_time_seconds;
                $In_time_update->work_and_overtime = $add_overtime_after_approve;
                $In_time_update->status = 0;
                $In_time_update->save();
            } else {
                $In_time_update->user_id = $request->user;
                $In_time_update->start_time = $start_time;
                $In_time_update->end_time = $end_time;
                $In_time_update->date = $request->date;
                $In_time_update->work_time = $totalDuration;
                $In_time_update->overtime = '00:00:00';
                $In_time_update->total_hours = $total_time_seconds;
                $In_time_update->work_and_overtime = $simplework;
                $In_time_update->status = 0;
                $In_time_update->save();
            }
            return redirect()->back()->with('message', 'Your attendance successfully!');
        } else {
            return redirect()->back()->with('error', 'Your attendance Already Done!');
        }
    }

    public function EquipmentManagment()
    {
        $eq = Equipment::get();
        return view('Admin.equipmentManagment', get_defined_vars());
    }
    public function AddEquipment()
    {
        $user = User::get()->where('user_role', 'user');
        return view('Admin.add_equipment', get_defined_vars());
    }
    public function AddEquipmentItem(Request $request)
    {
        $type = $request->type;
        $name_ = $request->user;
        $eq = new Equipment();
        $emName = User::where('id', $name_)->first();
        $eq->type = $type;
        $eq->employee = $emName->first_name . " " . $emName->last_name;
        $eq->save();
        return redirect('admin/equipmentManagment');
    }
    public function EditEquipment($id)
    {
        $eq = Equipment::find($id);
        $user = User::where("user_role", "user")->get();
        return view('Admin.edit_equipment', get_defined_vars());
    }
    public function EditEquipmentType(Request $request)
    {

        $type = $request->type;
        $name_ = $request->user;
        dd($request->id);
        $eq = Equipment::where('id', $request->id)->first();
        $eq->type = $type;
        $eq->employee = $name_;
        $eq->save();
        return redirect('admin/equipmentManagment')->with('success', 'Equipment Information Updated');
    }
    public function DeleteEquipment($id)
    {
        $eq = Equipment::find($id);
        $eq->delete();
        return redirect('admin/equipmentManagment')->with('success', 'Equipment Deleted');
    }
    public function attent_status_approve($id)
    {
        $attent_status_disapprove = Attendence::find($id);
        $d = explode(':', $attent_status_disapprove->work_time);
        $simplework = ($d[0] * 3600) + ($d[1] * 60) + $d[2];

        $o = explode(':', $attent_status_disapprove->overtime);
        $simpleover = ($o[0] * 3600) + ($o[1] * 60) + $o[2];
        $attent_status_disapprove->status = 1;
        $attent_status_disapprove->work_and_overtime = $simplework + $simpleover;
        $attent_status_disapprove->update();
        return redirect()->back()->with('success', 'Attendance successfully Approved!');
    }
    public function employees()
    {

        $employees = User::where('user_role', 'user')->get();

        return view('Admin.employee.index', compact('employees'));
    }

    public function employeeCreate()
    {
        return view('Admin.employee.create');
    }

    public function employeeStore(Request $request)
    {
        // dd($request->all());

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return back()->with('error', 'This user email already exists.');
        } else {
            $user = User::create(
                [
                    'email' => $request->email,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'dob' => $request->dob,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'residence_address' => $request->residence_address,
                    'employment_status' => $request->employment_status,
                    'hire_date' => $request->hire_date,
                    'employee_id' => $request->employee_id,
                    'regular_hours' => $request->regular_hours,
                    'hourly_rate' => $request->hourly_rate,
                    'ot_rate' => $request->ot_rate,
                    'department' => $request->department,
                    'statutory_deductions' => $request->statutory_deductions,
                    'attn_inc_rate' => $request->attn_inc_rate,
                    'phone_number' => $request->phone_number,
                    'emergency_contact_name' => $request->emergency_contact_name,
                    'emergency_contact_number' => $request->emergency_contact_number,
                    'education' => $request->education,
                    'experience' => $request->experience,
                    'id_type' => $request->id_type,
                    'id_number' => $request->id_number,
                    'bank' => $request->bank,
                    'account_number' => $request->account_number,
                    'branch' => $request->branch,
                    'bank_photo' => 'kkk',
                    'trn' => $request->trn,
                    'nis' => $request->nis,
                    'user_role' => $request->user_role,
                ]
            );
            if (request()->hasfile('photo')) {
                $image = request()->file('photo');
                $filename = time() . '.' . $image->getClientOriginalName();
                $movedFile = $image->move('uploads/employees', $filename);
                $user->photo = $filename;
                $user->save();
            } else {
                $user->save();
            }
            $details = [
                'title' => 'Email and Password',
                'body' => 'Hi...' . $request->first_name . 'Your Email address : ' . $request->email . '' . 'and Your password : ->  ' . $request->password
            ];

            Mail::to($request->email)->send(new TestMail($details));

            // $user = User::where('email', '_mainaccount@briway.uk')->first();

            // \Mail::to($user->email)->send(new TestMail($details));
            // $admin = [
            //     'title' => 'user  Email and Password',
            //     'body' =>'Hi...'.$request->first_name.'Your Email address : '.$request->email.''.'and Your password : ->  '. $request->password
            // ];


            return redirect()->route('admin.employees')->with('message', 'Employee data saved successfully.');
        }
    }


    public function employeeEdit($id)
    {
        $emp = User::find($id);

        return view('Admin.employee.edit', compact('emp'));
    }


    public function employeeView($id)
    {
        $emp = User::find($id);

        return view('Admin.employee.view', compact('emp'));
    }

    public function employeeUpdate(Request $request, $id)
    {
        $emp = User::find($id);

        $emp->update([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'residence_address' => $request->residence_address,
            'employment_status' => $request->employment_status,
            'hire_date' => $request->hire_date,
            'employee_id' => $request->employee_id,
            'regular_hours' => $request->regular_hours,
            'hourly_rate' => $request->hourly_rate,
            'ot_rate' => $request->ot_rate,
            'department' => $request->department,
            'statutory_deductions' => $request->statutory_deductions,
            'attn_inc_rate' => $request->attn_inc_rate,
            'phone_number' => $request->phone_number,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'education' => $request->education,
            'experience' => $request->experience,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'bank' => $request->bank,
            'account_number' => $request->account_number,
            'branch' => $request->branch,
            'bank_photo' => 'null',
            'trn' => $request->trn,
            'nis' => $request->nis,
            'user_role' => $request->user_role,
        ]);
        if (request()->hasfile('photo')) {
            $image = request()->file('photo');
            $filename = time() . '.' . $image->getClientOriginalName();
            $movedFile = $image->move('uploads/employees', $filename);
            $emp->photo = $filename;
            $emp->save();
        } else {
            $emp->save();
        }
        return redirect()->route('admin.employees')->with('message', 'Employee updated succeddfuly.');
    }



    public function employeeShow($id)
    {
        $emp = User::find($id);
        return view('Admin.employee.show', compact('emp'));
    }
    public function update_profile(Request $request)
    {

        $user = User::find(Auth::user()->id);
        if (isset($request->photo)) {
            $image = $request->file('photo');
            $imageName = $image->getClientOriginalName();

            $user->update([
                'photo' => $imageName,
            ]);
            $path = $image->move(public_path('uploads/employees'), $imageName);
        }



        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,

        ]);

        if (isset($request->c_password)) {
            $request->validate([
                'new_password' => 'required|min:8',
                'confirm_password' => 'required_with:password|same:new_password|min:8'

            ]);
            if (Hash::check($request->c_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);
                $msg = "Your profile has been updated";
                $request->session()->flash('message', $msg);
                return redirect('/profile');
            } else {
                $msg = "Your Password does't match";
                $request->session()->flash('error', $msg);
                return redirect('/profile');
            }
        } else {
            $msg = "Your profile has been updated";
            $request->session()->flash('message', $msg);
            return redirect('/profile');
        }
    }
    public function threshold(Request $request)
    {
        $threshold['threshold'] = Threshold::all();
        return view('Admin/threshold', $threshold);
    }
    public function add_deduction(Request $request)
    {
        return view('admin/add_deduction');
    }
    public function add_threshold(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'cycle' => 'required',
            'amount' => 'required',
            'days' => 'required',
            'paid_by' => 'required'

        ]);

        //Threshold data save start
        $threshold = new Threshold();
        $threshold->year = $request->year;
        $threshold->cycle = $request->cycle;
        $threshold->amount = $request->amount;
        $threshold->days = $request->days;
        $threshold->paid_by = $request->paid_by;
        $threshold->save();
        session()->flash('message', 'Threshold successfully addedd!');
        return redirect('admin/threshold');
    }
    public function edit_threshold(Request $request, $id)
    {
        $edit_threshold['edit_threshold'] = Threshold::find($id);
        return view('Admin/edit_threshold', $edit_threshold);
    }
    public function edit_deduction(Request $request, $id)
    {
        $edit_deduction['edit_deduction'] = Deduction::find($id);
        return view('Admin/edit_deduction', $edit_deduction);
    }
    public function update_deduction(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'nis_fix_value' => 'required',
        //     'percentage_value' => 'required',
        //     'type_deduction' => 'required'
        // ]);
        $deduction = Deduction::find($id);
        $deduction->name = $request->name;
        $deduction->nis_fix_value = $request->percentage;
        $deduction->nis = $request->Nis;
        $deduction->percentage_value = $request->type_value;
        $deduction->type_deduction = $request->type;
        $deduction->save();
        session()->flash('message', 'Deduction/Contribution successfully Updated!');
        return redirect('admin/deduction');
    }

    public function update_threshold(Request $request, $id)
    {
        $request->validate([
            'year' => 'required',
            'cycle' => 'required',
            'amount' => 'required',
            'days' => 'required',
            'paid_by' => 'required'

        ]);
        //Threshold data save start
        $threshold = Threshold::find($id);
        $threshold->year = $request->year;
        $threshold->cycle = $request->cycle;
        $threshold->amount = $request->amount;
        $threshold->days = $request->days;
        $threshold->paid_by = $request->paid_by;
        $threshold->save();
        session()->flash('message', 'Threshold successfully Updated!');
        return redirect('admin/threshold');
    }
    public function delete_threshold(Request $request, $id)
    {
        $threshold = Threshold::find($id);
        $threshold->delete();
        session()->flash('error', 'Threshold successfully Deleted!');
        return redirect('admin/threshold');
    }



    public function deduction()
    {
        $get_deduction = Deduction::all();
        return view('Admin.deduction', get_defined_vars());
    }



    public function create_deduction(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'percentage_value' => 'required',
        //     'nis_fix_value' => 'required',
        //     'type_deduction' => 'required'

        //     ]);
        //Threshold data save start
        $deduction = Deduction::create([
            'name' => $request->name,
            'percentage_value' => $request->type_value,
            'nis_fix_value' => $request->percentage,
            'nis' => $request->Nis,
            'type_deduction' => $request->type

        ]);

        return redirect()->back()->with('message', 'payrol Deduction successfully Add');
    }
}
