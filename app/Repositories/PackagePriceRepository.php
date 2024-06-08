<?php

namespace App\Repositories;

use App\Models\Package;
use App\Models\PackagePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackagePriceRepository implements PackagePriceRepositoryInterface
{
    public function getAllData()
    {
        return PackagePrice::all();
    }

    public function find($id)
    {
        return PackagePrice::find($id);
    }

    public function create(Request $request,$package_id=null)
    {
        $packagePrice=new PackagePrice();
        $packagePrice->price=$request->price;
        $packagePrice->package_id=$package_id;
        return $packagePrice->save();
    }

    public function update($id, Request $request)
    {
        $package = PackagePrice::where('package_id',$id)->first();
        Log::info($request->price);
        $package->price=$request->price;
        return $package->save();
    }

    public function delete($id)
    {
        $invoice = PackagePrice::find($id);
        $invoice->delete();
    }
}