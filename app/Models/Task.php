<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'status',
        'active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

}
