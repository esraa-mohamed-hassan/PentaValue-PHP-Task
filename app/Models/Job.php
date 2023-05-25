<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = ['name', 'amount', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
