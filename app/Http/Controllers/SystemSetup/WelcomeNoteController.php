<?php

namespace App\Http\Controllers\SystemSetup;

use Auth;
use Storage;
use App\Models\User;
use App\Models\WelcomeNote;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class WelcomeNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $notes = WelcomeNote::all();

        return view('dashboard.system-setup.welcome-note.list',compact('notes'));
    }

    public function create()
    {
        return view('dashboard.system-setup.welcome-note.add');
    }

    public function edit($id)
    {
        $note = WelcomeNote::find($id);
        return view('dashboard.system-setup.welcome-note.edit',compact('note'));
    }

    public function store(Request $request)
    {
        //Performing Validations
        $validator = Validator::make($request->all(), [
            'note' => ['required']
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter Email Subject or Email Body');
        }

        $note               = new WelcomeNote();
        $note->note         = $request->note;
        $note->save();

        return redirect('system-setup/welcome-note/list')->with('success', 'Welcome Note Added Successfully!');
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

        $note               = WelcomeNote::find($id);
        $note->note         = $request->note;
        $note->update();

        return redirect('system-setup/welcome-note/list')->with('success', 'Welcome Note Updated Successfully!');
    }

    public function destroy($id)
    {
        $template = WelcomeNote::find($id);
        $template->delete();

        return redirect('system-setup/welcome-note/list')->with('success', 'Welcome Note Deleted Successfully!');
    }

}