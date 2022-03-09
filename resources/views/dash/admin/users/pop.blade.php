@extends('layouts.dash.app')
@section('page-title', 'Proof of Payments')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Proof of Payments</li>
@endsection
@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive my-3">
            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>preview</th>
                  <th>Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($proofs as $proof)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      <a href="{{\Storage::url($proof->path) }}" title="{{$proof->name}}"><img src="{{ preg_match('/(\.pdf)$/', $proof->name) ? asset('board/assets/images/file.png') : asset('board/assets/images/image.png') }}" class="img" style="width: 50px; hieght: 50px;"/></a></td>
                      <td>{{$proof->amount}}</td>
                    <td>
                      @if ($proof->status === 'pending')
                         <form method="POST" action="{{route('transaction.accept.proofOfPayment', ['id' => $proof->name])}}" class="inline-form d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-warning" title="Accept proof of payment">Accept</button>
                      </form>
                      <form method="POST" action="{{route('transaction.reject.proofOfPayment', ['id' => $proof->name])}}" class="inline-form d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-danger" title="Reject proof of payment">Reject</button>
                      </form>
                      @else
                         <span class="badge d-block badge-{{($proof->status === 'accepted' ? 'success' : 'danger')}}">{{  $proof->status }}</span>
                      @endif

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
