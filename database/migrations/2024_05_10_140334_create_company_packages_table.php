<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('package_id');
            $table->float('price')->nullable();
            $table->date('startdate')->nullable();
            $table->date('stopdate')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_packages');
    }
};
