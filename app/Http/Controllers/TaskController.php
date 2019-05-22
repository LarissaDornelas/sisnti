<?php

namespace App\Http\Controllers;

use \DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TaskCategory;
use App\TaskLocal;
use App\TaskStatus;
use App\TaskPriority;
use App\Task;
use App\Admin;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getOpenTask()
    {
        
        $categories = TaskCategory::orderBy('id')->get();
        $places = TaskLocal::orderBy('id')->get();
        return view('task.openTask', ['categories' => $categories, 'places' => $places]);
    }

    public function postOpenTask(Request $request)
    {
        $data = $request->all();

        $internal = ($this->isAdmin() == true) ? 1 : 0;

        $openingDate = new DateTime();
        $patrimony = null;

        if(array_key_exists('patrimony', $data))
            $patrimony = $data['patrimony'];

        $task = Task::create([
            'openingDate' => $openingDate,
            'description' => $data['description'],
            'note' => $data['notes'],
            'patrimony' => $patrimony,
            'internal' => $internal,
            'client_id' => auth()->user()->id,
            'taskCategory_id' => $data['category'],
            'taskLocal_id' => $data['locale'],
            'taskStatus_id' => 1,
            'taskPriority_id' => 0
        ]);

        return redirect()->route('userTasks');
    }

    public function allTask()
    {
        
        $data = DB::table('task')
                ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
                ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
                ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
                ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus')
                ->where('client_id' ,'=',auth()->user()->id)
                ->paginate(15);
          
            
             
        return view('task.userTasks', ['userTasks' => $data]);

        
    }
    public function taskDetail($id)
    {
         
            $taskData = DB::table('task')
                   ->join('user', 'task.client_id', '=', 'user.id')
                   ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
                   ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
                   ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
                   ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus', 'user.name as name')
                   ->where('task.id', '=', $id)->get();
       
            $taskData = $taskData[0];

            if(!($taskData->client_id == auth()->user()->id))
            {
                if(!$this->isAdmin())
                {
                    $error = 'Acesso Negado';

                    return view('task.taskDetail', ['error'=>$error]);
                }
            }       
        
   
        return view('task.taskDetail', ['taskData' => $taskData, 'error'=>null]);
    }

    public function isAdmin()
    {
        if (Admin::exists('cpf', auth()->user()->username)) return true;
        return false;
    }
}
