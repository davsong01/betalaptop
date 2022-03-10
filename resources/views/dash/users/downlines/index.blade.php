@extends('layouts.dash.app')
@section('page-title', 'Downlines')
@section('active')
<li class="breadcrumb-item active" aria-current="page">Downlines</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- column -->
               
                <h4 class="card-title">My downlines</h4>
                @if(auth()->user()->wallet() >= \App\Setting::first()->value('amount_per_slot')  )
                <a href="{{ route('downline.create') }}" class="btn btn-success mb-10" >Register new user</a>
                @else
                    <div class="alert alert-warning" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong> <a href="{{ route('wallet.index') }}">Top up wallet with at least {!! \App\Setting::value('currency') !!}{{ number_format( (auth()->user()->wallet() >= 0 ) ? (\App\Setting::value('amount_per_slot') - auth()->user()->wallet()) : \App\Setting::value('amount_per_slot')) }}</a> </strong> to register a new downline
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Wallet</th>
                                <th>Level</th>
                                <th>Position index</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->sortBy('position') as $user)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar)}}" alt="user" class="rounded-circle" width="40" >
                                        @else
                                            <img src="{{ asset('site/assets/images/avatars/d2.png') }}" class="rounded-circle" width="40">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}  <br> <i><b>{{ $user->username }}</b></i></td>
                                   
                                    <td>{{ $user->email }}</td>
                                    <td>{{ \App\Setting::first()->value('currency') }}{{ number_format($user->wallet()) }}</td>
                                    <td>{{ $user->level() }}  <br> <small><i><a href="{{ route('binarytree', $user->id) }}">View binary tree</a></i></small></td>
                                    <td>{{ $user->position }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
