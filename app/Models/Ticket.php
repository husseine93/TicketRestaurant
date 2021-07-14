<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public $fillable = ['month','quantity','token','user_id','id','validate'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
