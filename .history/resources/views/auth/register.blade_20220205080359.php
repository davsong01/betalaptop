@extends('layouts.shop.app')
@section('title', 'Register')
@section('breadcrumb')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="/">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="shop login section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Register</h2>
                    <p>Please register</p>
                    <!-- Form -->
                    <form class="form" method="post" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Name<span>*</span></label>
                                    <input type="text" name="name" placeholder="" value="{{ old('name') }}" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Email<span>*</span></label>
                                    <input type="text" name="email" placeholder="" value="{{ old('email') }}" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Password<span>*</span></label>
                                    <input type="password" name="password" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Confirm Password<span>*</span></label>
                                    <input type="password" name="password_confirmation" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Register</button>
                                    <a href="login.html" class="btn">Login</a>
                                </div>
                                {{-- <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">Sign Up for Newsletter</label>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection