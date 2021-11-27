<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\Passport;

class RequestLog extends Model
{
    use HasFactory;
    protected $table = 'request_log';
    protected $fillable = [
        'username',
        'name',
        'ip_address',
        'status_code',
        'message',
        'user_agent',
        'token'
    ];
    public function token()
    {
        return $this->belongsTo(Passport::tokenModel());
    }
}
