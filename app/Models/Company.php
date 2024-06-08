<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $fillable = ['company_name','tax_number','company_email','phone','address','person_name'];
    public function authorizedPerson()
    {
        return $this->hasOne(User::class, 'id','authorized_person_id');
    }
    
}
