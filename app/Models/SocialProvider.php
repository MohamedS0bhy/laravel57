<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_id',
    	];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
