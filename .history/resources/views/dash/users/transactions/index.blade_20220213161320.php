@extends('layouts.dash.app')
@section('page-title', 'Wallet history')
@section('active')
  <li class="breadcrumb-item active" aria-current="page">Wallet history</li>
@endsection
@section('content')
  <div class="row">
    <div class="col-sm-12">
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
                        You will be redirected to paystack payment gateway
                        <a href="#" class="btn btn-primary btn-sm btn-block my-2" title="continue to paystack">Continue to
                          paystack</a>
                      </div>
                    </div>
                    <div id="collapseOfflineTransfer" class="collapse" aria-labelledby="headingTwo"
                      data-parent="#accordionExample">
                      <div class="card-body">
                        <h4>Make payment in to: </h4>
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col">Acount name</div>
                            <div class="col">Acount number</div>
                            <div class="col">Bank</div>
                          </div>
                        </div>
                        <form class="">
                          <div class="my-3">

                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="validatedInputGroupCustomFile" required>
                                <label class="custom-file-label" for="validatedInputGroupCustomFile">Select POP file...</label>
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
                  @foreach($walletTrans as $transaction)
                      <tr style="color:{{ $transaction->amount > 0 ? 'green' : 'red'}}">
                          <td>{{ $i++ }}</td>
                          <td>{{ $transaction->created_at }}</td>
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
