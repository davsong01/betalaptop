@extends('layouts.dash.app')
@section('page-title', 'Wallet Transactions')
@section('active')
<li class="breadcrumb-item active" aria-current="page">Wallet Transactions</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- column -->
               
                <h4 class="card-title">All Users</h4>
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Username</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Recipient</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($walletTrans as $transaction)
                                <tr style="color:{{ $transaction->amount > 0 ? 'green' : 'red'}}">
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        @if($transaction->user->avatar)
                                            <img src="{{ asset($transaction->user->avatar)}}" alt="user" class="rounded-circle" width="40" >
                                        @else
                                            <img src="{{ asset('site/assets/images/avatars/d2.png') }}" class="rounded-circle" width="40">
                                        @endif
                                    </td>
                                    <td>{{ $transaction->user->username }}</td>
                                   
                                    <td>{{ $transaction->type }}</td>
                                    <td>{!! \App\Setting::first()->value('currency') !!}{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->type == 'transfer' ? $transaction->transferRecipient()->username : 'N/A'}}</td>
                                   
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
