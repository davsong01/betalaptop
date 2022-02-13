@extends('layouts.dash.app')
@section('page-title', 'Binary Tree')
@section('active')
<li class="breadcrumb-item active" aria-current="page">{{ $user->username }}'s tree</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- column -->
                <h4 class="card-title">Binary Tree</h4>
               
            </div>
        </div>
    </div>
</div>
@endsection
