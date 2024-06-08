<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Http\Request;


class PackageRepository implements PackageRepositoryInterface
{
    public function getAllData()
    {
        return Package::all();
    }

    public function find($id)
    {
        return $packages = Package::with(['prices' => function ($query) {
            $query->select('id', 'package_id', 'price');
        }])->find($id);

    }

    public function create(Request $request)
    {

        return  Package::create($request->except('_token'));
    }

    public function update($id, Request $request)
    {
        $package=Package::find($id);
        $package->name=$request->name;
        $package->day=$request->day;
        return $package->save();
    }

    public function delete($id)
    {
        $invoice = Package::find($id);
        $invoice->delete();
    }
}
