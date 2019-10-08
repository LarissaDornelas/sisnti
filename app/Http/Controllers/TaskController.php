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
use \Carbon\Carbon;
use Exception;

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
            'duplicated' => 0,
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
            ->select(
                'task.*',
                'taskLocal.description as taskLocal',
                'taskCategory.description as taskCategory',
                'taskStatus.description as taskStatus'
            )
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
            ->join('user as client', 'task.client_id', '=', 'client.id')
            ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
            ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
            ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')

            ->select(
                'task.*',
                'taskLocal.description as taskLocal',
                'taskCategory.description as taskCategory',
                'taskStatus.description as taskStatus',
                'client.name as name'
            )->where('task.id', '=', $id)->get();

        $historic = DB::table('historic')->select('historic.*')->where('task_id', '=', $id)->get();
        $manager = DB::table('task')->join('user as manager', 'task.manager_id', '=', 'manager.id')->select('manager.name as managerName')->where('task.id', '=', $id)->get();

        if (sizeof($manager) <= 0) {
            $manager = null;
        } else {
            $manager = $manager[0];
        }
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

        $reopenInTime = false;

        if (
            $taskData->finishDate != null && ($taskData->taskStatus_id == 5
                || $taskData->taskStatus_id == 6
                || $taskData->taskStatus_id == 7)
        ) {
            $dateNow = Carbon::now();
            $dateTask = Carbon::parse($taskData->finishDate);

            $reopenInTime =  $dateNow->diffInDays($dateTask) < 3;
        }

        if (session()->get('admin')[0]) {
            return view('admin.userTaskDetail', ['taskData' => $taskData, 'error' => null, 'historic' => $historic, 'reopenInTime' => $reopenInTime, 'manager' => $manager]);
        }
        return view('task.taskDetail', ['taskData' => $taskData, 'error' => null, 'historic' => $historic, 'reopenInTime' => $reopenInTime, 'manager' => $manager]);
    }

    public function adminTaskDetail($id)
    {


        $taskData = $this->taskDetailSearch($id);
        $historic = DB::table('historic')->select('historic.*')->where('task_id', '=', $id)->get();
        $manager = DB::table('task')->join('user as manager', 'task.manager_id', '=', 'manager.id')->select('manager.name as managerName')->where('task.id', '=', $id)->get();

        if (sizeof($manager) <= 0) {
            $manager = null;
        } else {
            $manager = $manager[0];
        }

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

        $priority = TaskPriority::all();
        if ($taskData->taskStatus_id == 1) {
            $atual = new DateTime('+1 day');
            $atual = $atual->format('Y-m-d H:m:s');
            $before = new DateTime('-3 month');
            $before = $before->format('Y-m-d H:m:s');

            try {
                $duplicatedOpt =  DB::table('task')
                    ->join('user as client', 'task.client_id', '=', 'client.id')
                    ->select('task.*', 'client.name as name')
                    ->whereBetween('openingDate', [$before,  $atual])
                    ->where([['task.id', '!=', $id], ['task.duplicated', '=', null]])
                    ->get();

                return view('admin.adminTaskDetail', ['taskData' => $taskData, 'error' => null, 'priority' => $priority, 'historic' => $historic, 'duplicatedOpt' => $duplicatedOpt, 'reopenInTime' => false, 'manager' => $manager]);
            } catch (Exception $e) {
                dd($e);
            }
        }
        return view('admin.adminTaskDetail', ['taskData' => $taskData, 'error' => null, 'priority' => $priority, 'historic' => $historic, 'duplicatedOpt' => ['nothing'], 'reopenInTime' => false, 'manager' => $manager]);
    }


    public function taskDetailSearch($id)
    {
        return
            DB::table('task')
            ->join('user as client', 'task.client_id', '=', 'client.id')
            ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
            ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
            ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')


            ->select(
                'task.*',
                'taskLocal.description as taskLocal',
                'taskCategory.description as taskCategory',
                'taskStatus.description as taskStatus',
                'client.name as name'

            )
            ->where('task.id', '=', $id)->get();
    }

    public function adminGeneralTask($typeRequest)
    {

        if ($typeRequest == 'todos') {
            $title = 'Todos os chamados';
            $taskData = DB::table('task')
                ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
                ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
                ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
                ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus')
                ->paginate(15);
        } else {
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
        }

        return view('admin.adminTasks', ['userTasks' => $taskData, 'title' => $title]);
    }
    public function adminMyCallsTask($typeRequest)
    {
        if ($typeRequest == 'concluido') {
            $title = 'Concluídos';
            $taskData = DB::table('task')
                ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
                ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
                ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
                ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus')
                ->where('task.manager_id', '=', auth()->user()->id)
                ->whereIn('task.taskStatus_id', [5, 6, 7])
                ->paginate(15);
        } else {
            $type = $this->typeOfFilter($typeRequest);
            $title = str_replace('-', ' ', $typeRequest);
            $title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8");

            $taskData = DB::table('task')
                ->join('taskLocal', 'task.taskLocal_id', '=', 'taskLocal.id')
                ->join('taskCategory', 'task.taskCategory_id', '=', 'taskCategory.id')
                ->join('taskStatus', 'task.taskStatus_id', '=', 'taskStatus.id')
                ->select('task.*', 'taskLocal.description as taskLocal', 'taskCategory.description as taskCategory', 'taskStatus.description as taskStatus')
                ->where([['task.taskStatus_id', '=', $type], ['task.manager_id', '=', auth()->user()->id]])
                ->paginate(15);
        }

        return view('admin.adminTasks', ['userTasks' => $taskData, 'title' => $title]);
    }

    public function adminEvaluateTask(Request $request, $id)
    {

        $evaluate = $request->except(['_token', 'originalTask']);

        $historicDate = new DateTime();



        $evaluate['taskStatus_id'] = 2;
        $evaluate['manager_id'] = auth()->user()->id;

        if (array_key_exists('duplicated', $evaluate)) {
            if ($evaluate['duplicated'] == null) {
                $evaluate['duplicated'] = false;
            } else {
                $evaluate['duplicated'] = true;
            }
        } else {
            $date = $evaluate['forecastService'];
            $newDate = substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

            $evaluate['forecastService'] = $newDate;
        }
        try {

            Historic::create([
                'task_id' =>  $id,
                'date' => $historicDate,
                'description' => 'Chamado avaliado! Status: Aguardando Atendimento'
            ]);

            if (array_key_exists('duplicated', $evaluate)) {

                $original = $request['originalTask'];

                $dataOriginalTask = Task::where('id', $original)->get();

                $dataOriginalTask[0]['originalFor'] =  (string) ($dataOriginalTask[0]['originalFor'] . $id . ',');
                Task::where('id', $original)->update(array('originalFor' => $dataOriginalTask[0]['originalFor']));

                $evaluate['taskStatus_id'] = $dataOriginalTask[0]->taskStatus_id;
                $evaluate['finishDate'] = $dataOriginalTask[0]->finishDate;
                $evaluate['patrimony'] = $dataOriginalTask[0]->patrimony;
                $evaluate['solution'] = $dataOriginalTask[0]->solution;
                $evaluate['taskPriority_id'] = $dataOriginalTask[0]->taskPriority_id;
                $evaluate['taskCategory_id'] = $dataOriginalTask[0]->taskCategory_id;
                $evaluate['forecastService'] = $dataOriginalTask[0]->forecastService;
                $evaluate['duplicateOf'] = $dataOriginalTask[0]->id;



                Historic::create([
                    'task_id' =>  $id,
                    'date' => $historicDate,
                    'description' => 'Chamado Duplicado!'
                ]);
            }

            Task::where('id', $id)->update($evaluate);
        } catch (Exception $e) {
            dd($e);
        }

        return redirect()->route('adminTaskDetail', ['id' => $id]);
    }

    public function adminUpdateTask(Request $request, $id)
    {

        $data = $request->except(['_token']);



        if ($data['radio'] == 'concluido') {
            $status = $this->typeOfFilter($data['taskSuccess']);
            $saveData['finishDate'] = new DateTime();
        } else {
            $status = $this->typeOfFilter($data['radio']);
        }

        $saveData['solution'] = $data['solution'];
        $saveData['taskStatus_id'] = $status;

        $historicDate = new DateTime();

        $newStatus = str_replace('-', ' ', $data['radio']);
        $newStatus = ucfirst(strtolower($newStatus));


        try {
            $task = Task::where('id', $id)->get();

            Task::where('id', $id)->update($saveData);

            Historic::create([
                'task_id' =>  $id,
                'date' => $historicDate,
                'description' => 'Chamado atualizado! Status: ' . $newStatus
            ]);

            if ($task[0]->originalFor != null) {
                $originalFor = $task[0]->originalFor;
                $originalForArray = explode(",", $originalFor);

                for ($i = 0; $i < count($originalForArray); $i++) {
                    $idDuplicate = (int) $originalForArray[$i];

                    Task::where('id', $idDuplicate)->update($saveData);
                    /*
                    Historic::create([
                        'task_id' => $idDuplicate,
                        'date' => $historicDate,
                        'description' => 'Chamado atualizado! Status: ' . $newStatus
                    ]);*/
                }
            }
        } catch (Exception $e) {
            dd($e);
        }
        return redirect()->route('adminTaskDetail', ['id' => $id]);
    }
    public function typeOfFilter($typeRequest)
    {

        switch ($typeRequest) {
            case 'em-espera':
                $type = 4;
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
            case 'concluido-com-sucesso':
                $type = 5;
                break;
            case 'concluido':
                $type = 5;
                break;
            case 'concluido-com-restricao':
                $type = 6;
                break;
            case 'concluido-com-duplicata':
                $type = 7;
                break;
        }
        return $type;
    }

    public function reopenTask(Request $request, $id)
    {
        $data = $request->except('_token');

        $saveData['taskStatus_id'] = 1;
        $historicDate = new DateTime();

        try {
            $task = Task::where('id', $id)->get();
            $saveData['description'] = $task[0]->description . "\n" . " Chamado reaberto! Motivo: " . $data['reopen'];
            Task::where('id', $id)->update($saveData);
            Historic::create([
                'task_id' =>  $id,
                'date' => $historicDate,
                'description' => 'Chamado Reaberto! Status: Em Aberto'
            ]);
        } catch (Exception $e) {
            dd($e);
        }

        return redirect()->route('taskDetail', ['id' => $id]);
    }
}
