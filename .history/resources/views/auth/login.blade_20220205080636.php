@extends('layouts.shop.app')
@section('title', 'Login')
@section('breadcrumb')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="/">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="#">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
@includ
<section class="shop login section">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Login</h2>
                    <p>Please login to access your account</p>
                    <!-- Form -->
                    <form class="form" action="{{ route('login') }}" method="post">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Email<span>*</span></label>
                                    <input type="email" name="email" placeholder="" value="{{ old('email') }}" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Password<span>*</span></label>
                                    <input type="password" name="password" placeholder="" required="required">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Login</button>
                                    <a href="/register" class="btn">Register</a>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2">
                                        <input name="remember" id="2" {{ old('remember') ? 'checked' : '' }} type="checkbox">Remember me</label>
                                    
                                </div>
                                <a href="{{ route('password.request') }}" class="lost-pass">Lost your password?</a>
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