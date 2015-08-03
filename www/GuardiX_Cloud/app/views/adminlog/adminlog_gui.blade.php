@extends('layout')

@section('content')
<!-- delete confirm modal -->
<div class="modal fade" id="delete_confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Empty Confirm</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure to empty all admin logs?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="empty_confirm_button">Empty</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container">
	<div id="toolbar">
		<div class="row">
			<!-- search bar -->
			<div class="col-md-4">
				<form id="search_form" role="search">
					<div class="input-group">
						<div class="input-group-btn">
							<button id="search_option" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
								User <span class="caret"></span>
							</button>
							<ul id="search_option_list" class="dropdown-menu" role="menu">
								<li><a href="#">Log Number</a></li>
								<li><a href="#">User</a></li>
								<li><a href="#">User ID</a></li>
								<li><a href="#">IP Address</a></li>
								<li><a href="#">Action</a></li>
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
			<div class="col-md-8">
				<form id="search_form_date" role="search" class="form-inline">
					<div class="input-group">
						<span class="input-group-addon">Date from</span>
						<input type="datetime-local" class="form-control" id="search_date_input_1" placeholder=""> 
						<span class="input-group-addon">to</span>
						<input type="datetime-local" class="form-control" id="search_date_input_2" placeholder="">
						<div id="search_button" class="input-group-btn">
							<button class="btn btn-warning" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						</div>
					</div>
				</form>
			</div><!-- search bar end -->
		</div>
	</div>
	<hr/>
	<!-- event log table -->
	<table class="table table-bordered table-hover table-condensed table-responsive fixed_headers">
		<thead>
			<tr>
				<th id="th_1">Log Number<span class="glyphicon glyphicon-chevron-down"></span></th>
				<th id="th_2">User<span></span></th>
				<th id="th_3">User ID<span></span></th>
				<th id="th_4">IP Address<span></span></th>
				<th id="th_5">Action<span></span></th>
				<th id="th_6">Date<span></span></th>
			</tr>
		</thead>
		<tbody id="admin_log_list">
			@include('adminlog/adminlog_gui_content')
		</tbody>
	</table>
<!--	<div class="modal-footer">
                     <button id="previous_page" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <
                     </button>
		     <button id="next_page" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    >
        </button>
                     </div>-->

</div>
<script>
// resize the table


setTableWidth();
//$('#previous_page').prop("disabled",true);
var mTableHeight = $(window).height() - 310;
$('#admin_log_list').css({
  "max-height": mTableHeight + 'px'
});
$(window).resize(function(event) {
	var mTableHeight = $(window).height() - 310;
	$('#admin_log_list').css({
	  "max-height": mTableHeight + 'px'
	});
});
$('#right_navbar').prepend("<li><a href='/get_adminlog_csv'>Generate CSV File</a></li><li><a data-toggle='modal' href='#delete_confirm'>Empty Table</a></li>");

var field='log_nr',
value='',
field_operator='<>',
bDateFlag='true',
date_type='date',
datebegin=getDate(-10),
dateend=getDate(0),
orderby='date',
inc='DESC';
var skip=0;


var mOptionField="User";


$('ul#search_option_list li a').click(function(){
	var mOption = $(this).text();
	mOptionField = mOption;
	$('#search_option').text(mOption+' ');
	$('#search_option').append('<span class="caret"></span>');
});

$('#search_form, #search_form_date').submit(function(ev){
	date_type="date";
	if($('#search_date_input_1').val()!=""){
		datebegin=$('#search_date_input_1').val();
		bDateFlag='true';
	} else {
		datebegin=getDate(-10);
	}
	if($('#search_date_input_2').val()!=""){
		dateend=$('#search_date_input_2').val();
		bDateFlag='true';
	} else {
		dateend=getDate(0);
	}
	if(($('#search_date_input_2').val()=="")&&($('#search_date_input_1').val()=="")) {
		bDateFlag='false';
	}
	switch (mOptionField) {
		case "Log Number":
		field="log_nr";
		break;
		case "User":
		field="username";
		break;
		case "User ID":
		field="actor_id";
		break;
		case "IP Address":
		field="ip";
		break;
		case "Action":
		field="action";
		break;
	}
	value=$('#search_input').val();
	if(value.length===0) {
		field_operator = '<>';
	} else {
		field_operator = '=';
		if(field==='action') {
			field_operator='like';
			value='%'+value+'%';
		}
	}
	ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc,skip);
	ev.preventDefault();
});

