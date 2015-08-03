<!-- Modal -->
<div class="modal fade" id="mandant_information" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Mandant Information ID <em id="em_mandant_id"></em></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Client List</h3>
              </div>
              <!-- List group -->
              <div id="client_list_group" class="list-group">
                <!-- Client List -->
              </div>
              <div class="panel-body">
                <button id="add_client_button_mandant" data-toggle="modal" data-target="#client_adder" type="button" class="btn btn-primary">Add New Client</button>
              </div>
            </div>
          </div>
          <script>
          $('#add_client_button_mandant').click(function(){
            $('#add_mandant_id_input_client').val($('#em_mandant_id').text());
            $('#add_login_input_client').val("");
            $('#add_password_input_client').val("");
            $('#add_client_Error_Message').text("").hide();
          });
          </script>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="edit_mandant_button" type="button" class="btn btn-primary">Edit this Mandant</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="mandant_editor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Mandant</h4>
      </div>
      <div id="editor_modal_body" class="modal-body">
        <div id="edit_mandant_info">
        </div>
        <form role="form">
          <div class="form-group">
            <label for="edit_username_input">Superuser:</label>
            <input type="text" class="form-control" id="edit_username_input" placeholder="Superuser">
          </div>
          <div class="form-group">
            <label for="edit_password_input">Password:</label>
            <input type="password" class="form-control" id="edit_password_input" placeholder="Password (keep empty means not change)">
          </div>
          <div class="form-group">
            <label for="edit_company_input">Company Name:</label>
            <input type="text" class="form-control" id="edit_company_input" placeholder="Company Name">
          </div>
          <div class="form-group">
            <label for="edit_address_input">Address: </label>
            <textarea rows="6" class="form-control" id="edit_address_input" placeholder="Address"></textarea>
          </div>
          <div class="form-group">
            <label for="edit_contact_input">E-Mail: </label>
            <input type="email" class="form-control" id="edit_contact_input" placeholder="E-Mail">
          </div>
        </form>
        <div id="edit_mandant_information_blcok" class="alert alert-danger">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="edit_mandant_confirm" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="mandant_activator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Activate Mandant</h4>
      </div>
      <div class="modal-body">
        <div id="activ_mandant_info">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button id="activ_mandant_confirm" type="button" class="btn btn-primary">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="mandant_deleter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delete Mandant</h4>
      </div>
      <div class="modal-body">
        <div id="del_mandant_info">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button id="del_mandant_confirm" type="button" class="btn btn-primary">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="mandant_adder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Mandant</h4>
      </div>
      <div id="adder_modal_body" class="modal-body">
        <h4>Add a new Mandant</h4>
        <form role="form">
          <div class="form-group">
            <label for="add_username_input">Superuser:</label>
            <input type="text" class="form-control" id="add_username_input" placeholder="Superuser">
          </div>
          <div class="form-group">
            <label for="add_password_input">Password:</label>
            <input type="password" class="form-control" id="add_password_input" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="add_company_input">Company Name:</label>
            <input type="text" class="form-control" id="add_company_input" placeholder="Company Name">
          </div>
          <div class="form-group">
            <label for="add_address_input">Address: </label>
            <textarea rows="6" class="form-control" id="add_address_input" placeholder="Address"></textarea>
          </div>
          <div class="form-group">
            <label for="add_contact_input">E-Mail: </label>
            <input type="email" class="form-control" id="add_contact_input" placeholder="E-Mail">
          </div>
        </form>
        <div id="add_mandant_information_blcok" class="alert alert-danger">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button id="add_mandant_confirm" type="button" class="btn btn-primary">OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(document).ready(function(){
  // resize the panel in mandant
  var mListHeight = $(window).height() - 270;
  $('#client_list_group, #device_list_group').css({
    "max-height": mListHeight-110 + 'px'
  });
  $(window).resize(function(event) {
    var mListHeight = $(window).height() - 270;
    $('#client_list_group, #device_list_group').css({
      "max-height": mListHeight-110 + 'px'
    });
  });
  $('#mandant_adder').on('show.bs.modal',function(e){
    $('#add_mandant_information_blcok').text("").hide();
    $('#adder_modal_body').css('height','auto');
  });
  $('#mandant_editor').on('show.bs.modal',function(e){
    $('#edit_mandant_information_blcok').text("").hide();
    $('#editor_modal_body').css('height','auto');
  });
  $('#add_mandant_confirm').click(function(){
    $(this).prop("disabled",true);
    var mUsername=$('#add_username_input').val();
    var mPassword=$('#add_password_input').val();
    var mCompany=$('#add_company_input').val();
    var mAddress=$('#add_address_input').val();
    var mContact=$('#add_contact_input').val();
    if(mUsername=="") {
      add_error_animation("Superuser can not be empty!");
    } else if(mPassword=="") {
      add_error_animation("Password can not be empty!");
    } else if(mCompany=="") {
      add_error_animation("Company Name can not be empty!");
    } else {
      $.ajax({
        url:"/add_mandant", 
        type:"POST", 
        data:"username="+mUsername+"&password="+mPassword+"&company="+mCompany+"&address="+mAddress+"&contact="+mContact,
        success:function(result) {
          if(result.substring(0,5)=="Error") {
            add_error_animation(result);
          } else {
            $('#add_username_input').val("");
            $('#add_password_input').val("");
            $('#add_company_input').val("");
            $('#add_address_input').val("");
            $('#add_contact_input').val("");
            $("#mandant_list_group").html(result);
            $('#mandant_adder').modal('hide');
            $('#add_mandant_confirm').prop("disabled",false);          
          }
        }
      });      
    }
  });
  $('#del_mandant_confirm').click(function(){
    $(this).prop("disabled",true);
    var mID=$('#del_mandant_id_em').text();
    $.ajax({
      url:"/del_mandant_id", 
      type:"POST", 
      data:"id="+mID, 
      success:function() {
        $("#mandant_list_"+mID+"1").remove();
        $('#mandant_deleter').modal('hide');
        $('#del_mandant_confirm').prop("disabled",false);
      }});
  });
  $('#activ_mandant_confirm').click(function(){
    $(this).prop("disabled",true);
    var mID=$('#activ_mandant_id_em').text();
    $.ajax({
      url:"/activ_mandant_id", 
      type:"POST", 
      data:"id="+mID, 
      success:function() {
        $("#mandant_list_"+mID+"1").remove();
        $('#mandant_activator').modal('hide');
        $('#activ_mandant_confirm').prop("disabled",false);
      }});
  });
  $('#edit_mandant_confirm').click(function(){
    $(this).prop("disabled",true);
    var mID=$('#edit_mandant_id_em').text();
    var mUsername=$('#edit_username_input').val();
    var mPassword=$('#edit_password_input').val();
    var mCompany=$('#edit_company_input').val();
    var mAddress=$('#edit_address_input').val();
    var mContact=$('#edit_contact_input').val();
    if(mUsername=="") {
      edit_error_animation("Superuser can not be empty!");
    } else if(mCompany=="") {
      edit_error_animation("Company Name can not be empty!");
    } else {    
      $.ajax({
        url:"/edit_mandant", 
        type:"POST", 
        data:"id="+mID+"&username="+mUsername+"&password="+mPassword+"&company="+mCompany+"&address="+mAddress+"&contact="+mContact,
        success:function(result) {
          if(result.substring(0,5)=="Error") {
            edit_error_animation(result);
          } else {
            $('#edit_username_input').val("");
            $('#edit_password_input').val("");
            $('#edit_company_input').val("");
            $('#edit_address_input').val("");
            $('#edit_contact_input').val("");
            $("#mandant_list_"+mID+"1").replaceWith(result);
            $('#mandant_editor').modal('hide');
          }
          $('#edit_mandant_confirm').prop("disabled",false);
        }
      });
    }
  });
  $('#edit_mandant_button').click(function(){
    $('#mandant_information').modal('hide');
    $('#mandant_editor').modal();
  });
  function add_error_animation(result){
    var el=$('#adder_modal_body');
    var curHeight = el.height();
    $('#add_mandant_information_blcok').text(result).fadeIn();
    var autoHeight=el.css('height','auto').height();
    el.height(curHeight).animate({height: autoHeight}, 300);
    $('#add_mandant_confirm').prop("disabled",false);
  }
  function edit_error_animation(result){
    var el=$('#editor_modal_body');
    var curHeight = el.height();
    $('#edit_mandant_information_blcok').text(result).fadeIn();
    var autoHeight=el.css('height','auto').height();
    el.height(curHeight).animate({height: autoHeight}, 300);    
  }
});
</script>