@extends('layouts.dash.app')
@section('page-title', 'Users')
@section('active')
<li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- column -->
               
                <h4 class="card-title">All Users</h4>
                @if(auth()->user()->wallet() >= \App\Setting::first()->value('amount_per_slot')  )
                <a href="{{ route('downline.create') }}" class="btn btn-success mb-10" >Register new user</a>
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
                                <th>Position</th>
                                {{-- <td>Actions</td> --}}
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
                                    <td>{{ \App\Setting::first()->value('currency') }}{{ $user->wallet() }} <br> <small><i><a href="{{ route('wallethistory', $user->id) }}">View history</a></i></small></td>
                                    <td>{{ $user->level() }}  <br> <small><i><a href="{{ route('binarytree', $user->id) }}">View binary tree</a></i></small></td>
                                    <td>{{ $user->position }}</td>
                                    {{-- <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a data-toggle="tooltip" title="Edit/View user" href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><span class="fa fa-edit"></span></a>
                                            <form id="delete" onsubmit="return confirm('Are you sure you want to delete forever?');" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE') 
                                                <button class="btn btn-danger" type="submit"><i class="fa fa-trash" ></i></button>
                                            </form>  
                                        </div>
                                                   
                                    </td> --}}
                                
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
