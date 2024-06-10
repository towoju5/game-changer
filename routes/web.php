<?php

use App\Http\Controllers\InvoiceController;
use App\Models\PayButtonModel;
use App\Models\User;
use App\Models\ChFavorite;
use App\Models\GeneralSettings;
use App\Models\BellNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Marketing\TemplateController;
use App\Http\Controllers\SystemSetup\WelcomeNoteController;
use App\Http\Controllers\UserManagement\Role\RoleController;
use App\Http\Controllers\UserManagement\User\UserController;
use App\Http\Controllers\ProfileManagement\ProfileController;
use App\Http\Controllers\Marketing\BellNotificationController;
use App\Http\Controllers\DigitalAssets\Wallet\WalletController;
use App\Http\Controllers\SystemSetup\GeneralSettingsController;
use App\Http\Controllers\DigitalAssets\MarketPlace\MarketPlaceController;
use App\Http\Controllers\UserManagement\User\UserAccountVerificationController;
use Khomeriki\BitgoWallet\Facades\Wallet;
use App\Http\Controllers\CheckoutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("verifi", function () {
    return PayButtonModel::get();
    return view('checkout.pay');
    // $user = request()->user();
    // $user->email_verified_at = now();
    // $user->save();
    // $wallet = Wallet::init(coin: 'tbtc')
    //             ->generate(label: 'wallet label', passphrase: 'password')
    //             ->addWebhook(numConfirmations: 1);

                    
    // return $wallet;

});

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
});

// Route::get('/test', function () {
//     $user =  User::find(1);
//     $role = $user->getRoleNames()->first();
//     dd($role);
// });

Route::get('/private-space', function () {
    $users = User::role('Administrator')->get();
    foreach ($users as $user) {
        $favourite = new ChFavorite();
        $favourite->user_id = $user->id;
        $favourite->favorite_id = 44;
        $favourite->save();
    }
});

//Authentication Routes
Auth::routes(['verify' => true]);

//Legal Documents Routes
Route::view('/user/agreement', 'legal.user_agreement');
Route::view('/account/deletion', 'legal.account_deletion');
Route::view('/community/convention', 'legal.community_convention');

//Dashboard Routes
Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'root')->name('root');
    Route::get('/balance', 'balance')->name('balance');
    Route::get('/index/{locale}', 'lang');
});

//User Routes
Route::controller(UserController::class)->group(function(){
    Route::prefix('user')->group(function () {
        Route::get('/list','index')->middleware('can:View User');
        Route::get('/add','create')->middleware('can:Add User');
        Route::post('/store','store')->middleware('can:Add User');
        Route::get('/edit/{id}','edit')->middleware('can:Edit User');
        Route::post('/update/{id}','update')->middleware('can:Edit User');
        Route::get('/delete/{id}','destroy')->middleware('can:Delete User');
        Route::get('/documents/{id}','documents')->middleware('can:View User Documents');
        Route::post('/deposit','deposit')->name('deposit');
        Route::get('/success','depositSuccess')->name('deposit.success');
        Route::get('/cancel','depositCancel')->name('deposit.cancel');
        Route::any('/ipn','depositIpn')->name('deposit.ipn')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    });
});

//User Account Verification Routes
Route::controller(UserAccountVerificationController::class)->group(function(){
    Route::prefix('user/verify')->group(function () {
        Route::get('/account/{id}','index')->middleware('can:Verify User Documents');
        Route::get('/account/download/{type}/{id}','download_document')->middleware('can:Verify User Documents');
        Route::post('/account/approve/{id}','approve')->middleware('can:Verify User Documents');
        Route::post('/account/suspend/{id}','suspend')->middleware('can:Verify User Documents');
    });
});

//Role Routes
Route::controller(RoleController::class)->group(function(){
    Route::prefix('role')->group(function () {
        Route::get('/list','index')->middleware('can:View Role');
        Route::get('/add','create')->middleware('can:Add Role');
        Route::post('/store','store')->middleware('can:Add Role');
        Route::get('/edit/{id}','edit')->middleware('can:Edit Role');
        Route::post('/update/{id}','update')->middleware('can:Edit Role');
        Route::get('/delete/{id}','destroy')->middleware('can:Delete Role');
    });
});

