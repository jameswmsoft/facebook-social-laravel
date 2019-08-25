<?php

namespace Facebook\Http\Controllers;

use Facebook\Models\Group;
use Facebook\Models\Join;
use Facebook\Models\Status;
use Illuminate\Http\Request;
use Auth;
use Facebook\Http\Requests;

class GroupController extends Controller
{
    public function getGroup(){
        $groups = Group::all();
        $joins = Join::where('user_id', Auth::user()->id)->get();
        return view('group.index', ['groups' =>$groups, 'joins'=>$joins]);
    }

    public function createGroup(){
        return view('group.create');
    }

    public function newGroup(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $group = new Group;
        $group->name = $request->name;
        $group->description = $request->description;
        $group->privacy = $request->privacy;
        $group->user_id = Auth::user()->id;

        $group->save();

        return redirect()
            ->route('group.index')
            ->with('info', 'new Group created');
    }

    public function joinGroup($groupId){
        $join = new Join;
        $join->user_id = Auth::user()->id;
        $join->group_id = $groupId;

        $join->save();

        return redirect()
            ->route('group.index')
            ->with('info', 'new Group Joined');
    }

    public function pageGroup($groupId){
        $statuses = Status::whereNull('parent_id')->where(function($query) {

            return $query->where('user_id', Auth::user()->id)
                ->orWhereIn('user_id', Auth::user()->friends()->lists('id'));

        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('group.page')
            ->with('statuses', $statuses);
    }
}
