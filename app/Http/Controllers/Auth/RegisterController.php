<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\{User, UserDetail, UserWallet};
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'max:50'],
            'id_card_front' => ['required', 'mimes:jpeg,png,jpg,gif,svg,heic'],
            'id_card_back' => ['required', 'mimes:jpeg,png,jpg,gif,svg,heic'],
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is not valid',
            'email.unique' => 'Email is already taken',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 3 characters',
            'password.max' => 'Password must be at most 50 characters',

            'id_card_front.required' => 'ID Card Front is required',
            'id_card_front.mimes' => 'ID Card Front must be a file of type: jpeg, png, jpg, gif, svg, heic',

            'id_card_back.required' => 'ID Card Back is required',
            'id_card_back.mimes' => 'ID Card Back must be a file of type: jpeg, png, jpg, gif, svg, heic',
        ]);
    }

    protected function create(array $data)
    {
        //Creating User
        $user = new User();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->profile_picture = 'avatar-1.jpg';
        $user->save();

        //Assigning User Role
        $user->assignRole('User');

        //Creating User Wallet
        UserWallet::create(['user_id' => $user->id]);

        //Creating User Details
        $userDetail = new UserDetail();
        $userDetail->user_id = $user->id;

        //Checking Selected Selfie Radio
        switch ($data['selfie_radio']) {
            case 'selfie_take_picture':
                
                //Getting Selfie & Setting Name
                $file = $data['selfie_input_hidden'];

                //Exploding Array
                $image_parts = explode(";base64,", $file);
                $image_type_aux = explode("image/", $image_parts[0]);
                if(isset($image_type_aux[1])){
                    $image_type = $image_type_aux[1];
                }else{
                    $image_type = "photo";
                }
                

                //Setting File Name
                $fileName = uniqid().'.'.$image_type;
                
                //Setting File Path        
                $filePath = 'files/users/'.$user->id.'/verificationDocuments/'.$fileName;
               
                $image_base64 = base64_decode(uniqid().time());
        
                //Uploading File to Local Storage
                Storage::disk('local')->put($filePath, $image_base64);
                
                //Setting Selfie File
                $userDetail->selfie = $filePath;

                break;

            case 'selfie_upload_file':
                
                //Getting File & Setting Name
                $file = $data['selfie_input_field'];
                $fileName = time().'-'.$file->getClientOriginalName();
                
                //Setting File Path        
                $filePath = 'files/users/'.$user->id.'/verificationDocuments/'.$fileName;
                
                //Uploading File to Local Storage
                Storage::disk('local')->put($filePath, file_get_contents($file));
                
                //Setting Selfie File
                $userDetail->selfie = $filePath;

                break;
        }
        
        //------------ Storing ID Card Front -------------------
        $file = $data['id_card_front'];
        $fileName = uniqid().time().'-'.$file->getClientOriginalName();
        
        //Setting File Path        
        $filePath = 'files/users/'.$user->id.'/verificationDocuments/'.$fileName;
        
        //Uploading File to Local Storage
        Storage::disk('local')->put($filePath, file_get_contents($file));
        
        //Setting ID Card Front File
        $userDetail->idCardFront = $filePath;

        //-------------Storing ID Card Back --------------------
        $file = $data['id_card_back'];
        $fileName = uniqid().time().'-'.$file->getClientOriginalName();
        
        //Setting File Path        
        $filePath = 'files/users/'.$user->id.'/verificationDocuments/'.$fileName;
        
        //Uploading File to Local Storage
        Storage::disk('local')->put($filePath, file_get_contents($file));
        
        //Setting ID Card Front File
        $userDetail->idCardBack = $filePath;
        $userDetail->save();

        //Returning User
        return $user;
    }
}