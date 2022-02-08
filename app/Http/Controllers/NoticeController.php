<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;


class NoticeController extends Controller
{
    public function Notices()
    {
        $notice = Notice::get();
        return view('Admin.notice', get_defined_vars());
    }

    public function NoticesDelete(Request $request, $id)
    {
        $notice = Notice::find($id);
        $notice->delete();
        return redirect()->back()->with('message', 'Delete Successfully NoticeBoard');
    }


    public function AddNotices(Request $request)
    {
        // dd($request->title,$request->from_date,$request->to_date,$request->description);
        $id = Auth::user()->id;
        // dd($id);
        $addVal = new Notice;
        $addVal->user_id = $id;
        $addVal->title = $request->title;
        $addVal->start_date = $request->from_date;
        $addVal->end_date = $request->to_date;
        $addVal->description = implode(',', $request->content);

        $addVal->save();

        return redirect()->back()->with('message', 'Add Successfully NoticeBoard');
    }



    public function EditNotices(Request $request)
    {
        // dd($request->title,$request->from_date,$request->to_date,$request->description);
        $login = Auth::user()->id;
        $id = $request->id;
        $addVal = Notice::where('id', $id)->first();
        $addVal->user_id = $login;
        $addVal->title = $request->title;
        $addVal->start_date = $request->from_date;
        $addVal->end_date = $request->to_date;
        $addVal->description = implode(',', $request->desciption);

        $addVal->save();

        return redirect()->back()->with('message', 'Update Successfully NoticeBoard');
    }
}
