<?php

namespace App\Http\Controllers\Marketing;

use Auth;
use Storage;
use App\Models\User;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $templates = Template::all();

        return view('dashboard.marketing.template.list',compact('templates'));
    }

    public function create()
    {
        return view('dashboard.marketing.template.add');
    }

    public function preview($id)
    {
        $template = Template::find($id);
        $users = User::role('User')->get();
        return view('dashboard.marketing.template.preview',compact('template','users'));
    }

    public function sendNotificationToAll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'template_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = User::role('User')->skip($request->skip)->first();
        $template = Template::find($request->template_id);
        $template->last_sent = Carbon::now();
        $template->update();

        if (!$user) {
            return response()->json([
                'error'=>'User not found',
                'total_sent'=>0,
            ]);
        }
        
        //Setting Data for Email
        $data = ['name' => $user->first_name, 'email' => $user->email];
        
       // Sending Email
        Mail::send([], [], function($message) use($data, $template){
            $message->to($data['email'], $data['name'])->subject($template->subject);
            $message->from(config('mail.from.address'),config('mail.from.name'));
            $message->html($template->body);
        });

        return response()->json([
            'success'    => 'message sent',
            'total_sent' => $request->skip + 1,
        ]);
       return ['success'=> 'Notification is sent to all.'];
    }

    public function edit($id)
    {
        $template = Template::find($id);
        return view('dashboard.marketing.template.edit',compact('template'));
    }

    public function store(Request $request)
    {
        //Performing Validations
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'email_body' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter Email Subject or Email Body');
        }

        $template               = new Template();
        $template->subject         = $request->subject;
        $template->body   = $request->email_body;
        $template->save();

        return redirect('marketing/templates/list')->with('success', 'Template Added Successfully!');
    }

    public function update(Request $request, $id)
    {
        //Performing Validations
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'email_body' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter Email Subject or Email Body');
        }

        $template               = Template::find($id);
        $template->subject         = $request->subject;
        $template->body   = $request->email_body;
        $template->update();

        return redirect('marketing/templates/list')->with('success', 'Template Updated Successfully!');
    }

    public function destroy($id)
    {
        $template = Template::find($id);
        $template->delete();

        return redirect('marketing/templates/list')->with('success', 'Template Deleted Successfully!');
    }

}