@extends('layout.master')
@section('title','Index Page')
@section('content')
<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Login User</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{route('user.index')}}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('error'))
        <div class="alert alert-danger mb-1 mt-1">
            {{ session('error') }}
        </div>
        @endif
        <form action="signin" method="POST">
            @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>User Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="User Email">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>User Password:</strong>
                        <input type="text" name="password" class="form-control" placeholder="User Password">
                        @error('password')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
        </form>
    </div>
@endsection