var mOrderBy=new Array('log_nr','username' ,'actor_id', 'ip', 'action', 'date');
@for ($i = 1; $i < 7; $i++)
var bFlag_{{ $i }}=true;
$('#th_{{ $i }}').click(function(){
	$('thead span').hide().removeClass();
	if(bFlag_{{ $i }}) {
		bFlag_{{ $i }}=false;
		$('#th_{{ $i }} span').addClass("glyphicon glyphicon-chevron-down").show();
		orderby=mOrderBy[{{ $i-1 }}];
		inc='ASC';
		ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc,skip);
	} else {
		bFlag_{{ $i }}=true;
		$('#th_{{ $i }} span').addClass("glyphicon glyphicon-chevron-up").show();
		orderby=mOrderBy[{{ $i-1 }}];
		inc='DESC';
		ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc,skip);
	}
});
@endfor

/*$('#previous_page').click(function(){
	if(skip>0)	
	{	skip-=20;	
		ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc,skip);
		
	}
	sendAjax('/adminlog_search', mData, function(result){
                $('#admin_log_list').html(result).hide().fadeIn('fast');
                setTableWidth();    
	else{
		$(this).prop("disabled",true);
	}
	
		
});


$('#next_page').click(function(){
        
	skip+=20;
        ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc,skip);
});
*/

function setTableWidth() {
	var scrollWidth = getScrollbarWidth();
	var tableWidth= $('.fixed_headers').width()-scrollWidth;
	if($('.fixed_headers tbody').hasScrollBar()) {
		$('.fixed_headers thead tr').width(tableWidth+'px');
	} else {
		$('.fixed_headers thead tr').width(tableWidth+scrollWidth+'px');
	}
	var width1 = Math.round(tableWidth*0.12)+'px';
	var width2 = Math.round(tableWidth*0.12)+'px';
	var width3 = Math.round(tableWidth*0.1)+'px';
	var width4 = Math.round(tableWidth*0.1)+'px';
	var width5 = Math.round(tableWidth*0.4)+'px';
	var width6 = Math.round(tableWidth*0.16)+'px';
	$('th:nth-child(1), td:nth-child(1)').width(width1);
	$('th:nth-child(2), td:nth-child(2)').width(width2);
	$('th:nth-child(3), td:nth-child(3)').width(width3);
	$('th:nth-child(4), td:nth-child(4)').width(width4);
	$('th:nth-child(5), td:nth-child(5)').width(width5);
	$('th:nth-child(6), td:nth-child(6)').width(width6);
}

// empty confirm button clicked and send ajax to remove all data of admin_log table
$('#empty_confirm_button').click(function(){
	sendAjax('/delete_adminlog','',function(result){
		$('#delete_confirm').modal('hide');
		if (result=='Delete Successfully!') {
			$('#admin_log_list').html("");
		} else {
			Alert(result);
		}		
	});
});

function ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc,skip) {
	var mData = {
		'field': field,
		'value': value,
		'field_operator': field_operator,
		'bDateFlag' : bDateFlag,
		'date_type' : date_type,
		'datebegin': datebegin,
		'dateend': dateend,
		'orderby': orderby,
		'inc': inc,
		'skip': skip
	};
	sendAjax('/adminlog_search', mData, function(result){
		$('#admin_log_list').html(result).hide().fadeIn('fast');
		setTableWidth();		
});
}
</script>
@stop
