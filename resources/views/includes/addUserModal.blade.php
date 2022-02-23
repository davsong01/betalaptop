{{-- <div id="{{ $mat->id.'l'.$value}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 <form action="">
    <br>@php
            $downline = \App\User::downline($user);
    @endphp 
    <input type="hidden" name="position" value="{{ $mat->id }}">
    <input type="hidden" name="side" value="{{ 'right' }}">
    <input type="hidden" name="inner" value="{{ $value }}">
</form>
 </div>
 --}}
<div id="modal-{{ $mat->id.'r'.$value}}" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      
      </div>
      <div class="modal-body" style="text-align:left">
          <h6 class="modal-title"><b>Fill Position for Level {{ $mat['position'] }}, Right {{ $value }}</b></h6>
          <p>Some text in the modal.</p>
          <form action="">
          <input type="hidden" name="position" value="{{ $mat->id }}">
          <input type="hidden" name="side" value="{{ 'right' }}">
          <input type="hidden" name="inner" value="{{ $value }}">
      </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>

  </div>
</div>
<div id="modal-{{ $mat->id.'l'.$value}}" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      
      </div>
      <div class="modal-body" style="text-align:left">
          <h6 class="modal-title"><b>Fill Position for Level {{ $mat['position'] }}, Left {{ $value }}</b></h6>
          <p>Some text in the modal.</p>
          <form action="">
          <input type="hidden" name="position" value="{{ $mat->id }}">
          <input type="hidden" name="side" value="{{ 'right' }}">
          <input type="hidden" name="inner" value="{{ $value }}">
      </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div>

  </div>
</div>

{{-- <div id="{{ $mat->id.'r'.$value}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
        <form action="">
        
        <input type="hidden" name="position" value="{{ $mat->id }}">
        <input type="hidden" name="side" value="{{ 'right' }}">
        <input type="hidden" name="inner" value="{{ $value }}">
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="{{ $mat->id.'l'.$value}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
        <form action="">
        
        <input type="hidden" name="position" value="{{ $mat->id }}">
        <input type="hidden" name="side" value="{{ 'left' }}">
        <input type="hidden" name="inner" value="{{ $value }}">
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> --}}

