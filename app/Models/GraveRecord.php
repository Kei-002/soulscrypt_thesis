<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GraveRecord extends Model
{
    use HasFactory;
    use softDeletes;
    protected $table = 'grave_records';
    protected $guarded = ['id'];
    public static $rules = [
        'fname' => 'required',
        'lname' => 'required',
        'date_birth' => 'required',
        'date_death' => 'required',
        'img_path' => 'required'
    ];
}
