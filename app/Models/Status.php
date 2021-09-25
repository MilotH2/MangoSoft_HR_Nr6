<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function task(){
        return $this->belongsTo(Task::class, 'task_id')->with('contact');
    }
}
