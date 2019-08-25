<?php

// class for status

namespace Facebook\Models;

use Illuminate\Database\Eloquent\Model;


class Status extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'statuses';
        
    protected $fillable = [
        'body','file'
    ];
    
    
    public function user() {
        
        return $this->belongsTo('Facebook\Models\User', 'user_id');
        
    }

    public function upload(){
        return $this->hasOne('Facebook\Models\Upload', 'status_id','id');
    }
    
    public function scopeNotReply($query) {
        
        return $query->whereNull('parent_id');
        
    }
    
    public function replies() {
        
        return $this->hasMany('Facebook\Models\Status', 'parent_id');
        
    }
    
    public function likes() {
        
        return $this->morphMany('Facebook\Models\Like', 'likeable');
        
    }
}

