<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class station extends Model
{
    protected $fillable = [
    	'name','address','longitude','latitude','id','type','user_id',
    ];

    protected $hidden = [
    	'created_at','updated_at',
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
