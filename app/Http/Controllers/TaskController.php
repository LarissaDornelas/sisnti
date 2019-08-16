<?php

namespace App\Http\Controllers;

use \DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TaskCategory;
use App\Historic;
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
        if (session()->get('admin')[0]) {
            return view('admin.adminOpenTask', ['categories' => $categories, 'places' => $places]);
        }
        return view('task.openTask', ['categories' => $categories, 'places' => $places]);
    }

    public function postOpenTask(Request $request)
    {
        $data = $request->all();

        $internal = (session()->get('admin')[0]) ? 1 : 0;

        $openingDate = new DateTime();
        $patrimony = null;

        if (array_key_exists('patrimony', $data))
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

        Historic::create([
            'task_id' => $task->id,
            'date' => $openingDate,
            'description' => 'Chamado aberto com sucesso!'
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
            ->where('client_id', '=', auth()->user()->id)
            ->paginate(15);

        if (session()->get('admin')[0]) {
            return view('admin.adminUserTasks', ['userTasks' => $data]);
        }

        return view('user.userTasks', ['userTasks' => $data]);
    }
    public function taskWithFilter($typeRequest)
    {
        $type = $this->typeOfFilter($typeRequest);

        $data = DB::table('task')
            ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
            ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
            ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
            ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus')
            ->where([
                ['client_id', '=', auth()->user()->id],
                ['taskStatus.id', '=', $type]
            ])
            ->paginate(15);

        if (session()->get('admin')[0]) {
            return view('admin.adminUserTasks', ['userTasks' => $data]);
        }
        return view('user.userTasks', ['userTasks' => $data]);
    }

    public function taskDetail($id)
    {

        $taskData = DB::table('task')
            ->join('user', 'task.client_id', '=', 'user.id')
            ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
            ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
            ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
            ->join('historic', 'historic.task_id', '=', 'task.id')
            ->select(
                'task.*',
                'taskLocal.description as taskLocal',
                'taskCategory.description as taskCategory',
                'taskStatus.description as taskStatus',
                'user.name as name',
                'historic.date as historicDate',
                'historic.description as historicDescription'
            )
            ->where('task.id', '=', $id)->get();

        if (sizeof($taskData) <= 0) {
            abort(404);
        }

        $taskData = $taskData[0];

        if (!($taskData->client_id == auth()->user()->id)) {
            if (!session()->get('admin')[0]) {
                abort(401);

                return view('task.taskDetail', ['error' => $error]);
            }
        }

        if (session()->get('admin')[0]) {
            return view('admin.userTaskDetail', ['taskData' => $taskData, 'error' => null]);
        }
        return view('task.taskDetail', ['taskData' => $taskData, 'error' => null]);
    }

    public function adminTaskDetail($id)
    {

        $taskData = $this->taskDetailSearch($id);

        if (sizeof($taskData) <= 0) {
            abort(404);
        }

        $taskData = $taskData[0];

        if (!($taskData->client_id == auth()->user()->id)) {
            if (!session()->get('admin')[0]) {
                abort(401);

                return view('task.taskDetail', ['error' => $error]);
            }
        }

        return view('admin.adminTaskDetail', ['taskData' => $taskData, 'error' => null]);
    }


    public function taskDetailSearch($id){
       return
       DB::table('task')
        ->join('user', 'task.client_id', '=', 'user.id')
        ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
        ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
        ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
        ->join('historic', 'historic.task_id', '=', 'task.id')
        ->select(
            'task.*',
            'taskLocal.description as taskLocal',
            'taskCategory.description as taskCategory',
            'taskStatus.description as taskStatus',
            'user.name as name',
            'historic.date as historicDate',
            'historic.description as historicDescription'
        )
        ->where('task.id', '=', $id)->get();
    }

    public function adminGeneralTask($typeRequest)
    {
        $type = $this->typeOfFilter($typeRequest);

        $title = str_replace('-', ' ', $typeRequest);
        $title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");

        $taskData = DB::table('task')
            ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
            ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
            ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
            ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus')
            ->where('taskStatus.id', '=', $type)
            ->paginate(15);

        return view('admin.adminGeneralTasks', ['userTasks' => $taskData, 'title' => $title]);
    }
    public function adminMyCallsTask($type)
    {
        echo "teste";
    }

    public function typeOfFilter($typeRequest)
    {

        switch ($typeRequest) {
            case 'em-espera':
                $type = 4;
                break;
            case 'concluido':
                $type = 5;
                break;
            case 'aguardando-atendimento':
                $type = 2;
                break;
            case 'em-atendimento':
                $type = 3;
                break;
            case 'em-aberto':
                $type = 1;
                break;
        }
        return $type;
    }
}
