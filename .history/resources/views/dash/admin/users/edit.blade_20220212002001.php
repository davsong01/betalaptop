@extends('layouts.dash.app')
@section('page-title', 'Edit user')
@section('active')
<li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{route('users.update', $user->id)}}" class="form-horizontal form-material mx-2" enctype="multipart/form-data">
                   @csrf
                   @method('patch')
                    <img src="../assets/images/users/5.jpg" class="rounded-circle"
                        width="150" />
                    @if($avatar)
                    <img src="{{ asset($avatar)}}" alt="user" class="profile-pic me-2">
                    @else
                        <img src="{{ asset('site/assets/images/avatars/d2.png') }}" class="profile-pic me-2">
                    @endif
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Change avatar</label>
                        <div class="col-md-12">
                            <input type="file" class="form-control ps-0 form-control-line" name="avatar">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Full Name</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="{{$user->name}}" class="form-control ps-0 form-control-line" name="name" required value="{{ old('name') ?: $user->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email" class="col-md-12">Email</label>
                        <div class="col-md-12">
                            <input type="email" placeholder="{{$user->email}}" class="form-control ps-0 form-control-line" required name="email" id="email" value="{{ old('email') ?: $user->email }}">
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Phone No</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="{{$user->phone }}" name="phone" value="{{ old('phone') ?: $user->phone }}" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Wallet ({{ \App\Setting::first()->value('currency') }})</label>
                        <div class="col-md-12">
                            <input type="number" name="" value="{{ $user->wallet() }}" disabled class="form-control ps-0 form-control-line">
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
                        <label class="col-md-12 mb-0">Change Password</label>
                        <div class="col-md-12">
                            <input type="text" name="password" value="{{ old('password') }}" class="form-control ps-0 form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button class="btn btn-info mx-auto mx-md-0 text-white">Update
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