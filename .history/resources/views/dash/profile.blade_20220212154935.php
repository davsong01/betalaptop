@extends('layouts.dash.app')
@section('page-title', 'Dashboard')
@section('active')
<li class="breadcrumb-item active" aria-current="page">My profile</li>
@endsection
@section('content')
<form method="POST" action="{{route('saveprofile')}}" class="form-horizontal form-material mx-2" enctype="multipart/form-data">

<div class="row">
    <!-- Column -->

    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body profile-card">
                <center class="mt-4"> 

                     @if($user->avatar)
                        <img src="{{ asset($user->avatar)}}" alt="user" class="rounded-circle" width="150" >
                    @else
                        <img src="{{ asset('site/assets/images/avatars/d2.png') }}" class="rounded-circle" width="150">
                    @endif
                   
                    <h4 class="card-title mt-2">{{$user->name}}</h4>
                   
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <a href="javascript:void(0)" class="link">
                                <i class="icon-people" aria-hidden="true"></i>
                                <input type="file" placeholder="{{$user->name}}" class="form-control ps-0 form-control-line @error('name') is-invalid @enderror" name="name" required value="{{ old('name') ?: $user->name }}">
                            </a>
                        </div>
                       
                    </div>
                </center>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <div class="card-body">
                   @csrf
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Full Name</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="{{$user->name}}" class="form-control ps-0 form-control-line @error('name') is-invalid @enderror" name="name" required value="{{ old('name') ?: $user->name }}">
                             @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email" class="col-md-12">Email</label>
                        <div class="col-md-12">
                            <input type="email" placeholder="{{$user->email}}" class="form-control ps-0 form-control-line @error('name') is-invalid @enderror" required name="email" id="email" value="{{ old('email') ?: $user->email }}">
                             @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Password</label>
                        <div class="col-md-12">
                            <input type="password" value="password" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Phone No</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="{{$user->phone}}" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Message</label>
                        <div class="col-md-12">
                            <textarea rows="5" class="form-control ps-0 form-control-line"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Select Country</label>
                        <div class="col-sm-12 border-bottom">
                            <select class="form-select shadow-none border-0 ps-0 form-control-line">
                                <option>London</option>
                                <option>India</option>
                                <option>Usa</option>
                                <option>Canada</option>
                                <option>Thailand</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button class="btn btn-success mx-auto mx-md-0 text-white">Update
                                Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
@endsection
