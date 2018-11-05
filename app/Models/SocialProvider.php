<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class SocialProvider extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_id',
	];
}
