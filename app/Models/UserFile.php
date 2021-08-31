<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getSizeAttribute($value){
        return formatSizeUnits($value);
    }
}
