<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Job;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ReporController extends Controller
{
    public function index()
    {

        $all_accounts = [];
        $all_projects = [];
        $all_jobs = [];
        $all_tasks = [];

        // Select all accounts
        $accounts = Account::all();
        foreach ($accounts as $acc) {
            array_push($all_accounts, [
                'id' => $acc->id,
                'name' => $acc->name,
            ]);
        }

        // Select all projects with their associated account
        $projects = Project::with('account')->get();
        foreach ($projects as $pro) {
            array_push($all_projects, [
                'id' => $pro->id,
                'name' => $pro->name,
                'price' => $pro->price,
                'account_name' => $pro->account['name'],
            ]);
        }

        // Select all jobs with their associated project , account and tasks
        $jobs = Job::with(['project.account', 'project.tasks'])->get();
        foreach ($jobs as $job) {
            $pro_tasks = [];
            foreach ($job->project['tasks'] as $pro_task) {
                array_push($pro_tasks, $pro_task->name);
            }
            array_push($all_jobs, [
                'id' => $job->id,
                'name' => $job->name,
                'amount' => $job->amount,
                'project_name' => $job->project['name'],
                'project_account_name' => $job->project['account']['name'],
                'project_task_name' => $pro_tasks,
            ]);
        }

        // Select all tasks with their associated project
        $tasks = Task::with(['project'])->get();
        foreach ($tasks as $task) {
            array_push($all_tasks, [
                'id' => $task->id,
                'name' => $task->name,
                'project_name' => $task->project['name'],
            ]);
        }

        return response()->json([
            'accounts' => $all_accounts,
            'projects' => $all_projects,
            'jobs' => $all_jobs,
            'tasks' => $all_tasks,
        ]);
    }

    public function taskRelatedPriceProduct()
    {

        $all_tasks = [];
        $tasks = Task::with('project')->whereHas('project', function ($query) {
            $query->where('price', '<', 100);
        })->get();
        foreach ($tasks as $task) {
            array_push($all_tasks, [
                'id' => $task->id,
                'name' => $task->name,
                'project_name' => $task->project['name'],
            ]);
        }
        return response()->json([
            'tasks' => $all_tasks,
        ]);
    }

    public function store(Request $request){
        // Insert records into accounts table
        $account = Account::create([
            'name' => $request->input('account_name'),
        ]);

        // Insert records into projects table
        $project = $account->projects()->create([
            'name' => $request->input('project_name'),
            'price' => $request->input('project_price')
        ]);

        // Insert records into jobs table
        $job1 = $project->jobs()->create([
            'name' => $request->input('job_name'),
            'amount' => $request->input('job_price')
        ]);

        // Insert records into tasks table
        $project->tasks()->create([
            'name' => $request->input('task_name'),
        ]);
        return response()->json("Created Successfully");
    }

    
}
