@extends('layouts.dash.app')
@section('page-title', 'Register new user')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Register new downline</li>
@endsection
@section('content')
  <form method="POST" action="" class="form-horizontal form-material mx-2" enctype="multipart/form-data">

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            @method('PUT')
            @csrf
            <div class="input-group mb-3">
              <div class="col-md-12">
                <label for="name">Full Name</label>
                <input type="text" placeholder="Enter name" class="form-control" name="name" required
                  value="{{ old('name') }}">
              </div>
            </div>
            <div class="col-md-12">
              <label for="email">Email</label>
              <div class="input-group mb-3">
                <input type="email" placeholder="Enter email" value="{{ old('email') }}" required class="form-control"
                  name="email" id="email">
                <div class="input-group-append ">
                  <span class="input-group-text"><i class="fa fa-warning text-warning email-status"></i></span>
                </div>
                <div id="email-msg" class="d-block invalid-feedback"></div>
              </div>
            </div>
            <div class="input-group mb-3">
              <div class="col-md-12">
                <label for="phone">Phone</label>
                <input type="text" placeholder="Enter phone number" class="form-control" required name="phone"
                  id="phone" value="{{ old('phone') }}">
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
              <label for="username">Password <span style="color:blue"> Leave blank to use default Password:
                  <b>pass12345</b></span></label>
              <div class="input-group mb-3">
                <input type="password" value="{{ old('password') }}" name="password" class="form-control">
              </div>
            </div>
            <div class="input-group mb-3">
              <label class="col-sm-12">Select parent username | <small><i><a href="#" target="_blank">View
                      your binary tree </a></i></small></label>
              <div class="col-sm-12">
                <select class="form-control" name="positioning" id="positioning" required>
                  <option value="">...Select...</option>
                  @php
                    function mat($parentId, $parentLevel, $matrices, $username)
                    {
                        foreach ($matrices as $index => $user):
                            if ($index === $matrices->keys()->last() && $matrices->filter(fn($item) => !$item->exists)->isNotEmpty()):
                              echo "<option value='$parentId::$parentLevel' id='$user->id'>$username</option>";
                            endif;
                            if ($user->mapping):
                                mat($user->id, $parentLevel + 1, $user->mapping, $user->username);
                            endif;
                        endforeach;
                    }
                    mat(auth()->id(), 1, $matrices, auth()->user()->username);
                  @endphp
                </select>
              </div>
            </div>
            <div class="input-group mb-3">
              <div class="col-sm-12">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="childPosition" value="0" id="childPositionLeft" required>
                  <label class="form-check-label" for="chilPositionLeft">
                   Left position
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="childPosition" id="childPositionRight" value="1">
                  <label class="form-check-label" for="childPositionRight">
                    Right position
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12 d-flex">
                <button class="btn btn-success mx-auto mx-md-0 text-white" style="width:100%">Process
                  registration</button>
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
        jsLaravel(element.closest('form'), {
            action: "validate/email",
            method: 'post'
          })
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
        jsLaravel(element.closest('form'), {
            action: "validate/username",
            method: 'post'
          })
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

      $('form select#positioning').change(function(event) {
        const element = event.target;
        const id = element.value?.split('::')[0];
        jsLaravel(element.closest('form'), {
            action: `available-positions/${id}`,
            method: 'post'
          })
          .then(res => res.json())
          .then(res => {
            if (res.status === "success") {
              console.log(res.data);
              if(!res.data[0]){
                 $("#childPositionLeft").attr("checked", true)
              }else{
                 $("#childPositionRight").attr("checked", true)
              }
            }
          }).catch(err => {
           console.log(err);
          })
      })
    })
  </script>
  <!-- Column -->
  </div>
@endsection
