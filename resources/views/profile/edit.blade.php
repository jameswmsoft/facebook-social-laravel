@extends('templates.default')


@section('content')
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="row" style="margin-top: 50px">
                <h3 class="auth_title">Update your profile</h3>

                <div class="row" style="background: white;border-radius: 10px;padding: 30px">
                    <div class="col-lg-12">
                        <form class="form-vertical" role="form" method="post" action="{{ route('profile.edit') }}" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-bottom: 30px">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            @if (Auth::user()->avatar == '')
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                            @else
                                                <img src="{{asset('uploads/')}}/{{Auth::user()->avatar}}" alt="" />
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;"> </div>
                                        <div>
                                            <div class="row" style="text-align: center">
                                               <span class="btn default btn-file" style="background: #3B5998;color: white;">
                                                <span class="fileinput-new" style="cursor: pointer"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="avatar"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput" style="background: #ef3333;color: white"> Remove </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="control-label">First name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name')  ?: Auth::user()->first_name }}">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name" class="control-label">Last name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('location') ? ' has-error' : '' }}">
                                <label for="location" class="control-label">Location</label>
                                <input type="text" name="location" class="form-control" id="location" value="{{ Request::old('first_name') ?: Auth::user()->location }}">
                                @if ($errors->has('location'))
                                    <span class="help-block">{{ $errors->first('location') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" style="background: #75B760;color: white">Update</button>
                            </div>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@stop