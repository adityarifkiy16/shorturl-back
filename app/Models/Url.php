<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends Model
{
    use HasFactory;

    protected $table = 'url';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
