<?php

namespace App\Http\Controllers\ProfileManagement;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        return view('dashboard.profile-management.profile');
    }

    public function edit()
    {
        return view('dashboard.profile-management.edit-profile');
    }

    public function update_profile(Request $request)
    {
        //Preforming Validations
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:64|min:3',
            'last_name' => 'required|max:64|min:3',
            'username' => 'required|max:64|min:3|unique:users,username,'.Auth::id()
        ],[
            'first_name.required' => 'The first name field is required.',
            'first_name.min' => 'The first name must be at least 3 characters.',
            'first_name.max' => 'The first name must be at most 64 characters.',

            'last_name.required' => 'The last name field is required.',
            'last_name.min' => 'The last name must be at least 3 characters.',
            'last_name.max' => 'The last name must be at most 64 characters.',
            
            'username.required' => 'The username field is required.',
            'username.unique' => 'The username has already been taken.',
            'username.min' => 'The username must be at least 3 characters.',
            'username.max' => 'The username must be at most 64 characters.',
        ]);

        //Returning Error if Validation Fails
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->save();

        //Send Mails to Every Administrator.
        $users = User::role('Administrator')->get();

        foreach($users as $user){

            $data = ['name' => $user->first_name, 'email' => $user->email];

            // Mail::send([], [], function($message) use($data){
            //     $message->to($data['email'], $data['name'])->subject("🌟 Verification Request for Profile Update: Urgent Action Required 🌟");
            //     $message->from(config('mail.from.address'),config('mail.from.name'));
            //     $message->html(get_settings('email_for_account_verification'));
            // });
        }
        


        return redirect('/profile')->with('success', 'Profile Updated Successfully!');
    }

    public function update_password(Request $request)
    {
        //Preforming Validations
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:64|confirmed',
        ],[
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must be at most 64 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        //Returning Error if Validation Fails
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/profile')->with('success', 'Password Updated Successfully!');
    }

    public function update_avatar(Request $request)
    {
        //Preforming Validations
        $validator = Validator::make($request->all(), [
            'file' => 'required|image',
        ],[
            'file.required' => 'The file field is required.',
            'file.image' => 'The file must be an image.',
        ]);

        //Returning Error if Validation Fails
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        //Getting File & Setting Name
        $file = $request->file('file');
        $fileName = time().'-'.$file->getClientOriginalName();
        
        //Setting File Path        
        $filePath = 'images/'.$fileName;
        
        //Uploading File
        $file->move(public_path('images'), $fileName);

        $user = Auth::user();
        $user->profile_picture = $filePath;
        $user->save();

        return redirect('/profile')->with('success', 'Avatar Updated Successfully!');
    }

    public function update_documents(Request $request)
    {
        $userDetail = Auth::user()->detail;

        //Preforming Validations
        $validator = Validator::make($request->all(), [
            'selfie' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,heic'],
            'idCardFront' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,heic'],
            'idCardBack' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,heic'],
        ],[
            'selfie.required' => 'Selfie is required',
            'selfie.image' => 'Selfie must be an image',
            'selfie.mimes' => 'Selfie must be a file of type: jpeg, png, jpg, gif, svg, heic',

            'idCardFront.required' => 'ID Card Front is required',
            'idCardFront.image' => 'ID Card Front must be an image',
            'idCardFront.mimes' => 'ID Card Front must be a file of type: jpeg, png, jpg, gif, svg, heic',

            'idCardBack.required' => 'ID Card Back is required',
            'idCardBack.image' => 'ID Card Back must be an image',
            'idCardBack.mimes' => 'ID Card Back must be a file of type: jpeg, png, jpg, gif, svg, heic',
        ]);

        //Returning Error if Validation Fails
        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first());
        }

        // Storing Selfie
        $file = $request->file('selfie');
        $fileName = uniqid().'-'.$file->getClientOriginalName();
        
        //Setting File Path        
        $filePath = 'files/users/'.Auth::id().'/verificationDocuments/'.$fileName;
        
        //Uploading File to Local Storage
        Storage::disk('local')->put($filePath, file_get_contents($file));
        
        //Setting Selfie File
        $userDetail->selfie = $filePath;

        // ----------------------------------------------------------------------------------- //

        // Storing ID Card Front
        $file = $request->file('idCardFront');
        $fileName = uniqid().'-'.$file->getClientOriginalName();
        
        //Setting File Path        
        $filePath = 'files/users/'.Auth::id().'/verificationDocuments/'.$fileName;
        
        //Uploading File to Local Storage
        Storage::disk('local')->put($filePath, file_get_contents($file));
        
        //Setting ID Card Front File
        $userDetail->idCardFront = $filePath;

        // ----------------------------------------------------------------------------------- //

        // Storing ID Card Back
        $file = $request->file('idCardBack');
        $fileName = uniqid().'-'.$file->getClientOriginalName();
        
        //Setting File Path        
        $filePath = 'files/users/'.Auth::id().'/verificationDocuments/'.$fileName;
        
        //Uploading File to Local Storage
        Storage::disk('local')->put($filePath, file_get_contents($file));
        
        //Setting ID Card Front File
        $userDetail->idCardBack = $filePath;
        $userDetail->save();

        //Setting User Account Verification Status
        Auth::user()->update([
            'account_verification' => 'Under Review'
        ]);

        return redirect()->back()->with('success', 'Documents Updated Successfully!');
    }
}