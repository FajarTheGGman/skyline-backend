<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacesModels extends Model
{
    use HasFactory;

    protected $table = 'places';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'long',
        'lat',
        'type',
        'rating',
        'vicinity',
        'photo',
    ];
}
