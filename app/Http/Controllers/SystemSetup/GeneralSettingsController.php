<?php

namespace App\Http\Controllers\SystemSetup;

use Auth;
use Storage;
use App\Models\User;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\WelcomeNote;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GeneralSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $settings = GeneralSettings::all();
        $welcome_notes = WelcomeNote::all();

        return view('dashboard.system-setup.general-settings',compact('settings', 'welcome_notes'));
    }

    public function create()
    {
        return view('dashboard.system-setup.welcome-note.add');
    }

    public function edit($id)
    {
        $note = GeneralSettings::find($id);
        return view('dashboard.system-setup.welcome-note.edit',compact('note'));
    }

    public function store(Request $request)
    {
       
        //Performing Validations
        $validator = Validator::make($request->all(), [
            'default_welcome_note' => ['required']
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter Email Subject or Email Body');
        }


        $file = $request->file('chat_background');
        $fileName = time().'-'.$file->getClientOriginalName();
        //Setting File Path        
        $filePath = 'images/'.$fileName;
        //Uploading File
        $file->move(public_path('images'), $fileName);

        $request['chat_background_image'] = $filePath;



        foreach($request->except('_token') as $key => $value){
            $settings = GeneralSettings::where('key',$key)->exists();
            if($settings){
                $setting               = GeneralSettings::where('key',$key)->first();
                $setting->key          = $key;
                $setting->value        = $value;
                $setting->update();
            }else{
                $setting               = new GeneralSettings();
                $setting->key          = $key;
                $setting->value        = $value;
                $setting->save();
            }

        }

        return redirect()->back()->with('success', 'Settings Saved Successfully!');
    }

    public function update(Request $request, $id)
    {

        //Performing Validations
        $validator = Validator::make($request->all(), [
            'note' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter Email Subject or Email Body');
        }

        $note               = GeneralSettings::find($id);
        $note->note         = $request->note;
        $note->update();

        return redirect('system-setup/welcome-note/list')->with('success', 'Welcome Note Updated Successfully!');
    }

    public function destroy($id)
    {
        $template = GeneralSettings::find($id);
        $template->delete();

        return redirect('system-setup/welcome-note/list')->with('success', 'Welcome Note Deleted Successfully!');
    }

}