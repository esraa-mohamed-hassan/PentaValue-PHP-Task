<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['name'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
   
}
