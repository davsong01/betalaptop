@extends('layouts.dash.app')
@section('page-title', 'Dashboard')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection
@section('content')
  <div class="row">
    <!-- Column -->
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Current Balance</h4>
          <div class="text-end">
            <h2 class="font-light mb-0">
              <i class="{{ $current_balance > 0 ? 'ti-arrow-up text-success' : 'ti-arrow-down text-danger' }}"></i>
              {!! \App\Setting::first()->value('currency') !!} {{ number_format($current_balance ?? 0) }}
            </h2>
            <span class="text-muted">current wallet</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Total Downlines</h4>
          <div class="text-end">
            <h2 class="font-light mb-0">
              {{ $num_of_downlines }}</h2>
            <span class="text-muted">total downlines</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Current Level</h4>
          <div class="text-end">
            <h2 class="font-light mb-0">
              {{ $level }}</h2>
            <span class="text-muted">current level</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-sm-5 offset-7 ml-0">
      <div class="list-group">
          <h3>Recent Transactions</h3>
        @foreach ($transactions as $transaction)
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 {{ $transaction->amount <= 0 ? 'text-danger' : 'text-success' }}">
                 {!! \App\Setting::first()->value('currency') !!} {{ number_format($transaction->amount) }}</h5>
              <small title="{{ $transaction->created_at }}">{{ $transaction->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-1"> {!! \App\Setting::first()->value('currency') !!} {{ number_format($transaction->amount) }}</p>
            <small>{{ $transaction->type }}</small>
          </a>
        @endforeach
    </div>
    <a href="{{route('transactions.index')}}" class="btn btn-sm btn-block btn-primary">View more</a>
    </div>
    <!-- Column -->
  </div>
@endsection
