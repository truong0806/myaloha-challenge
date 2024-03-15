<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'status_id', 'created_by'];


    // public function status()
    // {
    //     return $this->belongsTo(Status::class);
    // }
    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }
}
