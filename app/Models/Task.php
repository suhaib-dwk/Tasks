<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'is_active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_task');
    }
}
