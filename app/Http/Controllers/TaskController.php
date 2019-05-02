<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskCategory;
use App\TaskLocal;

class TaskController extends Controller
{
    
    public function getOpenTask()
    {
        $categories = TaskCategory::all();
        $places = TaskLocal::all();
        return view('task.openTask', ['categories' => $categories, 'places'=> $places]);
    }

    public function postOpenTask(Request $request)
    {
        $validatedData = $request->validate([
            'notes' => 'required'
        ]);
    }


}
