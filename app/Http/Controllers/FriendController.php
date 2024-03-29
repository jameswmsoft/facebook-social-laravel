<?php

namespace Facebook\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Facebook\Models\User;

// handles the friend request, add friend, accept friend, unfriend


class FriendController extends Controller {
    
    public function getIndex() {
        
        $friends = Auth::user()->friends(); 
        $requests = Auth::user()->friendRequests();
        
        
        return view('friends.index')
            ->with('friends', $friends)
            ->with('requests', $requests);
        
    }
    public function getAdd($username) {
        
        $user = User::where('username', $username)->first();
        
        if(!$user) {
            
            return redirect()
                ->route('home')
                ->with('info', 'That user could not be found');
                
        }
        
        if(Auth::user()->id === $user->id) {
            
            return redirect()
                ->route('home')
                ->with('info', 'You cannot be friends with yourself');
                
        }
        
        
        if(Auth::user()->hasFriendRequestPending($user) 
           || $user->hasFriendRequestPending(Auth::user())) {
            
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request already pending');
            
        }
        
        if(Auth::user()->isFriendsWith($user)) {
            
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'You are already friends');
            
        }
        
        Auth::user()->addFriend($user);
            
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request Sent');
        
    }  
    
    public function getAccept($username) {
        
        $user = User::where('username', $username)->first();
        
        if(!$user) {
            
            return redirect()
                ->route('home')
                ->with('info', 'That user could not be found');
                
        }
        
        if (!Auth::user()->hasFriendRequestRecieved($user)) {
            
            return redirect()
                ->route('home')
                ->with('info', 'No friend request found from this user'); 
            
        }
        
        Auth::user()->acceptFriendRequest($user);
            
            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', 'Friend request accepted');
    }

    public function getDeny($username){
        $user = User::where('username', $username)->first();

        if(!$user) {

            return redirect()
                ->route('home')
                ->with('info', 'That user could not be found');

        }

        Auth::user()->deleteFriend($user);

        return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', 'Friend request Denied');
    }
    
    public function postDelete($username) {
        
        $user = User::where('username', $username)->first();
        
        if(!Auth::user()->isFriendsWith($user)) {
            
            return redirect()
                ->route('home.index')
                ->with('info', "You aren't friends");
            
        }
        
        Auth::user()->deleteFriend($user);
        
        return redirect()
            ->back()
            ->with('info', 'Friend deleted');
        
    }
}