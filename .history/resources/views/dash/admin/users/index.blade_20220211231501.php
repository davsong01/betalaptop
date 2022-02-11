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
                                
                                    <td>1</td>
                                    <td>Deshmukh</td>
                                    <td>Prohaska</td>
                                    <td>@Genelia</td>
                                    <td>
                                        
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a data-toggle="tooltip" title="Edit/View user" href="{{ route('users.edit', $user->id) }}" class="btn btn-primary"><span class="fa fa-edit"></span></a>
                                            <form id="delete" onsubmit="return confirm('Are you sure you want to delete forever?');" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE') 
                                                <button type="submit"><i class="fa fa-trash class="btn btn-danger"" ></i></button>
                                            </form>  
                                        </div>
                                                    {{-- <div class="button-group">
                                                        <form id="delete" style="float: left;" onsubmit="return confirm('Are you sure you want to delete forever?');" action="{{ route('users.destroy', $user->id) }}" method="POST" >
                                                            @csrf
                                                            @method('DELETE') 
                                                            <button class="form-control deletebutton" type="submit"><i class="fa fa-trash" style="color: #950026;"></i></button>
                                                        </form>  
                                                    </div> --}}

                                    
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
@endsection
