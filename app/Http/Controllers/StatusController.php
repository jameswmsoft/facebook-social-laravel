<?php

namespace Facebook\Http\Controllers;


use Facebook\Models\Upload;
use Illuminate\Http\Request;
use Facebook\Models\User;
use Illuminate\Support\Facades\Storage;
use Facebook\Models\Status;
use Auth;

// class to post status, like, reply to a status

class StatusController extends Controller {
    
    public function postStatus(Request $request) {
        
        $this->validate($request, [
            'status' => 'required|max:1000',
        ]);

        $status = Auth::user()->statuses()->create([
            'body' => $request->input('status')
        ]);

        if ($request->hasFile('input_file')) {
            $uploadedFile = $request->file('input_file');
            $filename = time() . $uploadedFile->getClientOriginalName();

            $uploadedFile->move(public_path('uploads/'), $filename);

            $ext = substr($filename, strlen($filename)-3);

            $upload = new Upload;
            $upload->filename = $filename;

            $upload->user()->associate(auth()->user());
            $upload->status_id = $status->id;
            $upload->ext = $ext;

            $upload->save();
        }else {
            $upload = new Upload;
            $upload->filename = 'none';

            $upload->user()->associate(auth()->user());
            $upload->status_id = $status->id;
            $upload->ext = 'none';

            $upload->save();
        }
        return redirect()
                ->route('home')
                ->with('info', 'Status posted');

    }
        
    public function postReply(Request $request, $statusId) {
        
        $this->validate($request, [
            "reply-{$statusId}" => 'required|max:1000'
        ], [
            'required' => 'Your reply is empty'
        ]);
        
        
        $status = Status::whereNull('parent_id')->find($statusId);
        
        if(!$status) {
            
            return redirect()->route('home')->with('info', 'There is no status to reply to');;
        }
        
        if (!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id) {
            
            return redirect()->route('home')->with('info', 'You are not friends with this person');;
        }
        
        $reply = Status::create([
            'body' => $request->input("reply-{$statusId}")
        ])
            ->user()->associate(Auth::user());
        
        $status->replies()->save($reply);

        if ($request->hasFile('input_file')) {
            $uploadedFile = $request->file('input_file');
            $filename = time() . $uploadedFile->getClientOriginalName();

            $uploadedFile->move(public_path('uploads/'), $filename);

            $ext = substr($filename, strlen($filename)-3);

            $upload = new Upload;
            $upload->filename = $filename;

            $upload->user()->associate(auth()->user());
            $upload->status()->associate($reply->id);
            $upload->ext = $ext;

            $upload->save();
        }
        
        return redirect()->back();
    }
    
    public function getLike($statusId) {
        
        $status = Status::find($statusId);
        
        if(!$status) {
            
            return redirect()->route('home')->with('info', 'There is no status to like');;
        }
        
        if (!Auth::user()->isFriendsWith($status->user)) {
            
            return redirect()->route('home')->with('info', 'You are not friends with this person');;
        }
        
        if (Auth::user()->hasLikedStatus($status)) {
            
            return redirect()->back();
            
        }
        
        $like = $status->likes()->create([]);
            
        Auth::user()->likes()->save($like);
        
        return redirect()->back();
        
    }
    
    
    
}