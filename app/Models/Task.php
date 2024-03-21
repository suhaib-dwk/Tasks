<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'title', 'description', 'start_date', 'end_date', 'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}