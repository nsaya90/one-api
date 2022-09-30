<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function id_image()
    {
        return $this->belongsTo(Post::class, 'id_user', 'id');
    }
}
