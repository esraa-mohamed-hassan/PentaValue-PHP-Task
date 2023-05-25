<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['name', 'price', 'account_id'];
 
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
