@extends('templates.default')


@section('content')

    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>
            @if (!$statuses->count())
                <p>{{ $user->getNameOrUsername() }} hasn't made any statuses</p>
            @else
                @foreach($statuses as $status)
                    <div class="media">
                        <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                            @if ($status->user->avatar == '')

                                <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">
                            @else
                                <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{asset('uploads')}}/{{ $status->user->avatar }}" style="width: 40px;height: 40px">
                            @endif
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
                            <p>{{ $status->body }}</p>

                            @if ($status->upload->ext != 'none')
                            @if ($status->upload->ext == 'mp4' || $status->upload->ext == 'avi')
                                <video width="320" height="240" controls>
                                    <source src="{{asset('uploads')}}/{{ $status->upload->filename }}" type="video/mp4">
                                </video>
                            @elseif ($status->upload->ext == 'png' || $status->upload->ext == 'PNG' || $status->upload->ext == 'jpg' || $status->upload->ext == 'JPG')
                                <img class="media-object" src="{{asset('uploads')}}/{{ $status->upload->filename }}" style="width: 320px;height: 240px">
                            @endif

                            @endif
                            <ul class="list-inline">
                                <li>{{ $status->created_at->diffForHumans() }}</li>
                                @if($status->user->id !== Auth::user()->id)
                                    <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">Like</a></li>
                                @endif
                                <li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</li>
                            </ul>
                            @foreach ($status->replies as $reply)
                                <div class="media">
                                    <a class="pull-left" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                                        @if ($status->user->avatar == '')

                                            <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{ $status->user->getAvatarUrl() }}">
                                        @else
                                            <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="{{asset('uploads')}}/{{ $status->user->avatar }}" style="width: 40px;height: 40px">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
                                        <p>{{ $reply->body }}</p>

                                        <ul class="list-inline">
                                            <li>{{ $reply->created_at->diffForHumans() }}</li>
                                            @if($status->user->id !== Auth::user()->id)
                                                <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
                                            @endif
                                            <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                            @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
                                <form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post" enctype="multipart/form-data">
                                    <div class='form-group {{ $errors->has("reply-{$status->id}") ? " has-error" : "" }}'>
                                        <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                                        @if ($errors->has("reply-{$status->id}"))
                                            <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                                        @endif
                                    </div>
                                    {{--<input type="file" name="file_input" style="margin: 10px 0"/>--}}
                                    <input type="submit" value="Reply" class="btn btn-default btn-sm" style="background: #75B760;color: white">
                                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach 
                
            @endif
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if (Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameorUsername() }} to accept your friend request</p>
                
            @elseif (Auth::user()->hasFriendRequestRecieved($user))
                <a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Accept friend request</a>
                <a href="{{ route('friend.deny', ['username' => $user->username]) }}" class="btn" style="background: #B0BEC5;color: black">Deny request</a>

            @elseif (Auth::user()->isFriendsWith($user))
                <p>You and {{ $user->getNameorUsername() }} are friends</p>
                
            <form action="{{ route('friend.delete', ['username' => $user->username]) }}" method="post">
                <input type="submit" class="btn btn-primary" value="De-friend">
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
                
            @elseif (Auth::user()->id !== $user->id)
                <a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Add as a friend</a>
                
            @endif
                
           
            
            <h4>{{ $user->getNameorUsername() }}'s friends</h4>
            
               
            @if (!$user->friends()->count())
                <p>{{ $user->getNameorUsername() }} has no friends</p>
            @else
                @foreach ($user->friends() as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
            
        </div>
    </div>
    
@stop