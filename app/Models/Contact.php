<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function skill(){
        $this->hasMany(Skill::class, 'contact_id');
    }
    public function skills(){
        return $this->hasMany(Skill::class, 'contact_id');
    }
    public function degrees(){
        return $this->hasMany(Degree::class, 'contact_id')->orderBy('id','asc');
    }
    public function positions(){
        return $this->hasMany(Position::class, 'contact_id')->orderBy('id','asc');
    }
    public function languages(){
        return $this->hasMany(Language::class, 'contact_id');
    }
    public function contactData(){
        return $this->hasOne(Contact::class, 'id','id');
    }
    public function activities(){
        return $this->hasMany(Activity::class, 'contact_id')->latest();
    }
    public function notes(){
        return $this->hasMany(Note::class, 'contact_id')->latest();
    }
}
