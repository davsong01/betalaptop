@extends('layouts.dash.app')
@section('page-title', 'Proof of Payments')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Proof of Payments</li>
@endsection
@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
           <button type="button" class="btn btn-sm btn-primary my-2 mx-3" data-toggle="modal"
              data-target="#uploadPOPModal">Upload POP</button>
        </div>
        <div class="card-body">
          <small>Once your proof of payment is accepted, the amount paid would reflect in your wallet</small>
          <div class="table-responsive my-3">
            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>preview</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($proofs as $file)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      <a href="{{\Storage::url($file->path) }}" title="{{$file->name}}"><img src="{{ preg_match('/(\.pdf)$/', $file->path) ? asset('board/assets/images/file.png') : asset('board/assets/images/image.png') }}" class="img" style="width: 50px; hieght: 50px;"/></a>
                    </td>
                    <td>{{ $file->amount }}</td>
                    <td>
                      <span class="badge d-block badge-{{ ($file->status === 'pending') ? 'warning' : ($file->status === 'accepted' ? 'success' : 'danger')}}">{{  $file->status }}</span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
     {{-- Moal for POP --}}
    <div class="modal fade" id="uploadPOPModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pb-5">
            <form method="POST" action="{{ route('transactions.proofOfPayment') }}" enctype="multipart/form-data">
              @csrf
              <label for="proofOfPayment" class="form-label">Upload proof of payment</label>
              <div class="form-group">
                <div class="custom-file">
                  <input type="file" class="form-control" name="proofOfPayment" accept="image/*,application/pdf" class="custom-file-input"
                    id="pop" required>
                  <label class="custom-file-label" for="pop">Select POP
                    file...</label>
                </div>
              </div>
              <div class="form-group">
                <label for="amount" class="form-label">How much did you pay?</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
              </div>
              <button type="submit" class="btn btn-primary btn-sm btn-block my-2"
                title="Continue by uploading POP (Proof of Payment)">Upload <abbr
                  title="Proof of Payment">POP</abbr></button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
