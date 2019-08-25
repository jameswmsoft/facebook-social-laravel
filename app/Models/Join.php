<?php

namespace Facebook\Models;

use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
    public function groups() {

        return $this->hasMany('Facebook\Models\Group', 'id');

    }
}