//|Admin Structure
Route::controller(UserController::class)->group(function(){
    Route::prefix('admin')->group(function () {
        Route::get('/structure','adminStructure')->middleware('can:View AdminStructure');
        Route::post('/change/balance','changeBalance')->name('change.balance')->middleware('can:Change Balance');
        Route::get('/add','create')->middleware('can:Add Role');
        Route::post('/store','store')->middleware('can:Add Role');
        Route::get('/edit/{id}','edit')->middleware('can:Edit Role');
        Route::post('/update/{id}','update')->middleware('can:Edit Role');
        Route::get('/delete/{id}','destroy')->middleware('can:Delete Role');
    });
});

//Profile Routes
Route::controller(ProfileController::class)->group(function(){
    Route::prefix('profile')->group(function () {
        Route::get('/','index');
        Route::get('/edit','edit');
        Route::post('/update','update_profile');
        Route::post('/update/password','update_password');
        Route::post('/update/avatar','update_avatar');
        Route::post('/update/documents','update_documents');
    });
});

//Marketplace Routes
Route::controller(MarketPlaceController::class)->group(function(){
    Route::prefix('market-place')->group(function () {
        Route::get('/assets','index');
        Route::get('/asset/{id}/checkout','checkout');
        Route::post('/{id}/confirm/checkout','confirm_checkout');
    });
});

//Manage Digital Assets
Route::controller(MarketPlaceController::class)->group(function(){
    Route::prefix('digital-assets')->group(function () {
        Route::get('/list','list');
        Route::get('/add','create');
        Route::get('edit/{id}','edit');
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','destroy');
    });
});

//Wallet Routes
Route::controller(WalletController::class)->group(function(){
    Route::prefix('wallet')->group(function () {
        Route::get('/view','index');
    });
});

//Marketing Templates
Route::controller(TemplateController::class)->group(function(){
    Route::prefix('marketing/templates')->group(function () {
        Route::get('list','index');
        Route::get('add','create');
        Route::get('edit/{id}','edit');
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','destroy');
        Route::get('preview/{id}','preview');
        Route::any('send','sendNotificationToAll')->name('send.notification.toall');
    });
});

//Bell Notification
Route::controller(BellNotificationController::class)->group(function(){
    Route::prefix('marketing/bell-notifications')->group(function () {
        Route::get('list','index');
        Route::get('add','create');
        Route::get('edit/{id}','edit');
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','destroy');
        Route::get('preview/{id}','preview');
        Route::any('sendToAll/{id}','sendToAll')->name('send.bellNotification.toall');
    });
});

//Marketing Templates
Route::controller(WelcomeNoteController::class)->group(function(){
    Route::prefix('system-setup/welcome-note')->group(function () {
        Route::get('list','index');
        Route::get('add','create');
        Route::get('edit/{id}','edit');
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','destroy');
        // Route::get('preview/{id}','preview');
        // Route::any('send','sendNotificationToAll')->name('send.notification.toall');
    });
});

//General Settings
Route::controller(GeneralSettingsController::class)->group(function(){
    Route::prefix('system-setup/general-settings')->group(function () {
        Route::get('list','index');
        Route::get('add','create');
        Route::get('edit/{id}','edit');
        Route::post('store','store');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','destroy');
    });
});


Route::controller(InvoiceController::class)->group(function(){
    Route::prefix('invoice')->group(function () {
        Route::get('list','index')->name('invoice.list');
        Route::get('add','create')->name('invoice.create');
        Route::get('show/{id}','show')->name('invoice.show');
        // Route::get('edit/{id}','edit')->name('invoice.edit');
        Route::post('store','store')->name('invoice.store');
        Route::post('update/{id}','update')->name('invoice.update');
        Route::delete('delete/{id}','destroy')->name('invoice.destroy');

        Route::get('checkout/button',   'payButton')->name('checkout.button.post');
        Route::get('checkout/pay',      'getButtonInvoice')->name('checkout.button');
    });
});

// Route::controller(CheckoutController::class)->group(function(){
//     Route::get('invoice-checkout', 'payButton')->name('checkout.button');
// });

// Route::get('crypto-checkout', [CheckoutController::class, 'showCheckoutPage'])->name('crypto.checkout');
// Route::post('crypto-checkout', [CheckoutController::class, 'handlePayment'])->name('crypto.checkout.process');


include_once 'admin.php';