@foreach($mandants as $mandant)
<a id="mandant_list_{{ $mandant->mandant_id . $mandant->user_id }}" href="#" class="list-group-item">
  <div id="mandant_block_{{ $mandant->mandant_id . $mandant->user_id }}" class="mandant_block">
    <p><b>{{ $mandant->mandant_firmname }}</b><em>(ID:{{ $mandant->mandant_id}})</em>
    @if ($active!=='1') 
    -- Deactived
    @endif
    </p>
    @if ($active!=='1') 
    <span id="mandant_active_button_{{ $mandant->mandant_id . $mandant->user_id }}" class="glyphicon glyphicon-ok pull-right">
    </span>
    @else
    <span id="mandant_deleter_button_{{ $mandant->mandant_id . $mandant->user_id }}" class="glyphicon glyphicon-trash pull-right">
    </span>
    @endif
  </div>
  <script>
  $(document).ready(function(){
    @if ($active!=='1')
    $('.mandant_block span').hide();
    $('#mandant_list_{{ $mandant->mandant_id . $mandant->user_id }}').hover(function(){
      $('#mandant_active_button_{{ $mandant->mandant_id . $mandant->user_id }}').show();}
      ,function(){
        $('#mandant_active_button_{{ $mandant->mandant_id . $mandant->user_id }}').hide();
      });
    $('#mandant_active_button_{{ $mandant->mandant_id . $mandant->user_id }}').click(function(){
      var datetime = new Date("{{ $mandant->date_insert }}");
      $('#activ_mandant_info').html(
        "<p>Are you sure to reactivate Mandant <b>{{ $mandant->mandant_firmname }}</b> (ID:<em id=\"activ_mandant_id_em\">{{ $mandant->mandant_id }}</em>)?</p>"+
        "<p><b>Infomation:</b></p>"+
        "<p>Mandant ID: <em>{{ $mandant->mandant_id }}</em></p>"+
        "<p>Mandant Superuser: <em>{{ $mandant->username }}</em></p>"+
        "<p>Mandant Password: <em>{{ $mandant->password }}</em></p>"+
        "<p>Mandant Company: <em>{{ $mandant->mandant_firmname }}</em></p>"+
        "<p>Mandant Address: <em>{{ $mandant->mandant_address }}</em></p>"+
        "<p>Mandant E-Mail: <em>{{ $mandant->mandant_contact }}</em></p>"+
        "<p>Mandant Insert Date: <em>"+datetime.toLocaleString()+"</em></p>"
        );
      $('#mandant_activator').modal();
    });
    @else
    $('.mandant_block span').hide();
    $('#mandant_list_{{ $mandant->mandant_id . $mandant->user_id }}').hover(function(){
      $('#mandant_deleter_button_{{ $mandant->mandant_id . $mandant->user_id }}').show();}
      ,function(){
        $('#mandant_deleter_button_{{ $mandant->mandant_id . $mandant->user_id }}').hide();
      });
    $('#mandant_deleter_button_{{ $mandant->mandant_id . $mandant->user_id }}').click(function(){
      var datetime = new Date("{{ $mandant->date_insert }}");
      $('#del_mandant_info').html(
        "<p>Are you sure to delete Mandant <b>{{ $mandant->mandant_firmname }}</b> (ID:<em id=\"del_mandant_id_em\">{{ $mandant->mandant_id }}</em>)?</p>"+
        "<p><b>Infomation:</b></p>"+
        "<p>Mandant ID: <em>{{ $mandant->mandant_id }}</em></p>"+
        "<p>Mandant Superuser: <em>{{ $mandant->username }}</em></p>"+
        "<p>Mandant Password: <em>{{ $mandant->password }}</em></p>"+
        "<p>Mandant Company: <em>{{ $mandant->mandant_firmname }}</em></p>"+
        "<p>Mandant Address: <em>{{ $mandant->mandant_address }}</em></p>"+
        "<p>Mandant E-Mail: <em>{{ $mandant->mandant_contact }}</em></p>"+
        "<p>Mandant Insert Date: <em>"+datetime.toLocaleString()+"</em></p>"
        );
      $('#mandant_deleter').modal();
    });
    @endif
    $('#mandant_block_{{ $mandant->mandant_id . $mandant->user_id }} p').click(function(){
      $('#em_mandant_id').text('{{ $mandant->mandant_id }}');
      var datetime = new Date("{{ $mandant->date_insert }}");
      $('#edit_mandant_info').html(
        "<p><b>Information of Mandant {{ $mandant->mandant_firmname }}</b> (ID:<em id=\"edit_mandant_id_em\">{{ $mandant->mandant_id }}</em>)</p>"+
        "<p>Mandant ID: <em>{{ $mandant->mandant_id }}</em></p>"+
        "<p>Mandant Superuser: <em>{{ $mandant->username }}</em></p>"+
        "<p>Mandant Password: <em>{{ $mandant->password }}</em></p>"+
        "<p>Mandant Company: <em>{{ $mandant->mandant_firmname }}</em></p>"+
        "<p>Mandant Address: <em>{{ $mandant->mandant_address }}</em></p>"+
        "<p>Mandant E-Mail: <em>{{ $mandant->mandant_contact }}</em></p>"+
        "<p>Mandant Insert Date: <em>"+datetime.toLocaleString()+"</em></p>"+
        "<hr/>"
        );
      $('#edit_username_input').val("{{ $mandant->username }}");
      $('#edit_company_input').val("{{ $mandant->mandant_firmname }}");
      $('#edit_address_input').val("{{ $mandant->mandant_address }}");
      $('#edit_contact_input').val("{{ $mandant->mandant_contact }}");
      $('#mandant_information').modal();
      var mData = {
        activ: '1',
        field: 'mandant_id',
        value: '{{ $mandant->mandant_id }}',
        operator: '=',
        skip: 0,
        take: 30
      };
      sendAjax('/get_clientList', mData, function(result){
        $('#client_list_group').html(result);
        $('#add_mandant_id_input_client').prop('disabled',true);
      });
    });
  });
  </script>
</a>
@endforeach


