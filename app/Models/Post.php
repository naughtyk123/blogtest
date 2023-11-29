<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'post',
        'user_id',
        'categorie_id',
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function images()
    {
        return $this->hasOne(PostImage::class, 'post_id', 'id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'categorie_id');
    }
}
