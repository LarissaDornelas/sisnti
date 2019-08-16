<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $table="historic";

    public $timestamps = false; 

    protected $fillable = [
        'id', 'task_id', 'description', 'date'
     ];
}
