<?php

namespace App\Http\Controllers\UserManagement\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\{User, ChMessage, ChFavorite, WelcomeNote};

class UserAccountVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'under-review']);
    }

    public function index($id)
    {
        $user = User::with('detail')->find(decrypt($id));

        $welcome_notes = WelcomeNote::all();

        return view('dashboard.user-management.user.details.verify', compact('user','welcome_notes'));
    }

    public function download_document($type, $id)
    {
        $user = User::with('detail')->find(decrypt($id));

        switch ($type) {
            case 'selfie':
                return response()->file(storage_path('app/'.$user->detail->selfie));
            case 'idCardFront':
                return response()->file(storage_path('app/'.$user->detail->idCardFront));
            case 'idCardBack':
                return response()->file(storage_path('app/'.$user->detail->idCardBack));
        }
    }

    public function approve(Request $request, $id)
    {
        $user = User::find(decrypt($id));

        //Setting Data for Email
        $data = ['name' => $user->first_name, 'email' => $user->email];
        
    //   Sending Email
        Mail::send('emails.accountVerification.accountApproved', $data, function($message) use($data){
            $message->to($data['email'], $data['name'])
                    ->subject('Account Update');
            $message->from(config('mail.from.address'),config('mail.from.name'));
        });

        //Updating User Data
        $user->update([
            'account_verification' => 'Approved',
        ]);

        //Sending Welcome Chat Message
        $message = new ChMessage();
        $message->from_id = \Auth::id();
        $message->to_id = $user->id;
        $message->body = $request->welcome_note ?? 'Welcome to GC7 Cafe! We are glad to have you on board. If you have any queries, feel free to ask us. We are here to help you. Enjoy your time here! 😀';
       
        $message->save();

        //Marking Super Admin as Favorites
        $favourite = new ChFavorite();
        $favourite->user_id = $user->id;
        $favourite->favorite_id = 1;
        $favourite->save();

        //Marking Super Admin as Favorites
        $favourite = new ChFavorite();
        $favourite->user_id = $user->id;
        $favourite->favorite_id = 2;
        $favourite->save();

        //Marking Super Admin as Favorites
        $favourite = new ChFavorite();
        $favourite->user_id = $user->id;
        $favourite->favorite_id = 3;
        $favourite->save();

        return redirect('/user/list')->with('success', 'User Account Approved Successfully!');
    }

    public function suspend(Request $request, $id)
    {
        $user = User::find(decrypt($id));

        //Setting Data for Email
        $data = ['name' => $user->first_name, 'email' => $user->email, 'reason' => $request->suspension_reason];
        
        //Sending Email
        Mail::send('emails.accountVerification.accountSuspended', $data, function($message) use($data){
            $message->to($data['email'], $data['name'])
                    ->subject('Account Update');
            $message->from('no-reply@gc7cafe.com','GC7 Cafe');
        });

        //Updating User Data
        $user->update([
            'account_verification' => 'Suspended',
        ]);

        return redirect('/user/list')->with('success', 'User Account Suspended Successfully!');
    }
}