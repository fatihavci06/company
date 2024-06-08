<?php

namespace App\Providers;

use App\Repositories\PackagePriceRepository;
use App\Repositories\PackagePriceRepositoryInterface;
use App\Repositories\PackageRepository;
use App\Repositories\PackageRepositoryInterface;

use App\Services\PackageService;
use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->bind(PackagePriceRepositoryInterface::class, PackagePriceRepository::class);

        $this->app->bind(PackageService::class, function ($app) {
            return new PackageService(
                $app->make(PackageRepositoryInterface::class),
                $app->make(PackagePriceRepositoryInterface::class)
            );
        });
    }
}