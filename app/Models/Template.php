<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "t_title","t_method",
        "t_excerpt",
        "t_body"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
