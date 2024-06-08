<?php

namespace App\Services;

use App\Models\Package;
use App\Repositories\BankRepositoryInterface;
use App\Repositories\PackagePriceRepositoryInterface;
use App\Repositories\PackageRepositoryInterface;
use Illuminate\Http\Request;

class PackageService
{
    protected $packageRepository;
    protected $packagePriceRepository;

    public function __construct(PackageRepositoryInterface $packageRepository,PackagePriceRepositoryInterface $packagePriceRepository) {
        $this->packageRepository = $packageRepository;
        $this->packagePriceRepository=$packagePriceRepository;
    }

    public function getAllData() {
        return $this->packageRepository->getAllData();
    }


    public function getDataById($id) {
        return $this->packageRepository->find($id);
    }


    public function createData(Request $request) {
        $package=$this->packageRepository->create($request);
        return $this->packagePriceRepository->create($request,$package->id);

    }

    public function updateData($id, Request $request) {
        $this->packageRepository->update($id, $request);
        $this->packagePriceRepository->update($id,$request);

    }

    public function deleteData(Package $package) {
        return $this->packageRepository->delete($package->id);
    }
}