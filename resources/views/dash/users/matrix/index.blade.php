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
          <div class="text-end">
            <h2 class="font-light mb-0">
              <i class="{{ $current_balance > 0 ? 'ti-arrow-up text-success' : 'ti-arrow-down text-danger' }}"></i>
              {!! \App\Setting::first()->value('currency') !!} {{ number_format($current_balance ?? 0) }}
            </h2>
            <span class="text-muted">current wallet</span>
          </div>
          <h4 class="card-title">My downlines</h4>
          @if (auth()->user()->wallet() <= \App\Setting::first()->value('amount_per_slot'))
            <a href="{{ route('downline.create') }}" class="btn btn-success mb-10">Register new user</a>
          @else
            <div class="alert alert-warning" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
              <strong> <a href="{{ route('wallet.index') }}" target="_blank">Top up wallet with at least
                  {!! \App\Setting::value('currency') !!}{{ number_format(auth()->user()->wallet() >= 0? \App\Setting::value('amount_per_slot') -auth()->user()->wallet(): \App\Setting::value('amount_per_slot')) }}</a>
              </strong> to register a new downline
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
                @foreach ($matrices as $user)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      <img src="{{ asset($user->avatar ?? 'site/assets/images/avatars/d2.png') }}"
                        class="rounded-circle" width="40">
                    </td>
                    <td><i><b>{{ $user->username }}</b></i></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ \App\Setting::first()->value('currency') }}{{ number_format($user->wallet()) }}</td>
                    <td>{{ $user->level() }} <br> <small><i><a href="{{ route('binarytree', $user['id']) }}">View
                            binary tree</a></i></small></td>
                    <td>{{ $user->index }}</td>
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
