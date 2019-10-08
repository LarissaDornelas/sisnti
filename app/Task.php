<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "task";

    public $timestamps = false;

    protected $fillable = [
        'id', 'openingDate', 'forecastService', 'finishDate', 'description', 'note', 'patrimony',
        'solution', 'internal', 'taskPriority_id', 'taskStatus_id', 'taskCategory_id', 'taskLocal_id', 'client_id',
        'manager_id', 'originalFor', 'duplicateOf'
    ];
}
