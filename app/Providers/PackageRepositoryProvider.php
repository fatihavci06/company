<?php
namespace App\Providers;

use App\Repositories\PackageRepository;
use App\Repositories\PackageRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PackageRepositoryProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
    }
}