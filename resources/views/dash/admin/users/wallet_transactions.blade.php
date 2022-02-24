@extends('layouts.dash.app')
@section('page-title', 'Online Transactions')
@section('active')
<li class="breadcrumb-item active" aria-current="page">Online Transactions</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- column -->
                <h4 class="card-title">All Online Transactions</h4>
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Avatar</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Trnx Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($walletTrans as $transaction)
                                <tr>
                                    <td>{{ $loop->index +1 }}</td>
                                    <td>{{ $transaction->created_at}}</td>

                                    <td>
                                        @if($transaction->user->avatar)
                                            <img src="{{ asset($transaction->user->avatar)}}" alt="user" class="rounded-circle" width="40" >
                                        @else
                                            <img src="{{ asset('site/assets/images/avatars/d2.png') }}" class="rounded-circle" width="40">
                                        @endif
                                    </td>
                                    <td>{{ $transaction->user->username }}</td>
                                    <td>{!! \App\Setting::first()->value('currency') !!}{{ $transaction->amount}}</td>
                                    <td>{{ $transaction->transaction_id }}</td>
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
