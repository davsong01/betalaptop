@extends('layouts.dash.app')
@section('page-title', 'Register new user')
@section('active')
<li class="breadcrumb-item active" aria-current="page">Register new downline</li>
@endsection
@section('content')
<form method="POST" action="{{route('downline.store')}}" class="form-horizontal form-material mx-2" enctype="multipart/form-data">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                   @csrf
                    <div class="input-group mb-3">
                        <div class="col-md-12">
                            <label for="name">Full Name</label>
                            <input type="text" placeholder="Enter name" class="form-control" name="name" required value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="email">Email</label>
                        <div class="input-group mb-3">
                            <input type="email" placeholder="Enter email" value="{{ old('email') }}" required class="form-control" name="email" id="email">
                            <div class="input-group-append ">
                                <span class="input-group-text"><i class="fa fa-warning text-warning email-status"></i></span>
                            </div>
                            <div id="email-msg" class="d-block invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-md-12">
                            <label for="phone">Phone</label>
                            <input type="text" placeholder="Enter phone number" class="form-control" required name="phone" id="phone" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="username">Username</label>
                        <div class="input-group mb-3">
                            <input type="text" placeholder="Enter username" name="username" class="form-control" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-warning text-warning username-status"></i></span>
                            </div>
                             <div id="username-msg" class="d-block invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="username">Password <span style="color:blue"> Leave blank to use default Password: <b>pass12345</b></span></label>
                        <div class="input-group mb-3">
                            <input type="password" value="{{ old('password') }}" name="password" class="form-control">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label class="col-sm-12">Select Position for this user | <small><i><a href="{{ route('binarytree', auth()->user()->id) }}" target="_blank">View your binary tree</a></i></small></label>
                        <div class="col-sm-12">
                            <select class="form-control" name="position" id="position" required>
                                <option value="">...Select...</option>
                                @if($level > 0)
                                    @foreach($matrix->where('position', 1) as $mat)
                                        @foreach($mat['left'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Left {{  $value }}">Level {{ $mat['position'] }}, Left {{  $value }}</option>
                                        @endif
                                        @endforeach

                                        @foreach($mat['right'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Right {{  $value }}">Level {{ $mat['position'] }}, Right {{  $value }}</option>
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @if($level > 1)
                                    @foreach($matrix->where('position', 2) as $mat)
                                        @foreach($mat['left'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Left {{  $value }}">Level {{ $mat['position'] }}, Left {{  $value }}</option>
                                        @endif
                                        @endforeach

                                        @foreach($mat['right'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Right {{  $value }}">Level {{ $mat['position'] }}, Right {{  $value }}</option>
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @if($level > 2)
                                    @foreach($matrix->where('position', 3) as $mat)
                                        @foreach($mat['left'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Left {{  $value }}">Level {{ $mat['position'] }}, Left {{  $value }}</option>
                                        @endif
                                        @endforeach

                                        @foreach($mat['right'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Right {{  $value }}">Level {{ $mat['position'] }}, Right {{  $value }}</option>
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @if($level > 3)
                                    @foreach($matrix->where('position', 4) as $mat)
                                        @foreach($mat['left'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Left {{  $value }}">Level {{ $mat['position'] }}, Left {{  $value }}</option>
                                        @endif
                                        @endforeach

                                        @foreach($mat['right'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Right {{  $value }}">Level {{ $mat['position'] }}, Right {{  $value }}</option>
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @if($level > 4)
                                    @foreach($matrix->where('position', 5) as $mat)
                                        @foreach($mat['left'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Left {{  $value }}">Level {{ $mat['position'] }}, Left {{  $value }}</option>
                                        @endif
                                        @endforeach

                                        @foreach($mat['right'] as $value=>$user)
                                        @if($user == 0)
                                            <option value="Level {{ $mat['position'] }}, Right {{  $value }}">Level {{ $mat['position'] }}, Right {{  $value }}</option>
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 d-flex">
                            <button class="btn btn-success mx-auto mx-md-0 text-white" style="width:100%">Process registration</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(() => {
            // Email validation
           $('form input[name="email"]').focusout((event) => {
               const element = event.target;
               jsLaravel(element.closest('form'), {action: "validate/email", method: 'post' })
                .then(res => res.json())
                    .then(res => {
                        if (res.status === "success") {
                            $('.email-status').removeClass('fa fa-warning fa-times  text-warning text-danger')
                            .addClass('fa fa-check text-success');
                            $('#email-msg').removeClass('invalid-feedback')
                            .addClass('valid-feedback').text(res.message);
                        } else {
                            $('.email-status').removeClass('fa fa-warning fa-check  text-warning text-success')
                            .addClass('fa fa-times text-danger');
                            $('#email-msg').removeClass('valid-feedback')
                            .addClass('invalid-feedback').text(res.message);
                        }
                    }).catch(err => {
                       $('.email-status').removeClass('fa fa-warning fa-check  text-warning text-success')
                            .addClass('fa fa-times text-danger');
                            $('#email-msg').removeClass('valid-feedback')
                            .addClass('invalid-feedback').text('An error occurred, please try again');
                    })
           })

            // username validation
           $('form input[name="username"]').focusout((event) => {
               const element = event.target;
               jsLaravel(element.closest('form'), {action: "validate/username", method: 'post' })
                .then(res => res.json())
                    .then(res => {
                        if (res.status === "success") {
                            $('.username-status').removeClass('fa fa-times text-warning text-danger')
                            .addClass('fa fa-check text-success');
                            $('#username-msg').removeClass('invalid-feedback')
                            .addClass('valid-feedback').text(res.message);
                        } else {
                            $('.username-status').removeClass('fa fa-check text-warning text-success')
                            .addClass('fa fa-times text-danger');
                            $('#username-msg').removeClass('valid-feedback')
                            .addClass('invalid-feedback').text(res.message);
                        }
                    }).catch(err => {
                       $('.username-status').removeClass('fa fa-check text-success')
                            .addClass('fa fa-times text-danger');
                            $('#username-msg').removeClass('valid-feedback')
                            .addClass('invalid-feedback').text('An error occurred, please try again');
                    })
           })
        })
    </script>
    <!-- Column -->
</div>
@endsection
