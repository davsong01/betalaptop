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
                <form method="POST" action="{{route('saveprofile')}}" class="form-horizontal form-material mx-2">
                   @csrf
                    <div class="form-group">
                        <label class="col-md-12 mb-0">Full Name</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="{{$user->name}}" class="form-control ps-0 form-control-line @error('name') is-invalid @enderror" name="name" required value="{{ old('name') ?: $user->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-email" class="col-md-12">Email</label>
                        <div class="col-md-12">
                            <input type="email" placeholder="{{$user->email}}" class="form-control ps-0 form-control-line @error('name') is-invalid @enderror" required name="email" id="email" value="{{ old('email') ?: $user->email }}">
                            
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


{{-- @extends('layouts.dash.app')
@section('page-title', 'Users')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- column -->
               
                <h4 class="card-title">All Users</h4>
                <a href="" class="btn btn-success mb-10" >Download Here</a>
                <a href="" class="btn btn-success mb-10" >Download Here</a>

                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                
                                    <td>{{ $i++ }}</td>
                                    <td>Deshmukh</td>
                                    <td>Prohaska</td>
                                    <td>@Genelia</td>
                                    <td>
                                        
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a data-toggle="tooltip" title="Edit/View user" href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><span class="fa fa-edit"></span></a>
                                            <form id="delete" onsubmit="return confirm('Are you sure you want to delete forever?');" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE') 
                                                <button class="btn btn-danger" type="submit"><i class="fa fa-trash" ></i></button>
                                            </form>  
                                        </div>
                                                   
                                    </td>
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
