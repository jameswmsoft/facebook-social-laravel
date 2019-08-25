<?php

namespace Facebook\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function user() {

        return $this->hasMany('Facebook\Models\User', 'group_id');

    }

    public function join() {

        return $this->belongsTo('Facebook\Models\Join', 'group_id');

    }
}
