<!-- delete confirm modal -->
<div class="modal fade" id="User_Modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<div id="modal_information">
				</div>
				<div id="error_information" class="alert alert-danger">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="confirm_button">OK</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$('#error_information').hide();
var user_id, username, group, create_date;
$('tbody').on('mouseenter','tr', function() {
	if(!(parseInt($(this).children('#user_id').text())==parseInt("{{ $user['userid'] }}"))){
		$(this).children('#delete_button').css('visibility', 'visible');
	}
});
$('tbody').on('mouseleave','tr', function(){
	$(this).children('#delete_button').css('visibility', 'hidden');
});
$("tbody").on('click',"a[href='#delete']", function(){
	user_id = $(this).parent('#delete_button').siblings('#user_id').text();
	username = $(this).parent('#delete_button').siblings('#user_name').text();
	group = $(this).parent('#delete_button').siblings('#user_group').text();
	create_date = $(this).parent('#delete_button').siblings('#create_date').text();
	$('.modal-title').text('Delete Confirm');
	$('#modal_information').html(
		"<p>Are you sure to delete this user?</p>"+
		"<p><b>User ID: </b>"+user_id+"</p>"+
		"<p><b>User Name: </b>"+username+"</p>"+
		"<p><b>Group: </b>"+group+"</p>"+
		"<p><b>Create Date: </b>"+create_date+"</p>"
	);
	$('#confirm_button').text('Delete');
	$('#User_Modal').modal();
});
$('tbody').on("click",'#user_id, #user_name, #user_group, #create_date', function(){
	user_id = $(this).parent().children('#user_id').text();
	username = $(this).parent().children('#user_name').text();
	group = $(this).parent().children('#user_group').text();
	create_date = $(this).parent().children('#create_date').text();
	$('.modal-title').text('Edit User');
	$('#modal_information').html(
		"<h4><b>Original Information: </b></h4>"+
		"<p><b>User ID: </b>"+user_id+"</p>"+
		"<p><b>User Name: </b>"+username+"</p>"+
		"<p><b>Group: </b>"+group+"</p>"+
		"<p><b>Create Date: </b>"+create_date+"</p>"+
		"<hr/>"+
		"<h4><b>Edit User: </b></h4>"+
		"<form role=\"form\">"+
          "<div class=\"form-group\">"+
            "<label for=\"username_input\">Username:</label>"+
            "<input type=\"text\" class=\"form-control\" id=\"username_input\" value=\""+username.replace(/(\r\n|\n|\r|\s)/gm,'')+"\" placeholder=\"Username\">"+
          "</div>"+
          "<div class=\"form-group\">"+
            "<label for=\"password_input\">Password:</label>"+
            "<input type=\"text\" class=\"form-control\" id=\"password_input\" placeholder=\"Password (empty means not change)\">"+
          "</div>"+
          "<div class=\"form-group\">"+
            "<label for=\"group_input\">Group: </label>"+
            "<select id=\"group_input\" class=\"form-control\">"+
				"<option>admins</option>"+
				"<option>users</option>"+
			"</select>"+
          "</div>"+
        "</form>"
	);
	$('#confirm_button').text('Edit');
	$('#User_Modal').modal();
});
$('#add_user_button').click(function(){
	$('.modal-title').text('Add User');
	$('#modal_information').html(
		"<p>Add a new user</p>"+
		"<form role=\"form\">"+
          "<div class=\"form-group\">"+
            "<label for=\"username_input\">Username:</label>"+
            "<input type=\"text\" class=\"form-control\" id=\"username_input\" placeholder=\"Username\">"+
          "</div>"+
          "<div class=\"form-group\">"+
            "<label for=\"password_input\">Password:</label>"+
            "<input type=\"text\" class=\"form-control\" id=\"password_input\" placeholder=\"Password\">"+
          "</div>"+
          "<div class=\"form-group\">"+
            "<label for=\"group_input\">Group: </label>"+
            "<select id=\"group_input\" class=\"form-control\">"+
				"<option>admins</option>"+
				"<option>users</option>"+
			"</select>"+
          "</div>"+
        "</form>"
	);
	$('#confirm_button').text('Add');
	$('#User_Modal').modal();
});
$('#confirm_button').click(function(){
	$('#error_information').text("").hide();
	$(this).prop("disabled",true);
	if($(this).text()==='Delete') {
		var mData = {
			user_id: user_id.replace(/(\r\n|\n|\r|\s)/gm,''),
			username: username.replace(/(\r\n|\n|\r|\s)/gm,''),
			group: group.replace(/(\r\n|\n|\r|\s)/gm,'')
		};
		controlAction('/del_user', mData);
	} else if($(this).text()==='Edit') {
		var mData = {
			user_id: user_id.replace(/(\r\n|\n|\r|\s)/gm,""),
			username: $('#username_input').val(),
			password: $('#password_input').val(),
			group: $('#group_input').val()
		};
		if(parseInt(user_id)==parseInt("{{ $user['userid'] }}")){
			sendAjax('/edit_user', mData, function(result) {
				$('#confirm_button').prop("disabled",false);
				if(result==='Success') {
					window.location.href = "/logout";
				} else {
					$('#error_information').text(result).fadeIn('slow');
				}
			});
		} else {
			controlAction('/edit_user', mData);
		}
	} else if($(this).text()==='Add') {
		var mData = {
			username: $('#username_input').val(),
			password: $('#password_input').val(),
			group: $('#group_input').val()
		};
		controlAction('/add_user', mData);
	}
});
$('#User_Modal').on('hidden.bs.modal', function () {
	$('#error_information').text("").hide();
})
function controlAction(url, mData) {
	sendAjax(url, mData, function(result) {
		$('#confirm_button').prop("disabled",false);
		if(result==='Success') {
			ajaxSender(field, value, field_operator, orderby, inc);
			$('#User_Modal').modal('hide');
		} else {
			$('#error_information').text(result).fadeIn('slow');
		}		
	});
}
</script>