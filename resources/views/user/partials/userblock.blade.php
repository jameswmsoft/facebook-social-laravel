<div class="media">
    <a class="pull-left" href="{{ route('profile.index', ['username' => $user->username]) }}">
        @if ($user->avatar == '')

            <img class="media-object" alt="{{ $user->getNameOrUsername() }}" src="{{ $user->getAvatarUrl() }}">
        @else
            <img class="media-object" alt="{{ $user->getNameOrUsername() }}" src="{{asset('uploads')}}/{{ $user->avatar }}" style="width: 40px;height: 40px">
        @endif
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $user->username]) }}">{{ $user->getNameOrUserName() }}</a></h4>
        @if ($user->location)

            <p>{{ $user->location }}</p>

        @endif

    </div>
</div>