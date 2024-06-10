<?php

namespace App\Http\Controllers\DigitalAssets\MarketPlace;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\{DigitalAsset, UserWallet};

class MarketPlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'under-review']);
    }

    public function index()
    {
        $assets = DigitalAsset::all();
        return view('dashboard.digital-assets.marketplace.list', compact('assets'));
    }

    public function list()
    {
        $assets = DigitalAsset::all();

        return view('dashboard.digital-assets.manage.list', compact('assets'));
    }

    public function create()
    {
        return view('dashboard.digital-assets.manage.add');
    }

    public function store(Request $request)
    {
        //Performing Validations
        $validator = Validator::make($request->all(), [
            "name" => ['required', 'string'],
            "price" => ['required', 'integer'],
            "quantity" => ['required', 'integer'],
            "exchangeable" => ['required', 'string'],
            "giftable" => ['required', 'boolean'],
            "image" => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('warning', 'Please enter all the input carefully');
        }

        $file = $request->file('image');
        $fileName = time().'-'.$file->getClientOriginalName();
        //Setting File Path        
        $filePath = 'assets/digital_assets/'.$fileName;
        //Uploading File
        $file->move(public_path('assets/digital_assets/'), $fileName);

        $digitalAsset = new DigitalAsset();
        $digitalAsset->name = $request->name;
        $digitalAsset->price = $request->price;
        $digitalAsset->image = $filePath;
        $digitalAsset->quantity = $request->quantity;
        $digitalAsset->exchangeable = $request->exchangeable;
        $digitalAsset->giftable = $request->giftable;
        $digitalAsset->save();

        return redirect('digital-assets/list')->with('success', 'Digital Added Successfully!');
    }

    public function checkout($id)
    {
        $asset = DigitalAsset::find(decrypt($id));
        return view('dashboard.digital-assets.marketplace.checkout', compact('asset'));
    }

    public function confirm_checkout(Request $request, $id)
    {
        $asset = DigitalAsset::find(decrypt($id));
        $user_wallet = \Auth::user()->wallet;

        //Switch Case to Determine Purchased Asset
        switch ($asset->name) {
            case 'Diamonds':
                //Incrementing the number of Diamonds & Rubies
                $user_wallet->increment('diamonds', $asset->quantity);
                $user_wallet->increment('rubies', $asset->free_rubies);
                break;

            case 'Coins':
                //Incrementing the number of Coins & Rubies
                $user_wallet->increment('coins', $asset->quantity);
                $user_wallet->increment('rubies', $asset->free_rubies);
                break;

            case 'Rocks':
                //Incrementing the number of Rocks & Rubies
                $user_wallet->increment('rocks', $asset->quantity);
                $user_wallet->increment('rubies', $asset->free_rubies);
                break;

            case 'Teddy Bears':
                //Incrementing the number of Teddy Bears & Rubies
                $user_wallet->increment('teddy_bears', $asset->quantity);
                $user_wallet->increment('rubies', $asset->free_rubies);
                break;
        }

        return redirect('/wallet/view')->with('success', 'Wallet Updated Successfully!');
    }
}