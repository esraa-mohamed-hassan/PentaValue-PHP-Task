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

    public function getAllRecordes()
    {
         // Select all accounts
         $accounts = Account::all();

         // Select all projects with their associated account
         $projects = Project::with('account')->get();
 
         // Select all jobs with their associated project , account and tasks
         $jobs = Job::with(['project.account', 'project.tasks'])->get();
 
        $tasks = Task::whereHas('project', function ($query) {
             $query->where('price', '<', 100);
         })->get();
 
         dd($accounts, $projects, $jobs, $tasks);
    }
}
