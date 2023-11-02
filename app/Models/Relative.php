<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relative extends Model
{
    use HasFactory;

    use softDeletes;

    protected $guarded = ['id'];

    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'addressline' => 'required',
        'phonenum' => 'digits_between:3,8',
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
