<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function contact(){
        return $this->belongsTo(Contact::class, 'contact_id');
    }
    public function assigned_user(){
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
