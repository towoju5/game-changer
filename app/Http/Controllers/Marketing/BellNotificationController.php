<?php

namespace App\Http\Controllers\Marketing;

use Auth;
use Storage;
use App\Models\User;
use App\Models\BellNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Usernotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BellNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $bellNotifications = BellNotification::all();

        return view('dashboard.marketing.bell-notification.list',compact('bellNotifications'));
    }

    public function create()
    {
        return view('dashboard.marketing.bell-notification.add');
    }

    public function preview($id)
    {
        $bellNotification = BellNotification::find($id);
        $users = User::role('User')->get();
        return view('dashboard.marketing.bell-notification.preview',compact('bellNotification','users'));
    }

    public function sendToAll(Request $request,$id)
    {


        $users = User::role('User')->get();

        BellNotification::find($id)->increment('useage_count');

        $notify = BellNotification::find($id);

        foreach($users as $user){
            $notification = new Usernotification();
            $notification->user_id = $user->id;
            $notification->messages = $notify->messages;
            $notification->save();
        }

        return redirect('marketing/bell-notifications/list')->with('success', 'Notification Send Successfully!');
    }

    public function edit($id)
    {
        $bellNotification = BellNotification::find($id);
        return view('dashboard.marketing.bell-notification.edit',compact('bellNotification'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'duration_day' => ['required'],
            'message_body' => ['required'],
            'duration_time' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter all the Required field');
        }

        $duration = Carbon::parse($request->duration_day.' '.$request->duration_time)->format('Y-m-d H:i:s');

        $template                 = new BellNotification();
        $template->messages       = $request->message_body;
        $template->duration       = $duration;
        $template->useage_count   = 0;
        $template->save();

        return redirect('marketing/bell-notifications/list')->with('success', 'Bell Notification Added Successfully!');
    }

    public function update(Request $request, $id)
    {
        //Performing Validations
        $validator = Validator::make($request->all(), [
            'duration_day' => ['required'],
            'message_body' => ['required'],
            'duration_time' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter all the Required field');
        }

        $duration = Carbon::parse($request->duration_day.' '.$request->duration_time)->format('Y-m-d H:i:s');

        $template                 = BellNotification::find($id);
        $template->messages       = $request->message_body;
        $template->duration       = $duration;
        $template->useage_count   = 0;
        $template->update();

        return redirect('marketing/bell-notifications/list')->with('success', 'Bell Notification Updated Successfully!');
    }

    public function destroy($id)
    {
        $template = BellNotification::find($id);
        $template->delete();

        return redirect('marketing/bell-notifications/list')->with('success', 'Bell Notification Deleted Successfully!');
    }

}