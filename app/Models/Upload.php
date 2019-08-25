<?php

namespace Facebook\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [

        'filename',

    ];

    public function user() {

        return $this->belongsTo('Facebook\Models\User', 'user_id');

    }

    public function status() {

        return $this->belongsTo('Facebook\Models\Status', 'id','status_id');

    }
}
