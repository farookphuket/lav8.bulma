<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "c_title",
        "c_body"
    ];

    public function post(){
        return $this->belongsToMany(Post::class)->with("user");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
