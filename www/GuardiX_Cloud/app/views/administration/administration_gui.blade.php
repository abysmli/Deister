@extends('layout')
{{-- content section --}}
@section('content')
<div class="container">
  <div class="row">
    <!-- left menu -->
    <div class="col-md-3">
      <ul class="nav nav-pills nav-stacked">
        <li class="active" id="mandant_panel_button"><a href="#mandant-controll">Mandant Control</a></li>
        <li id="client_panel_button"><a href="#client-controll">Client Control</a></li>
      </ul>
    </div>
    <!-- mandant panel at the first time display this page -->
    <div id="lists_block" class="col-md-9">
      @include('mandant/mandant')
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  var mData={activ:'1'};
  // get mandant panel by using ajax to send post request to backend
  $('a[href$="#mandant-controll"]').click(function(){
    sendAjax('/get_mandantPanel',mData,function(result){
      $('#lists_block').html(result);
      $('#mandant_panel').hide().fadeIn('fast');
      $('#client_panel_button').removeClass('active');
      $('#mandant_panel_button').addClass('active');      
    });
  });
  // get client panel by using ajax to send post request to backend
  $('a[href$="#client-controll"]').click(function(){
    sendAjax('/get_clientPanel',mData,function(result){
      $('#lists_block').html(result);
      $('#client_panel').hide();
      $('#client_panel').fadeIn('fast');
      $('#client_panel_button').addClass('active');
      $('#mandant_panel_button').removeClass('active');
    });
  });
});
</script>
{{-- get mandant modal widgets --}}
@include('mandant/mandant_modal')
{{-- get client modal widgets --}}
@include('client/client_modal')
{{-- end of template --}}
@stop