<?php

namespace Facebook\Http\Controllers;


use Illuminate\Http\Request;
use Facebook\Models\User;
use DB;

// class to search for other people

class SearchController extends Controller {
    
    public function getResults(Request $request) {
        
        $query = $request->input('query');
        
        if(!$query) {
            
            return redirect()->route('home');
            
        }
        
        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$query}%")
            ->orWhere('username', 'LIKE', "%{$query}%")
            ->get();

        
        return view('search.results')->with('users', $users);
        
    }
    
}