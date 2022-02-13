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
                <div class="tree">
                    <ul>
                        <li>
                            <a href="#">1</a>
                            <ul>
                                <li>
                                    <a href="#">2</a>
                                    <ul>
                                <li>
                                    <a href="#">2.1</a>
                                </li>
                                <li>
                                    <a href="#">2.2</a>
                                </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">3</a>
                                    <ul>
                                        <ul>
                            <li>
                                            <a href="#">3.1</a>
                            <ul>
                            <li>
                                            <a href="#">3.1.1</a>
                                        </li>
                                        <li>
                                            <a href="#">3.1.2</a>
                                        </li>
                                    </ul>
                                        </li>
                                        <li>
                                            <a href="#">3.2</a>
                                        </li>
                                    </ul>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
