<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class web extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'text',
        'name',
        'file_path'
    ];
}
