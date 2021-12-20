<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "comment_id",
        "r_title",
        "r_body"
    ];


    public function comment(){
        return $this->belongsToMany(Comment::class);
    }

    public function post(){
        return $this->belongsToMany(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
