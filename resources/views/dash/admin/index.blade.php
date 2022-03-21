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
          <h4 class="card-title">Total Users</h4>
          <div class="text-end">
            <h2 class="font-light mb-0">
              {{ number_format($total_users) }}
            </h2>
            <span class="text-muted">total users</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Total Wallet</h4>
          <div class="text-end">
            <h2 class="font-light mb-0">
              <i class="{{ $total_wallet > 0 ? 'ti-arrow-up text-success' : 'ti-arrow-down text-danger' }}"></i>
              {!! \App\Setting::first()->value('currency') !!} {{ number_format($total_wallet ?? 0) }}
            </h2>
            <span class="text-muted">total wallet</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Total Tops</h4>
          <div class="text-end">
            <h2 class="font-light mb-0">
              {{ number_format($total_topups) }}</h2>
            <span class="text-muted card-subtitle">total tops</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="row">
        <div class="card col-sm-8">
          <div class="card-header">
            <h3>Top 5 Users</h3>
          </div>
           <div class="card-body table-responsive my-3">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Position</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($top_users as $matrice)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $matrice->user->name }}</td>
                    <td>{{ $matrice->user->email }}</td>
                    <td>{{ $matrice->user->level() }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Total Transfers</h4>
                <div class="text-end">
                  <h2 class="font-light mb-0">
                    {{ number_format($total_transfers) }}</h2>
                  <span class="text-muted">total transfers</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Total Proof of Payments</h4>
                <div class="text-end">
                  <h2 class="font-light mb-0">
                    {{ number_format($total_pops) }}</h2>
                  <span class="text-muted">total proof of payments</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection
