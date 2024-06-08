<?php
namespace App\Repositories;

use App\Models\Package;
use Illuminate\Http\Request;

interface PackageRepositoryInterface {
    public function getAllData();
    public function find($id);
    public function create(Request $request);
    public function update(Package $package, Request $request);
    public function delete($id);
}