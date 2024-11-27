<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LoginHistory extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'login_at'];
    protected $table="login_history";
    //public $timestamps=false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
