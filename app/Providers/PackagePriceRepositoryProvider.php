<?php
namespace App\Providers;

use App\Repositories\PackagePriceRepository;
use App\Repositories\PackagePriceRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class PackagePriceRepositoryProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(PackagePriceRepositoryInterface::class, PackagePriceRepository::class);
    }
}