@extends('templates.default')


@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-6" style="padding: 0">
                    <h3>My Groups</h3>
                </div>
                <div class="col-lg-6" style="padding-top: 23px;text-align: right">
                    <a class="group_create_btn" href="{{route('group.create')}}">Create</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px">
        <div class="col-md-9">
            <div class="row">
                @foreach($groups as $group)
                    @if ($group->user_id == Auth::user()->id)
                    <div class="col-md-6" style="padding-left: 30px;margin-top: 10px">
                        <a class="pull-left" href="">
                            <img class="media-object" src="{{asset('images/group.jpg')}}" style="width: 50px;height: 50px"/>
                        </a>
                        <div class="media-body" style="padding-left: 10px">
                            <h4 class="media-heading"><a href="{{ route('group.page', ['group_id' => $group->id]) }}">{{ $group->name }}</a></h4>
                            <p>{{ $group->description }}</p>
                        </div>
                        <div class="media-body" style="padding-top: 15px;text-align: right">
                            {{--<a class="group_create_btn" href="{{ route('group.join', ['group_id' => $group->id]) }}">Join</a>--}}
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px">
        <h3>Joined Group</h3>
        <div class="col-md-9">
            <div class="row">
                @foreach($joins as $join)
                    <div class="col-md-6" style="padding-left: 30px;margin-top: 10px">
                        <a class="pull-left" href="">
                            <img class="media-object" src="{{asset('images/group.jpg')}}" style="width: 50px;height: 50px"/>
                        </a>
                        <div class="media-body" style="padding-left: 10px">
                            <h4 class="media-heading"><a href="{{ route('group.page', ['group_id' => $join->groups[0]->id]) }}">{{ $join->groups[0]->name }}</a></h4>
                            <p>{{ $join->groups[0]->description }}</p>
                        </div>
                        <div class="media-body" style="padding-top: 15px;text-align: right">
                            <a class="group_create_btn" style="background: #3B5998" href="{{ route('group.join', ['group_id' => $join->groups[0]->id]) }}">un-join</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px">
        <h3>New Group</h3>
        <div class="col-md-9">
            <div class="row">
                @foreach($groups as $group)
                    @if ($group->user_id != Auth::user()->id)
                        <div class="col-md-6" style="padding-left: 30px;margin-top: 10px">
                            <a class="pull-left" href="">
                                <img class="media-object" src="{{asset('images/group.jpg')}}" style="width: 50px;height: 50px"/>
                            </a>
                            <div class="media-body" style="padding-left: 10px">
                                <h4 class="media-heading"><a href="{{ route('group.page', ['group_id' => $group->id]) }}">{{ $group->name }}</a></h4>
                                <p>{{ $group->description }}</p>
                            </div>
                            <div class="media-body" style="padding-top: 15px;text-align: right">
                                <a class="group_create_btn" href="{{ route('group.join', ['group_id' => $group->id]) }}">Join</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@stop