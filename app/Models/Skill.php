<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function contact(){
        return $this->hasOne(Contact::class, 'contact_id', 'id');
    }
    public function skillRelated(){
        return $this->hasMany(Skill::class,'contact_id','contact_id');
    }
}
