<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOf extends Model
{
	//public $fillable = ['month','quantity','token','user_id','id'];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
