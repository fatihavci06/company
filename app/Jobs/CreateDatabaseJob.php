<?php

namespace App\Jobs;

use DatabaseConnect;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class CreateDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $databaseName;
    public function __construct($databaseName)
    {
        //
        $this->databaseName = $databaseName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       // Varsayılan veritabanı bağlantısını kullanarak PDO nesnesi oluştur
       DB::statement("CREATE DATABASE IF NOT EXISTS {$this->databaseName}");

      \App\Classes\DatabaseConnect::changeConnect($this->databaseName);

       DB::purge('custom_mysql');
       DB::reconnect('custom_mysql');

       // Tabloları oluşturma
       Schema::connection('custom_mysql')->create('users', function (Blueprint $table) {
           $table->id();
           $table->string('name');
           $table->string('email')->unique();
           $table->timestamps();
       });

       Schema::connection('custom_mysql')->create('posts', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('user_id');
           $table->string('title');
           $table->text('body');
           $table->timestamps();

           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
       });
   
        //
    }
}
