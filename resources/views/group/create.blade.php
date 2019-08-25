@extends('templates.default')


@section('content')

    <h3 class="auth_title">Create New Group</h3>

    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" method="post" action="{{ route('group.new') }}">

                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="first_name" class="control-label">Group Name</label>
                    <input type="text" name="name" class="form-control" id="group_name">
                    @if ($errors->has('name'))
                        <span class="help-block">Please input the Group Name</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="last_name" class="control-label">Group Description</label>
                    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">Please input the Group Description</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="location" class="control-label">Select privacy</label>
                    <select name="privacy" class="form-control">
                        <option value="closed">Closed</option>
                        <option value="public">Public</option>
                    </select>
                </div>
                <div class="form-group" style="margin-top: 50px">
                    <button type="submit" class="btn btn-default" style="background: #75B760;color: white">Create</button>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>

@stop