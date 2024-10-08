<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'image',
        'size',
        'category_id',
        'extension'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(){
      return  $this->morphMany(Comment::class,'commentable');
    }


}
