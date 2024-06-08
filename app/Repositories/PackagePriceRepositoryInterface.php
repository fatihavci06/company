<?php
namespace App\Repositories;

use App\Models\Package;
use Illuminate\Http\Request;

interface PackagePriceRepositoryInterface {
    public function getAllData();
    public function find($id);
    public function create(Request $request,$package_id=null);
    public function update($id, Request $request);    public function delete($id);
}