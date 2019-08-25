<?php

// class to work with users table

namespace Facebook\Models;

use Facebook\Models\Status;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    protected $fillable = [
        
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'location',
        'avatar'
        
    ];

    protected $hidden = [

        'password',
        'remember_token',

    ];
    
    public function getName() {
        
        if ($this->first_name && $this->last_name) {
            
            return "{$this->first_name} {$this->last_name}";
            
        }
        
        if ($this->first_name) {
            
            return "{$this->first_name}";
            
        }
        
        return null;  
        
    }
    
    public function getNameorUsername() {
        
        return $this->getName() ?: $this->username;
        
    }
    
    public function getAvatarURL() {
        
        return "https://www.gravatar.com/avatar/{{ md5($this->email) }}?default=mm&s=40";
            
    }
    
    public function statuses() {
        
        return $this->hasMany('Facebook\Models\Status', 'user_id');
        
    }

    public function uploads() {

        return $this->hasMany('Facebook\Models\Upload', 'user_id');

    }

    public function groups() {

        return $this->belongsTo('Facebook\Models\Group', 'user_id');

    }
    
    public function likes() {
        
        return $this->hasMany('Facebook\Models\Like', 'user_id');
        
    }
        
    public function friendsOfMine() {
        
        return $this->belongsToMany('Facebook\Models\User', 'friends', 'user_id', 'friend_id');
    
    }
    
    public function friendsOf() {
        
        return $this->belongsToMany('Facebook\Models\User', 'friends', 'friend_id', 'user_id');
    
    }
    
    public function friends() {
            
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()->merge($this->friendsOf()->wherePivot('accepted', true)->get());
        
    }
    
    public function friendRequests() {
        
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    
    }
    
    public function friendRequestsPending() {
        
        return $this->friendsOf()->wherePivot('accepted', false)->get();
    
    }
    
    public function hasFriendRequestPending(User $user) {
        
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    
    }
    
    public function hasFriendRequestRecieved(User $user) {
        
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    
    }
    
    public function addFriend(User $user) {
        
        $this->friendsOf()->attach($user->id);
    
    }
    
    public function acceptFriendRequest(User $user) {
        
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true
            ]);
        
    }
    
    public function isFriendsWith(User $user) {
        
        return (bool) $this->friends()->where('id', $user->id)->count();
        
    }
    
    public function hasLikedStatus(Status $status) {
        
        return (bool) $status
            ->likes
            ->where('user_id', $this->id)
            ->count();
        
    }
    
    public function deleteFriend(User $user) {
                
        $this->friendsOf()->detach($user->id);
        $user->friendsOf()->detach($this->id);
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
