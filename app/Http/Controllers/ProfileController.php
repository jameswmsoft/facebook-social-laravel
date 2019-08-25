<?php


namespace Facebook\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Facebook\Models\User;

// class to update the profile


class ProfileController extends Controller {
    
    public function getProfile($username) {
        
        $user = User::where('username', $username)->first();
        
        if (!$user) {
            
            abort(404);
            
        }
        
        $statuses = $user->statuses()->whereNull('parent_id')->get();
               
        return view('profile.index')
            ->with('user', $user)
            ->with('statuses', $statuses)
            ->with('authUserIsFriend', Auth::user()->isFriendsWith($user)); 
        
    }
    
    public function getEdit() {
                       
        return view('profile.edit'); 
        
    }
    
    public function postEdit(Request $request) {
        
        $this->validate($request, [
            'first_name' => 'required|alpha|max:50',
            'last_name' => 'required|alpha|max:50',
            'location' => 'required|alpha|max:50'
        ]);
               
        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location')
            
        ]);

        if ($request->hasFile('avatar')) {

            $uploadedFile = $request->file('avatar');
            $filename = time() . $uploadedFile->getClientOriginalName();

            $uploadedFile->move(public_path('uploads/'), $filename);

            Auth::user()->update([
                'avatar' => $filename
            ]);
        }
        
        return redirect()
            -> route('profile.edit')
            -> with('info', 'Your profile has been updated');
    }
    
    
}