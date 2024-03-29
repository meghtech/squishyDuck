<?php

namespace App\Http\Controllers\Seller;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Listings;

class MarketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller',['except' => [
            'index','viewDetail'
        ]]);
    }

    public function index(){
        $sortBy="asc";
        $seachCity="";
        $seachItem="";
        $data = Listings::where('type', 'market')
        ->orderBy('price', $sortBy)
        ->with('user')
        ->paginate(6)
        ->appends(request()->query());

        // dd($data);
        return view('seller.market.market', compact('data', 'sortBy', 'seachCity', 'seachItem'));
    }

    public function viewDetail($id){
        $data = Listings::where('id', $id) ->with('user')->first();
        return view('seller.market.detail', compact('data'));
    }

    public function createSchedule($id){
       return view('seller.market.createSchedule', compact('id'));
    }

    public function inventory(){
       return view('seller.inventory.inventory');
    }

    public function createInventory(){
       return view('seller.inventory.create');
    }

    public function postInventory(Request $request){
        log::info($request);

        $imageList = [];
        for ($i=0; $i < $request->photoLength; $i++) {
            $fileNo = "image-".$i;
            $image = $request->$fileNo;
            $filenamewithextension = $request->$fileNo->getClientOriginalName();
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            //get file extension
            $extension = $request->$fileNo->getClientOriginalExtension();
            //filename to store
            $filenametostore = $filename . '_' . time() . '.webp' ;
            if (!File::exists(public_path() . "/content/images/inventory")) {
                File::makeDirectory(public_path() . "/content/images/inventory", 0777, true);
            }
            $originalPath = public_path() . '/content/images/inventory';
            $thumbnailImage = Image::make($image)->encode('webp', 100);
            $thumbnailImage->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($originalPath.'/'. $filenametostore);
            $imageList[] = $filenametostore;
        }

        $list = new Listings();
        $list->user_id = auth()->user()->id;
        $list->title = $request->title;
        $list->price = $request->price;
        $list->description = $request->description;
        $list->tags = $request->tags;
        $list->manufacturer = $request->manufacturer;
        $list->model_name = $request->model;
        $list->dimension = $request->dimension;
        $list->condition = $request->condition;
        $list->contact_email = $request->contactEmail;
        $list->contact_name = $request->contactName;
        $list->contact_phone = $request->phoneNumber;
        $list->viaCall = (boolean)$request->callMe;
        $list->viaText = (boolean)$request->textMe;
        $list->street = $request->streetAddress;
        $list->city = $request->city;
        $list->state = $request->state;
        $list->zip_code = $request->zip;
        $list->delivery_detail = $request->deliveryDetails;
        $list->type = $request->type;
        $list->photos = json_encode($imageList);
        $list->save();

        return "Success!";
    }

    public function searchProduct(Request $request){
        log::info($request->sortBy);
        $sortBy = $request->sortBy;
        $seachCity = $request->seachCity;
        $seachItem =  $request->seachItem;

        if($seachCity && !$seachItem){
            $data = Listings::where('type', 'market')
            ->where(function($query) use ($seachCity){
                $query->where('city', 'LIKE', "%{$seachCity}%")
                ->orWhere('zip_code', 'LIKE', "%{$seachCity}%");
            })
            ->orderBy('price', $sortBy)
            ->paginate(6)
            ->appends(request()->query());
        } elseif(!$seachCity && $seachItem){
            $data = Listings::where('type', 'market')
            ->where('title', 'LIKE', "%{$seachItem}%")
            ->orderBy('price', $sortBy)
            ->paginate(6)
            ->appends(request()->query());
        } elseif($seachCity && $seachItem) {
            $data = Listings::where('type', 'market')
            ->where('title', 'LIKE', "%{$seachItem}%")
            ->where(function($query) use ($seachCity) {
                $query->where('city', 'LIKE', "%{$seachCity}%")
                ->orWhere('zip_code', 'LIKE', "%{$seachCity}%");
            })
            ->orderBy('price', $sortBy)
            ->paginate(6)
            ->appends(request()->query());
        } else {
            $data = Listings::where('type', 'market')
            ->orderBy('price', $sortBy)
            ->paginate(6)
            ->appends(request()->query());
        }
        return view('seller.market.market', compact('data', 'sortBy', 'seachCity', 'seachItem'));
    }
}
