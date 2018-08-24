<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Station;

class User extends Model
{
    protected $fillable=[
        'name','email','role','user_id',
    ];

    public function station(){
    	return $this->hasMany(Station::class);
    }
}
