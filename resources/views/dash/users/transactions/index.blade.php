@extends('layouts.dash.app')
@section('page-title', 'Wallet history')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Wallet history</li>
@endsection
@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
                <h4 class="card-title">Current Balance</h4>
                <div class="text-end">
                    <h2 class="font-light mb-0"><i class="ti-arrow-up text-success"></i> {!!\App\Setting::first()->value('currency') !!} {{number_format($current_balance)}}</h2>
                    <span class="text-muted">current wallet</span>
                </div>
            </div>
        </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <!-- column -->
          <h4 class="card-title"></h4>
          <div class="d-flex flex-wrap justify-content-around" style="max-width: 430px;">
            <button type="button" class="btn btn-sm btn-success my-2 mx-3" data-toggle="modal"
              data-target="#topupModal">Top Up
              wallet</button>
            <button type="button" class="btn btn-sm btn-danger my-2 mx-3" data-toggle="modal"
              data-target="#transferFundModal">Transfer Fund</button>
            <button type="button" class="btn btn-sm btn-primary my-2 mx-3" data-toggle="modal"
              data-target="#uploadPOPModal">Upload POP</button>
          </div>

          <!-- Modal For Topup -->
          <div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="topupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="topupModalLabel">Top methods</h5>
                  <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="accordion" id="accordionExample">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="onlineTransfer" name="paymentMethod" class="custom-control-input"
                        data-toggle="collapse" data-target="#collapseOnlineTransfer" aria-expanded="true"
                        aria-controls="collapseOnlineTransfer" checked />
                      <label class="custom-control-label" for="onlineTransfer">Online transfer</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="offlineTransfer" name="paymentMethod" class="custom-control-input"
                        data-toggle="collapse" data-target="#collapseOfflineTransfer" aria-expanded="true"
                        aria-controls="collapseOfflineTransfer" />
                      <label class="custom-control-label" for="offlineTransfer">Offline
                        transfer</label>
                    </div>

                    <div id="collapseOnlineTransfer" class="collapse show" aria-labelledby="onlineTransfer"
                      data-parent="#accordionExample">
                      <div class="card-body">
                        <button type="button" class="btn btn-primary btn-sm btn-block my-2" data-toggle="modal"
                          data-target="#continueToPaystackModal" title="continue to paystack">Continue with online
                          transfer</button>
                      </div>
                    </div>
                    <div id="collapseOfflineTransfer" class="collapse" aria-labelledby="headingTwo"
                      data-parent="#accordionExample">
                      <div class="card-body">
                        <h4>Make payment in to: </h4>
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-12">Acount name: {{ \App\Setting::first()->value('official_account_name') }}</div>
                            <div class="col-md-12">Acount number: {{ \App\Setting::first()->value('official_account_number') }}</div>
                            <div class="col-12">Bank: {{ \App\Setting::first()->value('official_bank') }}</div>
                          </div>
                        </div>
                        <form class="" method="POST" action="{{ route('transactions.proofOfPayment')}}">
                          <div class="my-3">

                            <div class="input-group">
                              <div class="custom-file">
                                <small>Upload proof of payment</small>
                                <input type="file" class="custom-file-input" id="validatedInputGroupCustomFile" required>
                                <label class="custom-file-label" for="validatedInputGroupCustomFile">Select POP
                                  file...</label>
                              </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary btn-sm btn-block my-2"
                            title="Continue by uploading POP (Proof of Payment)">Upload <abbr
                              title="Proof of Payment">POP</abbr></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal For Transfer Fund -->
          <div class="modal fade" id="transferFundModal" tabindex="-1" aria-labelledby="transferFundModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="transferFundModalLabel">Transfer Fund</h5>
                  <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="POST" action="{{ route('transactions.validate.usernameOrEmail') }}">
                    @csrf
                    <div class="mb-3">
                      <label for="usernameOrEmail" class="form-label">Who would you like to pay to?</label>
                      <input type="text" class="form-control" id="usernameOrEmail" name="usernameOrEmail"
                        placeholder="Enter username or email" required>
                      <div class="invalid-feedback">
                        An error occurred
                      </div>
                    </div>
                    <div class="mb-3 hide">
                      <label for="transferAmount" class="form-label">How much would you like to transfer?</label>
                      <input type="text" class="form-control" id="transferAmount" name="transferAmount"
                        placeholder="Enter tranfer amount" required>
                      <div class="invalid-feedback">
                        An error occurred
                      </div>
                    </div>
                    <div class="mb-3">
                      <button type="click" id="validateUser" class="btn btn-warning btn-sm btn-block">Validate</button>
                    </div>
                    <div class="mb-3 hide">
                      <button type="submit" class="btn btn-success btn-sm btn-block">Transfer</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive my-3">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Recipient</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($walletTrans as $transaction)
                  <tr style="color:{{ $transaction->amount > 0 ? 'green' : 'red' }}">
                    <td>{{ $loop->index + 1 }}</td>
                    <td title="{{$transaction->created_at}}">{{ ($transaction->created_at->diffForHumans()) }}</td>
                    <td>{{ $transaction->type }}</td>
                    <td>{!! \App\Setting::first()->value('currency') !!}{{ number_format($transaction->amount) }}</td>
                    <td>
                      {{ $transaction->type != 'topup'? ($transaction->transferRecipient != null? $transaction->transferRecipient->username: 'Nil'): 'N/A' }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal For Topup -->
    <div class="modal fade" id="continueToPaystackModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pb-5">
            <form method="POST" action="{{ route('pay') }}">
              <div class="mb-3">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}" required>
                <input type="hidden" name="quantity" value="1" required>
                <input type="hidden" name="currency" value="NGN" required>
                <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value']) }}"
                  required>

                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}" required>
                @csrf
                <label for="amount" class="form-label">How much would you like to pay?</label>
                <input type="number" class="form-control" id="amount" name="amount" min="1000"
                  placeholder="Enter amount" required>
              </div>
              <div class="mb-3">
                <small>You will be redirected to paystack payment gateway</small>
                <button type="submit" class="btn btn-success btn-sm btn-block">Pay</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
