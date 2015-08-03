@foreach($clients as $client)
<a id="client_list_{{ $client->client_id }}" href="#" class="list-group-item">
  <div id="client_block_{{ $client->client_id }}" class="client_block">
    <p>Client ID: <em>{{ $client->client_id}}</em> - Belong to Mandant: <em>{{ $client->mandant_id }}</em>
    @if ($active==='0') 
    -- Deactived
    @endif
    </p>
    @if ($active==='0') 
    <span id="client_active_button_{{ $client->client_id }}" class="glyphicon glyphicon-ok pull-right">
    </span>
    @else
    <span id="client_deleter_button_{{ $client->client_id }}" class="glyphicon glyphicon-trash pull-right">
    </span>
    @endif
  </div>
  <script>
  $(document).ready(function(){
    @if ($active==='0')
    $('.client_block span').hide();
    $('#client_list_{{ $client->client_id }}').hover(function(){
      $('#client_active_button_{{ $client->client_id }}').show();}
      ,function(){
        $('#client_active_button_{{ $client->client_id }}').hide();
      });
    $('#client_active_button_{{ $client->client_id }}').click(function(){
      var datetime = new Date("{{ $client->date_insert }}");
      $('#activ_client_info').html(
        "<p>Are you sure to reactivate Client <b>{{ $client->client_login }}</b> (ID:<em id=\"activ_client_id_em\">{{ $client->client_id }}</em>)?</p>"+
        "<p><b>Infomation:</b></p>"+
        "<p>Client Sort: <em>{{ $client->client_sort }}</em></p>"+
        "<p>Client ID: <em>{{ $client->client_id }}</em></p>"+
        "<p>Belong to Mandant(ID): <em>{{ $client->mandant_id }}</em>"+
        "<p>Client Name: <em>{{ $client->client_login }}</em></p>"+
        "<p>Client password: <em>{{ $client->password }}</em></p>"+
        "<p>Client Insert Date: <em>"+datetime.toLocaleString()+"</em></p>"
        );
      $('#client_activator').modal();
    });
    @else
    $('.client_block span').hide();
    $('#client_list_{{ $client->client_id }}').hover(function(){
      $('#client_deleter_button_{{ $client->client_id }}').show();}
      ,function(){
        $('#client_deleter_button_{{ $client->client_id }}').hide();
      });
    $('#client_deleter_button_{{ $client->client_id }}').click(function(){
      var datetime = new Date("{{ $client->date_insert }}");
      $('#del_client_info').html(
        "<p>Are you sure to delete Client <b>{{ $client->client_login }}</b> (ID:<em id=\"del_client_id_em\">{{ $client->client_id }}</em>)?</p>"+
        "<p><b>Infomation:</b></p>"+
        "<p>Client Sort: <em>{{ $client->client_sort }}</em></p>"+
        "<p>Client ID: <em>{{ $client->client_id }}</em></p>"+
        "<p>Belong to Mandant(ID): <em>{{ $client->mandant_id }}</em>"+
        "<p>Client Name: <em>{{ $client->client_login }}</em></p>"+
        "<p>Client password: <em>{{ $client->password }}</em></p>"+
        "<p>Client Insert Date: <em>"+datetime.toLocaleString()+"</em></p>"
        );
      $('#client_deleter').modal();
    });
    @endif
    $('#client_block_{{ $client->client_id }} p').click(function(){
      var datetime = new Date("{{ $client->date_insert }}");
      $('#edit_client_info').html(
        "<p><b>Information of Client {{ $client->client_firmname }}</b> (ID:<em id=\"edit_client_id_em\">{{ $client->client_id }}</em>)</p>"+
        "<p>Client Sort: <em>{{ $client->client_sort }}</em></p>"+
        "<p>Client ID: <em>{{ $client->client_id }}</em></p>"+
        "<p>Belong to Mandant(ID): <em>{{ $client->mandant_id }}</em>"+
        "<p>Client Name: <em>{{ $client->client_login }}</em></p>"+
        "<p>Client password: <em>{{ $client->client_password }}</em></p>"+
        "<p>Client Insert Date: <em>"+datetime.toLocaleString()+"</em></p>"+
        "<hr/>"
        );
      $('#edit_mandant_id_input_client').val("{{ $client->mandant_id }}");
      $('#edit_sort_input_client').val("{{ $client->client_sort }}");
      $('#edit_id_input_client').val("{{ $client->client_id }}");
      $('#edit_login_input_client').val("{{ $client->client_login }}");
      $('#edit_password_input_client').val("");
      $('#edit_client_Error_Message').text("").hide();
      $('#client_editor').modal();
    });
  });
  </script>
</a>
@endforeach

