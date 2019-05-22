<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Task;
use App\Status;

class DashController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showDash()
    {
        if (Admin::exists('cpf', auth()->user()->username)) {
            return view('adminDash');
        }

        $allTask = Task::all()->where('client_id', '=', auth()->user()->id);
        $openTask = 0;
        $waitingTask = 0;
        $attendanceTask = 0;
        $waitAttendanceTask = 0;
        $completedTask = 0;
        $sumTask = 0;


        foreach ($allTask as $item) {
            $status = $item['taskStatus_id'];
            switch ($status) {
                case 1:
                    $openTask++;
                    break;
                case 2:
                    $waitAttendanceTask++;
                    break;
                case 3:
                    $attendanceTask++;
                    break;
                case 4:
                    $waitingTask++;
                    break;
                case 5:
                    $completedTask++;
                    break;
            }

            $sumTask++;
        }

        $statusArray = array(
            'openTask' => $openTask,
            'waitAttendanceTask' => $waitAttendanceTask,
            'waitingTask' => $waitingTask,
            'attendanceTask' => $attendanceTask,
            'completedTask' => $completedTask,
            'sumTask' => $sumTask
        );

        return view('dashboard', ['status' => $statusArray]);
    }
}
