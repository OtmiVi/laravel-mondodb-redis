<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;

    protected $collection = 'movies';

    protected $fillable = [
        'poster',
        'title',
        'fullplot'];
}
