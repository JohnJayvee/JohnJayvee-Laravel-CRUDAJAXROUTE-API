<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usersModel extends Model
{
    protected $table = 'tbl_users';
    protected $fillable = [
        'firstName', 'lastName'
    ];
}
