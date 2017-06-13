<?php

namespace App;

use App\Files\Fileable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Fileable;
    protected $fillable = [
            'name', 'description', 'price', 'width', 'height',
    ];
    protected $with = ['images'];
    public static $filePath = '/uploads/products';
}
