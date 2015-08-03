@extends('layout')

@section('content')
<div class="container">
	<div class="row">
		<!-- search bar -->
		<div class="col-md-4">
			<form id="search_form" role="search">
				<div class="input-group">
					<div class="input-group-btn">
						<button id="search_option" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
							User Name <span class="caret"></span>
						</button>
						<ul id="search_option_list" class="dropdown-menu" role="menu">
							<li><a href="#">User ID</a></li>
							<li><a href="#">User Name</a></li>
							<li><a href="#">Group</a></li>
						</ul>
					</div>
					<div>
						<input id="search_input" name="key_word" type="text" class="form-control" placeholder="search">
					</div>
					<div id="search_button" class="input-group-btn">
						<button class="btn btn-warning" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-2">
			<a id="add_user_button" data-toggle="modal" href="#" class="btn btn-info">Add Acount</a>
		</div>
	</div>
	<br/>
	<!-- users table -->
	<table class="table table-bordered table-hover table-condensed table-responsive">
		<thead>
			<th style="width:5em;" id="th_1">ID<span class="glyphicon glyphicon-chevron-down"></span></th>
			<th style="width:40em;" id="th_2">User Name<span></span></th>
			<th style="width:10em;" id="th_3">Group<span></span></th>
			<th style="width:40em;" id="th_4">Create Date<span></span></th>
		</thead>
		<tbody id="user_list">
			@include('usercontrol/usercontrol_content')
		</tbody>
	</table>
</div>
<script>
var field='user_id',
value='',
field_operator='<>',
orderby='user_id',
inc='ASC';
var mOptionField="User Name";

$('ul#search_option_list li a').click(function(){
	var mOption = $(this).text();
	mOptionField = mOption;
	$('#search_option').text(mOption+' ');
	$('#search_option').append('<span class="caret"></span>');
});

$('#search_form').submit(function(ev){
	value=$('#search_input').val();
	if(value.length===0) {
		field_operator = '<>';
	} else {
		field_operator = '=';
	}
	switch (mOptionField) {
		case "User ID":
		field="user_id";
		break;
		case "User Name":
		field="username";
		break;
		case "Group":
		field="group";
		break;
	}
	ajaxSender(field, value, field_operator, orderby, inc);
	ev.preventDefault();
});

var mOrderBy=new Array('user_id', 'username', 'group', 'create_date');
@for ($i = 1; $i < 5; $i++)
var bFlag_{{ $i }}=true;
$('#th_{{ $i }}').click(function(){
	$('thead span').hide().removeClass();
	if(bFlag_{{ $i }}) {
		bFlag_{{ $i }}=false;
		$('#th_{{ $i }} span').addClass("glyphicon glyphicon-chevron-down").show();
		orderby=mOrderBy[{{ $i-1 }}];
		inc='ASC';
		ajaxSender(field, value, field_operator, orderby, inc);
	} else {
		bFlag_{{ $i }}=true;
		$('#th_{{ $i }} span').addClass("glyphicon glyphicon-chevron-up").show();
		orderby=mOrderBy[{{ $i-1 }}];
		inc='DESC';
		ajaxSender(field, value, field_operator, orderby, inc);
	}
});
@endfor

// empty confirm button clicked and send ajax to remove all data of error_log table
$('#empty_confirm_button').click(function(){
	$.ajax({
		url: '/delele_errorlog',
		type: 'POST',
		cache: false,
		success:function(result){
			$('#delete_confirm').modal('hide');
			if (result=='Delete Successfully!') {
				$('#error_log_list').html("");
			} else {
				Alert(result);
			}
		},
		error:function(xhr,status,error) {
			alert(error);
		}
	});
});

function ajaxSender(field, value, field_operator, orderby, inc) {
	var mData = {
		'field': field,
		'value': value,
		'field_operator': field_operator,
		'orderby': orderby,
		'inc': inc
	};
	sendAjax('/setting',mData,function(result){
		$('#user_list').html(result).hide().fadeIn('fast');
	});
}
</script>
@include('usercontrol/usercontrol_modal')
@stop