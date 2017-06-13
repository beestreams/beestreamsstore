<?php

namespace App\Files;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['mimetype', 'file_name', 'file_path', 'alt_text'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function scopeOnlyImages($query)
    {
        return $query->where('mimetype', 'like', 'image%');
    }
}
