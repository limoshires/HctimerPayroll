<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\TestMail;
use App\Models\Accumulate;
use App\Models\Threshold;
use App\Models\Attendence;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Proceed;
use App\Models\Bonuse;
use App\Models\PayrollStart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PayrollController extends Controller
{

        public function payroll(Request $request)
        {
                $threshold = Threshold::select('cycle', 'days')->distinct()->get();
                $department = Department::select('department', 'id')->get();
                $users = User::where('user_role', 'user')->select('first_name', 'id')->where('add_attendance', 1)->get();
                return view('Admin/payroll', get_defined_vars());
        }
        public function search(Request $request)
        {

                $min = $request->cycle - 1;
                $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $min . ' days'));

                $startdate = Carbon::parse($request->start_date)->format('Y-m-d');
                //  dd($request->input());
                // "cycle" => "7"
                // "start_date" => "2022-01-03"
                // "end_date" => "2022-01-07"
                // "Dept" => "2"
                // "Emp" => "12"
                $threshold = Threshold::select('cycle', 'days')->distinct()->get();
                $department = Department::select('department', 'id')->get();
                $users = User::where('user_role', 'user')->select('first_name', 'id')->where('add_attendance', 1)->get();
                if ($request->cycle && $request->start_date && $request->DEPARTMENT && $request->Employee && $request->end_date) {
                        $min = $request->cycle - 1;
                        $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $min . ' days'));

                        $startdate = Carbon::parse($request->start_date)->format('Y-m-d');
                        $enddate = Carbon::parse($min)->format('Y-m-d');
                        //  dd($startdate,$enddate);

                        //  $data = Attendence::select('user_id')->whereBetween('date', [$request->start_date, $end_date])->distinct()->get();
                        // dd($request->Employee);
                        $userData = User::where('department', $request->DEPARTMENT)->where('id', $request->Employee)->where("user_role", 'user')->where("add_attendance", '1')->get();

                        $userArray = [];
                        $index = 0;



                        foreach ($userData as $data) {
                                $userId = $data->id;
                                $userName = $data->first_name;

                                $basicHourSum = Attendence::select(DB::raw('SUM(TIME_TO_SEC(work_time)) as worktime'))
                                        ->where("user_id", $userId)->where('date', '>=', $startdate)->where('date', '<=', $enddate)->get()->toarray();

                                $overTimeHourSum = Attendence::select(DB::raw('SUM(TIME_TO_SEC(overtime)) as overtime'))
                                        ->where("user_id", $userId)->where('date', '>=', $startdate)->where('date', '<=', $enddate)->where("status", "1")->get()->toarray();

                                // $totalHourSum = $basicHourSum+$overTimeHourSum;
                                $userArray[$index] = $userId;
                                $index += 1;
                                $userArray[$index] = $userName;
                                $index += 1;
                                $userArray[$index] = $basicHourSum;
                                $index += 1;
                                $userArray[$index] = $overTimeHourSum;
                                $index += 1;

                                $tempBasicHour = $userArray[$index - 2][0]['worktime'];
                                $originalbasichours = explode('.', $tempBasicHour);
                                $tempOverHour = $userArray[$index - 1][0]['overtime'];
                                $originalOverhours = explode('.', $tempOverHour);
                                $userArray[$index - 2] = $originalbasichours[0];
                                $userArray[$index - 1] = $originalOverhours[0];
                        }
                        //dd($userArray[2][0]["worktime"]);



                        return view('Admin/newsearch', get_defined_vars());


                        //dd($search['date_bw_data']);
                        // dd($request->cycle,$request->start_date);

                        //dd($search['date_bw_data']);
                        // dd($request->cycle,$request->start_date);
                }







                if ($request->cycle && $request->start_date && $request->DEPARTMENT && $request->end_date) {



                        // Add days to date and display it
                        $min = $request->cycle - 1;
                        $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $min . ' days'));


                        $startdate = Carbon::parse($request->start_date)->format('Y-m-d');
                        $enddate = Carbon::parse($min)->format('Y-m-d');
                        //  dd($date,$statdate);

                        //  $data = Attendence::select('user_id')->whereBetween('date', [$request->start_date, $end_date])->distinct()->get();

                        $userData = User::where("user_role", 'user')->where("add_attendance", '1')->get();

                        $userArray = [];
                        $index = 0;



                        foreach ($userData as $data) {
                                $userId = $data->id;
                                $userName = $data->first_name;

                                $basicHourSum = Attendence::select(DB::raw('SUM(TIME_TO_SEC(work_time)) as worktime'))
                                        ->where("user_id", $userId)->where('date', '>=', $startdate)->where('date', '<=', $enddate)->get()->toarray();

                                $overTimeHourSum = Attendence::select(DB::raw('SUM(TIME_TO_SEC(overtime)) as overtime'))
                                        ->where("user_id", $userId)->where('date', '>=', $startdate)->where('date', '<=', $enddate)->where("status", "1")->get()->toarray();
                                // $totalHourSum = $basicHourSum+$overTimeHourSum;
                                $userArray[$index] = $userId;
                                $index += 1;
                                $userArray[$index] = $userName;
                                $index += 1;
                                $userArray[$index] = $basicHourSum;
                                $index += 1;
                                $userArray[$index] = $overTimeHourSum;
                                $index += 1;

                                $tempBasicHour = $userArray[$index - 2][0]['worktime'];
                                $originalbasichours = explode('.', $tempBasicHour);
                                $tempOverHour = $userArray[$index - 1][0]['overtime'];
                                $originalOverhours = explode('.', $tempOverHour);
                                $userArray[$index - 2] = $originalbasichours[0];
                                $userArray[$index - 1] = $originalOverhours[0];
                        }
                        //dd($userArray[2][0]["worktime"]);



                        return view('Admin/newsearch', get_defined_vars());


                        //dd($search['date_bw_data']);
                        // dd($request->cycle,$request->start_date);
                }

                if ($request->cycle && $request->start_date) {
                        $checkcycle = $request->cycle;

                        $min = $request->cycle - 1;
                        // Add days to date and display it
                        $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $min . ' days'));

                        $startdate = Carbon::parse($request->start_date)->format('Y-m-d');
                        //  dd($startdate,$end_date);

                        //  $data = Attendence::select('user_id')->whereBetween('date', [$request->start_date, $end_date])->distinct()->get();

                        $userData = User::where("user_role", 'user')->where("add_attendance", '1')->get();

                        $userArray = [];
                        $index = 0;


                        foreach ($userData as $data) {
                                $userId = $data->id;
                                $userName = $data->first_name;

                                $basicHourSum = Attendence::select(DB::raw('SUM(TIME_TO_SEC(work_time)) as worktime'))
                                        ->where("user_id", $userId)->where('date', '>=', $startdate)->where('date', '<=', $end_date)->get()->toarray();

                                $overTimeHourSum = Attendence::select(DB::raw('SUM(TIME_TO_SEC(overtime)) as overtime'))
                                        ->where("user_id", $userId)->where('date', '>=', $startdate)->where('date', '<=', $end_date)->where("status", "1")->get()->toarray();

                                // $totalHourSum = $basicHourSum+$overTimeHourSum;
                                $userArray[$index] = $userId;
                                $index += 1;
                                $userArray[$index] = $userName;
                                $index += 1;
                                $userArray[$index] = $basicHourSum;
                                $index += 1;
                                $userArray[$index] = $overTimeHourSum;
                                $index += 1;
                                $tempBasicHour = $userArray[$index - 2][0]['worktime'];
                                $originalbasichours = explode('.', $tempBasicHour);
                                $tempOverHour = $userArray[$index - 1][0]['overtime'];
                                $originalOverhours = explode('.', $tempOverHour);
                                $userArray[$index - 2] = $originalbasichours[0];
                                $userArray[$index - 1] = $originalOverhours[0];
                        }
                        // dd($userArray);



                        return view('Admin/newsearch', get_defined_vars());

                        //  $user= Attendence::with('user')


                        //  ->select(DB::raw('SUM(total_hours) as total,SUM(TIME_TO_SEC(overtime)) as overtime,user_id'))
                        //  ->where('date','>=',$date)->where('date','<=',$statdate)->whereHas('user', function ($query) use ($request) {
                        //             return $query->where('user_role','user');
                        //            })->groupby('user_id')->get();


                        //            $userover= Attendence::with('user')
                        //  ->select(DB::raw('SUM(TIME_TO_SEC(overtime)) as overtime,user_id'))->where('status',1)
                        //  ->where('date','>=',$date)->where('date','<=',$statdate)->whereHas('user', function ($query) use ($request) {
                        //             return $query->where('user_role','user');
                        //            })->groupby('user_id')->get();
                        // dd($userover);

                        //dd($search['date_bw_data']);
                        // dd($request->cycle,$request->start_date);
                }






                return view('Admin/newsearch', compact('threshold', 'department', 'users'));
                // if($request->Emp !='')
                // {

                //     $post = User::find($request->Emp)->attendance;
                //     $user_id=$post[0]->user_id;
                //     $search['attendence_id']=$post[0]->id;

                //     $search['users_name']=User::where('id',$user_id)->select('first_name','id')->first();
                //     $hours = Attendence::where('user_id', $user_id)->sum('total_hours');
                // $overtime= Attendence::where('user_id', $user_id)->sum(DB::raw("TIME_TO_SEC(overtime)"));
                //      $search['over'] =gmdate("H:i", $overtime);

                //      $search['hours'] =gmdate("H:i", $hours);

                // }
                // if($request->Dept !='')
                // {
                //     $search['users_name_dep']=User::where('department',$request->Dept)->select('first_name','id')->get();
                // }


        }

        public function PayrollStartFunc()
        {
                $payroll_s = PayrollStart::get();
                return view('admin.payroll_start', get_defined_vars());
        }
        public function AddStartDate(Request $request)
        {
                $c_year = Carbon::now()->year;
                $check_s = PayrollStart::where('Year', $c_year)->count();
                if ($check_s > 0) {
                        return redirect()->back()->with('error', 'Start Date Already Added for this Year');
                }

                $payroll = new PayrollStart();
                $payroll->start_date = $request->start_d;
                $year = Carbon::now()->format('Y');
                $payroll->Year = $year;
                $payroll->save();
                return redirect()->back();
        }
        public function EditStartDate($id)
        {
                $payroll = PayrollStart::find($id);
                return view('admin.edit_payroll_start', get_defined_vars());
        }
        public function UpdateStartDate(Request $request, $id)
        {
                $payroll = PayrollStart::find($id);
                $payroll->start_date = $request->s_d;
                $payroll->save();
                $payroll_s = PayrollStart::get();
                return view('admin.payroll_start', get_defined_vars());
        }
        public function ViewBonus()
        {
                $bonusData = Bonuse::get();
                return view('admin.bonus', get_defined_vars());
        }
        public function UpdateBonus(Request $request)
        {
                $bonusData2 = Bonuse::where('user_id', $request->user_id)->where('start_date', $request->start_date)->where('end_date', $request->end_date)->first();
                $bonusData2->bonus = $request->bonus;
                $bonusData2->save();
                $bonusData = Bonuse::get();
                return view('admin.bonus', compact("bonusData"))->with('success', 'Bonus successfully Updated!');
        }
        public function EditBonus(Request $request, $id, $start_d, $end_d)
        {

                $bonusData = Bonuse::where('user_id', $id)->where('start_date', $start_d)->where('end_date', $end_d)->first();
                return view('Admin/editBonus', compact("bonusData"));
        }
        public function filter_attendance(Request $request)
        {
        }
        public function atten_get(Request $request)
        {
                // dd($request->start_date,$request->end_date);
                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $user_id = $request->user_id;
                $user_total_hours = $request->totalhours;
                $user_total_mint = $request->totalm;
                $user_basic_hour = $request->hoursBasihourctime;
                $user_Basic_mint = $request->minBasic;
                $user_overtime_hours = $request->hoursOverTime;
                $user_over_mint = $request->totOverTimeMin;
                $user_incometax = $request->incometax;
                $atten_get = User::where('id', $user_id)->first();
                $hourly_rate = $atten_get->hourly_rate;
                $ORP = $atten_get->ot_rate;
                //$regular_hours=$atten_get->regular_hours;
                $regular_hours = 80;
                $Nis = $atten_get->nis;
                $first_name = $atten_get->first_name . ' ' . $atten_get->last_name;
                $dep_id = $atten_get->department;
                $ORP = $atten_get->ot_rate;
                $trn = $atten_get->trn;
                $total_work_hours_and_minits = $user_total_hours . ':' . $user_total_mint;
                $total_work_Basic_hours_and_minits = $user_basic_hour . ':' . $user_Basic_mint;
                $total_work_Over_hours_and_minits = $user_overtime_hours . ':' . $user_over_mint;

                // dd($ORP);
                //regular pay 8 hours per day
                $hoursREGPAY = $user_basic_hour * $hourly_rate;
                $basicmin = ($hourly_rate / 60) * $user_Basic_mint;
                $total_basic_pay_rate = $hoursREGPAY + $basicmin;
                //total overtime pay


                $Overtimepay = $user_overtime_hours * $ORP;
                $overtimeminutespay = ($ORP / 60) * $user_over_mint;
                $total_basic_pay = $Overtimepay + $overtimeminutespay;
                // dd($totalovertime);

                // $user_id = $request->atten_id;
                // $get_signle_atten=User::where('id',$user_id)->first();
                $Nis = $atten_get->nis;

                $rate = $hourly_rate + $ORP;


                $sum = round($total_basic_pay_rate, 2) + round($total_basic_pay, 2);



                $department_get = Department::where('id', $dep_id)->select('department')->first();
                $department_name = $department_get->department;
                $deduction = Deduction::get()->toarray();
                //nis
                $nis_value_percentage = $deduction[0]['nis_fix_value'];
                $nis_limit_value = $deduction[0]['nis'];
                //nht
                $nht_value_percentage = $deduction[1]['nis_fix_value'];
                $edtax_value_percentage = $deduction[2]['nis_fix_value'];
                $bonusPay = Bonuse::select('bonus')->where('start_date', $start_date)->where('end_date', $end_date)->where('user_id', $user_id)->first();
                if ($bonusPay == null) {
                        $bonus = 0;
                } else {
                        $bonus = $bonusPay->bonus;
                }
                return response()->json([
                        'id_user' => $request->user_id, 'department' => $department_name, 'regular_hours' => $regular_hours, 'first_name' => $first_name, 'total_over_time_pay' => round($total_basic_pay, 2),
                        'total_work_hours_and_minits' => $total_work_hours_and_minits,
                        'total_basic_pay' => round($total_basic_pay_rate, 2), 'sum' => $sum + $bonus, 'total_work_Basic_hours_and_minits' => $total_work_Basic_hours_and_minits,
                        'over_time_rate' => $ORP, 'hourly_rate' => $hourly_rate, 'nis' => $Nis, 'total_work_Over_hours_and_minits' => $total_work_Over_hours_and_minits,
                        'trn' => $trn, 'bonusPay' => $bonus, 'user_incometax' => $user_incometax, 'rate' => $rate, 'nis_value_percentage' => $nis_value_percentage, 'nis_limit_value', $nis_limit_value, 'nht_value_percentage' => $nht_value_percentage, 'edtax_value_percentage' => $edtax_value_percentage
                ]);
        }

        public function Addbonus(Request $request)
        {
                $period_from = $request->start_date;
                $period_to = $request->end_date;
                $users = User::where('department', $request->department)->where('user_role', 'user')->get();

                return view('Admin\bonusadd', get_defined_vars());
        }

        public function storeBonus(Request $request)
        {
                $bonusCount = Bonuse::where('start_date', $request->period_from)->where('end_date', $request->period_to)->count();

                if ($bonusCount != 0) {
                        return redirect()->back()->with('error', 'Your Bonus Already Added For This Period!');
                } else {
                        for ($i = 0; $i < count($request->user_id); $i++) {
                                $bonus_start = $request->period_from[$i];
                                $bonus_end = $request->period_to[$i];



                                Bonuse::create([
                                        'user_id'  => $request->user_id[$i],
                                        'name'     => $request->first_name[$i] . ' ' . $request->last_name[$i],
                                        'sttsus' => 0,
                                        'start_date' => $request->period_from[$i],
                                        'end_date' => $request->period_to[$i],
                                        'bonus' => $request->bonus[$i],
                                ]);
                        }
                        return redirect()->back()->with('message', 'Your Bonus Add Successfully!');
                }
        }
        public function payrol_proceed(Request $request)
        {
                $user_id = $request->user_id;
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $nis = $request->nis;
                $nht = $request->nht;
                $edtax = $request->edtax;
                $netpay = $request->netpay;
                $uBonus = $request->bonus;
                $userBonus = Str::remove('$', $uBonus);
                $incometax = $request->income_save;
                $deptartment_ = $request->dept;
                $emp_name = $request->emp_name;
                $count = Proceed::where('start_date', $start_date)->where('end_date', $end_date)->where('user_id', $user_id)->count();

                if ($count > 0) {
                        return 1;
                } else {
                        $success = 'Successfully  payroll ADD';

                        $c_year = Carbon::now()->year;
                        $proceed = new Proceed();
                        $proceed->user_id = $user_id;
                        $proceed->start_date = $start_date;
                        $proceed->end_date = $end_date;
                        $proceed->user_id = $user_id;
                        $proceed->nis = $nis;
                        $proceed->nht = $nht;
                        $proceed->edtax = $edtax;
                        $proceed->total_pay = $netpay;
                        $proceed->status = 1;
                        $proceed->income = $incometax;
                        $proceed->year = $c_year;
                        $proceed->bonus = $userBonus;
                        $proceed->dept = $deptartment_;
                        $proceed->emp_name = $emp_name;
                        $proceed->save();
                        return 0;
                }
        }
}
