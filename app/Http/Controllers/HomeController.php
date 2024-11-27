<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $taskTotal = Task::count();
        $taskCompleted = Task::where('completed', true)->count();
        $taskGroupBy= Task::all()->groupBy('due_date');
        // You can pass data to your view here
        $cards = [
            ['title' => 'Total Task', 'description' => $taskTotal],
            ['title' => 'Task Complete', 'description' => $taskCompleted],
        ];

        return view('home', compact('cards','taskGroupBy'));
    }

    public function blank()
    {
        return view('layouts.blank-page');
    }
}
