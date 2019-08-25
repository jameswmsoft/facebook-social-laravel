@extends('templates.default')


@section('content')

    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="{{ route('status.post') }}" method="post" enctype="multipart/form-data">
                <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
                    <textarea placeholder="What's up {{ Auth::user()->getNameOrUsername()}}?" name="status" class="form-control" rows="2"></textarea>
                    @if ($errors->has('status'))
                        <span class="help-block">{{ $errors->first('status') }}</span>
                    @endif
                    <input type="file" name="input_file" style="margin-top: 10px"/>
                </div>
                <button type="submit" class="btn btn-default" style="background: #75B760;color: white">Update status</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            @if (!$statuses->count())
                <p>There aren't any statuses</p>
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
                            @else
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
                                        @if ($reply->user->avatar == '')

                                            <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" src="{{ $reply->user->getAvatarUrl() }}">
                                        @else
                                            <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" src="{{asset('uploads')}}/{{ $reply->user->avatar }}" style="width: 40px;height: 40px">
                                        @endif
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
                                        <p>{{ $reply->body }}</p>
                                        <ul class="list-inline">
                                            <li>{{ $reply->created_at->diffForHumans() }}</li>
                                            @if($reply->user->id !== Auth::user()->id)
                                                <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Like</a></li>
                                            @endif
                                            <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                            <form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
                                <div class='form-group {{ $errors->has("reply-{$status->id}") ? " has-error" : "" }}'>
                                    <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Reply to this status"></textarea>
                                    @if ($errors->has("reply-{$status->id}"))
                                        <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                                    @endif
                                </div>
                                <input type="submit" value="Reply" class="btn btn-default btn-sm" style="background: #75B760;color: white">
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                            </form>
                        </div>
                    </div>
                @endforeach
                {{ $statuses->render() }}
            @endif

        </div>
    </div>

@stop