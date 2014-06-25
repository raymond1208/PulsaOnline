@extends('layouts/authentication')

@section('content')

<div class="panel-heading">
  <h3 class="panel-title">First Instalation</h3>
</div>
<div class="panel-body">
  {{ Form::open(array('url' => 'install', 'method' => 'post')) }}
  <fieldset>

    <div class="form-group">
      <input class="form-control" placeholder="First name" name="first_name" type="text" autofocus value="{{ Input::old('first_name') }}">
    </div>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Last Name" name="last_name" required value="{{ Input::old('last_name') }}">
    </div>
    <div class="form-group">
      <input type="email" class="form-control" placeholder="Email Address" name="email" required value="{{ Input::old('email') }}">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="Password" name="password" required>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>

    </div>
    
    <input type="submit" value="Install" class="btn btn-lg btn-danger btn-block">
  </fieldset>
  {{ Form::close() }}
  
</div>

@stop