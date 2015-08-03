<!-- Modal -->
<div class="modal fade" id="client_editor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Client</h4>
      </div>
      <div id="editor_client_modal_body" class="modal-body">
        <div id="edit_client_info">
        </div>
        <form role="form">
          <div class="form-group">
            <label for="edit_mandant_id_input_client">Belong to Mandant(ID):</label>
            <input type="text" class="form-control" id="edit_mandant_id_input_client" placeholder="Belong to Mandant(ID)">
          </div>
          <div class="form-group">
            <label for="edit_sort_input_client">Client Sort: </label>
            <select id="edit_sort_input_client" class="form-control">
              <option value="device">Device</option>
              <option value="client">Client</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edit_id_input_client">Client ID: </label>
            <input type="text" class="form-control" id="edit_id_input_client" placeholder="Client ID">
          </div>
          <div class="form-group">
            <label for="edit_login_input_client">Client Name: </label>
            <input type="text" class="form-control" id="edit_login_input_client" placeholder="Client Name">
          </div>
          <div class="form-group">
            <label for="edit_password_input_client">Password: </label>
            <input type="text" class="form-control" id="edit_password_input_client" placeholder="Password (keep empty means not change)">
          </div>
        </form>
        <div id="edit_client_Error_Message" class="alert alert-danger">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="edit_client_confirm" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="client_deleter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delete Client</h4>
      </div>
      <div class="modal-body">
        <div id="del_client_info">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button id="del_client_confirm" type="button" class="btn btn-primary">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="client_activator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Activate Client</h4>
      </div>
      <div class="modal-body">
        <div id="activ_client_info">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button id="activ_client_confirm" type="button" class="btn btn-primary">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="client_adder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Client</h4>
      </div>
      <div id="adder_client_modal_body" class="modal-body">
        <h4>Add a new Client</h4>
        <form role="form">
          <div class="form-group">
            <label for="add_mandant_id_input_client">Belong to Mandant(ID):</label>
            <input type="text" class="form-control" id="add_mandant_id_input_client" placeholder="Belong to Mandant(ID)">
          </div>
          <div class="form-group">
            <label for="add_sort_input_client">Client Sort: </label>
            <select id="add_sort_input_client" class="form-control">
              <option value="device">Device</option>
              <option value="client">Client</option>
            </select>
          </div>
          <div class="form-group">
            <label for="add_id_input_client">Client ID: </label>
            <input type="text" class="form-control" id="add_id_input_client" placeholder="Client ID">
          </div>
          <div class="form-group">
            <label for="add_login_input_client">Client Name: </label>
            <input type="text" class="form-control" id="add_login_input_client" placeholder="Client Name">
          </div>
          <div class="form-group">
            <label for="add_password_input_client">Password: </label>
            <input type="text" class="form-control" id="add_password_input_client" placeholder="Password">
          </div>
        </form>
        <div id="add_client_Error_Message" class="alert alert-danger">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button id="add_client_confirm" type="button" class="btn btn-primary">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(document).ready(function(){
  $('#client_adder').on('show.bs.modal',function(e){
    $('#adder_client_modal_body').css('height','auto');
  });
  $('#client_editor').on('show.bs.modal',function(e){
    $('#editor_client_modal_body').css('height','auto');
  });
  $('#add_client_confirm').click(function(){
    var mMandant_id=$('#add_mandant_id_input_client').val();
    var mLogin=$('#add_login_input_client').val();
    var mPassword=$('#add_password_input_client').val();
    var mClientID=$('#add_id_input_client').val();
    var mSort=$('#add_sort_input_client').val();
    var mOperator='<>',mID='0';
    if (mLogin==""){
      add_client_error_animation("Client Name can not empty!");
    } else if (mMandant_id=="") {
      add_client_error_animation("Mandant ID can not empty!");
    } else if (mPassword=="") {
      add_client_error_animation("Password can not empty!");
    } else if (mClientID=="") {
      add_client_error_animation("Client ID can not empty!");
    } else if (mSort=="") {
      add_client_error_animation("Client Sort can not empty!");
    } else {
      if($(add_mandant_id_input_client).prop('disabled')) {
        mOperator='=';
        mID=mMandant_id;
      }
      $(this).prop("disabled",true);
      $.ajax({
        url:"/add_client", 
        type:"POST", 
        data: {
          mandant_id: mMandant_id,
          client_id: mClientID,
          client_sort: mSort,
          client_login: mLogin,
          client_password: mPassword,
          operator: mOperator,
          id: mID,
        },
        success:function(result) {
          if(result.substring(0,5)==='Error') {
            add_client_error_animation(result);
          } else {
            $("#client_list_group").html(result);
            $('#client_adder').modal('hide');
          }
          $('#add_client_confirm').prop("disabled",false);
        },
        error:function(xhr,status,error){
          alert(error);
          $('#client_adder').modal('hide');
        } 
      });
    }
  });
  $('#del_client_confirm').click(function(){
    $(this).prop("disabled",true);
    var mID=$('#del_client_id_em').text();
    $.ajax({
      url:"/del_client_id", 
      type:"POST", 
      data: {id: mID}, 
      success:function() {
        $("#client_list_"+mID).remove();
        $('#client_deleter').modal('hide');
        $('#del_client_confirm').prop("disabled",false);
      },
      error:function(xhr,status,error){
        alert(error);
        $('#client_deleter').modal('hide');
      } 
    });
  });
  $('#activ_client_confirm').click(function(){
    var mID=$('#activ_client_id_em').text();
    $(this).prop("disabled",true);
    $.ajax({
      url:"/activ_client_id", 
      type:"POST", 
      data: {id: mID},
      success:function() {
        $("#client_list_"+mID).remove();
        $('#client_activator').modal('hide');
        $('#del_client_confirm').prop("disabled",false);
      },
      error:function(xhr,status,error){
        alert(error);
        $('#client_activator').modal('hide');
      } 
    });
  });
  $('#edit_client_confirm').click(function(){
    var mID=$('#edit_client_id_em').text();
    var mMandant_id=$('#edit_mandant_id_input_client').val();
    var mLogin=$('#edit_login_input_client').val();
    var mPassword=$('#edit_password_input_client').val();
    var mClientID=$('#edit_id_input_client').val();
    var mSort=$('#edit_sort_input_client').val();
    if (mMandant_id=="") {
      edit_client_error_animation("Mandant ID can not empty!");
    } else if (mLogin=="") {
      edit_client_error_animation("Client Name can not empty!");
    } else if (mClientID=="") {
      edit_client_error_animation("Client ID can not empty!");
    } else if (mSort=="") {
      edit_client_error_animation("Client Sort can not empty!");
    } else {
      $(this).prop("disabled",true);
      $.ajax({
        url:"/edit_client", 
        type:"POST", 
        data: {
          id: mID,
          mandant_id: mMandant_id,
          client_id: mClientID,
          client_sort: mSort,
          client_login: mLogin,
          client_password: mPassword,
        },
        success:function(result) {
          if(result.substring(0,5)==='Error') {
            edit_client_error_animation(result);
          } else {
            $("#client_list_"+mID).replaceWith(result);
            $('#client_editor').modal('hide');
          }
          $('#edit_client_confirm').prop("disabled",false);
        },
        error:function(xhr,status,error){
          alert(error);
          $('#client_editor').modal('hide');
        } 
      });
    }
  });
  function add_client_error_animation(result){
    var el=$('#adder_client_modal_body');
    var curHeight = el.height();
    $('#add_client_Error_Message').text(result).fadeIn();
    var autoHeight=el.css('height','auto').height();
    el.height(curHeight).animate({height: autoHeight}, 300);
  }
  function edit_client_error_animation(result){
    var el=$('#editor_client_modal_body');
    var curHeight = el.height();
    $('#edit_client_Error_Message').text(result).fadeIn('fast');
    var autoHeight=el.css('height','auto').height();
    el.height(curHeight).animate({height: autoHeight}, 300);
  }
});
</script>