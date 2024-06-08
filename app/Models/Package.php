<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{    use SoftDeletes;

    use HasFactory;
    protected $fillable = ['name','day'];
    protected $dates = ['deleted_at'];
    public function prices()
    {
        return $this->hasOne(PackagePrice::class)->latest();

    }

}
