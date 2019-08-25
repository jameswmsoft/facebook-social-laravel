<?php

namespace Facebook\Http\Controllers;

use Auth;
use Facebook\Models\Status;

// Shows the timeline if logged in else shows the landing screen

class HomeController extends Controller {
    
    public function index() {
        
        if (Auth::check()) {

            $statuses = Status::whereNull('parent_id')->where(function($query) {

                return $query->where('user_id', Auth::user()->id)
                    ->orWhereIn('user_id', Auth::user()->friends()->lists('id'));

            })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('timeline.index')
                ->with('statuses', $statuses);

        }

        return view('home');
        
    }
    
}