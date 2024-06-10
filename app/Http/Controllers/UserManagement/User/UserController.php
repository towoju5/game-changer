<?php

namespace App\Http\Controllers\UserManagement\User;

use App\Models\ChFavorite;
use App\Models\WelcomeNote;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\{DigitalAsset, Transaction, User, UserWallet};

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'under-review'])->except(['depositIpn']);
    }
    
    public function index()
    {
        $users = User::with('roles')->get();
        return view('dashboard.user-management.user.list', compact('users'));
    }

    public function adminStructure()
    {
        $users = User::role('Administrator')->get();
        $digitalAssets = DigitalAsset::all();
        return view('dashboard.user-management.user.administrator', compact('users','digitalAssets'));
    }

    public function changeBalance(Request $request)
    {
        dd($request->all());
        $users = User::role('Administrator')->get();
        $digitalAssets = DigitalAsset::all();
        return view('dashboard.user-management.user.administrator', compact('users','digitalAssets'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('dashboard.user-management.user.add', compact('roles'));
    }

    public function store(Request $request)
    {
        //Performing Validations
        $validator = \Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required']
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Email or Username already exists please try again with another one!');
        }

        //Creating User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'email_verified_at' => now(),
            'account_verification' => 'Approved',
            'password' => \Hash::make($request->password),
            'profile_picture' => 'avatar-1.jpg'
        ]);

        //Assigning Role
        $user->assignRole($request->role);

        //add private space to the administrator
        if($request->role == 'Administrator'){
            $favourite = new ChFavorite();
            $favourite->user_id = $user->id;
            $favourite->favorite_id = 44;
            $favourite->save();
        }


        //Creating User Wallet
        UserWallet::create(['user_id' => $user->id]);

        return redirect('/user/list')->with('success', 'User Added Successfully!');
    }

    public function deposit(Request $request)
    {

        //Performing Validations
        $validator = \Validator::make($request->all(), [
            'amount' => ['required'],
            'payment_type' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Amount is Required');
        }

        $trx = 'DEP-'.time().'-'.random_int(100, 999);

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->amount = $request->amount;
        $transaction->charge = 0.00;
        $transaction->post_balance = Auth::user()->balance + $request->amount;
        $transaction->trx_type = 'Deposit';
        $transaction->status = 0;
        $transaction->trx = $trx;
        $transaction->details = 'Deposit Balance';
        $transaction->remark = 'deposit';
        $transaction->wallet_type = 'balance_wallet';
        $transaction->save();

        if($request->payment_type == 'crypto'){
            $response =  generateNowPaymentsAddress($request->amount,'BTC',$trx);
        }else{
            return redirect()->back()->with('warning', 'Something Went Wrong');
        }
    
       if($response['redirect']){

        return redirect($response['redirect_url']);
       }else{

        return redirect()->back()->with('warning', $response['message']);
       }
    }

    public function depositSuccess(){
        return redirect()->route('balance')->with('success','Deposit was Successfull.');
    }

    public function depositCancel(){
        return redirect()->route('balance')->with('warning','Deposit Canceled Successfully.');
    }

    public function depositIpn(){
       if (isset($_SERVER['HTTP_X_NOWPAYMENTS_SIG']) && !empty($_SERVER['HTTP_X_NOWPAYMENTS_SIG'])) {
            $recived_hmac = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'];
            $request_json = file_get_contents('php://input');
            $request_data = json_decode($request_json, true);
            if ($request_json !== false && !empty($request_json)) {
        
                if ($request_data['payment_status'] == 'confirmed' || $request_data['payment_status'] == 'finished' || $request_data['payment_status'] == 'partially_paid') {
                    $transaction = Transaction::where('trx',$request_data['order_id'])->where('status',0)->first();
                    if(!empty($transaction->trx)){
                        $transaction->status = 1;
                        $transaction->save();
                        
                        $user = User::where('id',$transaction->user_id)->first();
                        $user->balance = (float)((float)$user->balance + (float)$transaction->amount);
                        $user->save();                                
                    }
                }
                
            }
       }
    }
    
    function customLog($txt,$filename,$doEncode=false)
    {
        
        if($doEncode){ $txt = json_encode($txt); }
        $filename = $filename.'.txt';
        $oldContent = "\n";
        if (file_exists($filename)) {
            $oldContent = file_get_contents($filename);
            $myfile = fopen($filename, "w") or die("Unable to open file!");
        } else {
            $myfile = fopen($filename, "wb");
        }
        fwrite($myfile, "$oldContent\n");
        fwrite($myfile, "........START.........\n");
        fwrite($myfile, $txt."\n");
        fwrite($myfile, "........END.........\n");
        fclose($myfile);
    }

    public function edit($id)
    {
        $user = User::with('roles')->find(decrypt($id));
        $roles = Role::all();

        return view('dashboard.user-management.user.edit', compact('user','roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find(decrypt($id));

        //Performing Validations
        $validator = \Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username,'.$user->id],
            'email' => ['required', 'unique:users,email,'.$user->id],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Email or Username already exists please try again with another one!');
        }

        //Checking if Password is changed
        if($request->password != null){
            $user->password = \Hash::make($request->password);
        }

        //Updating User
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        //Syncing Role
        $user->syncRoles($request->role);

        return redirect('/user/list')->with('success', 'User Updated Successfully!');
    }

    public function destroy($id)
    {
        User::find(decrypt($id))->delete();
        return redirect('/user/list')->with('success', 'User Deleted Successfully!');
    }

    public function documents($id)
    {
        $user = User::with('detail')->find(decrypt($id));

        $welcome_notes = WelcomeNote::all();

        return view('dashboard.user-management.user.details.documents', compact('user','welcome_notes'));
    }
}