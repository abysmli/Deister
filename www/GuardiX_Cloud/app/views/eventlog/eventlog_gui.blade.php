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
				<p>Are you sure to empty all event logs?</p>
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
								Message ID <span class="caret"></span>
							</button>
							<ul id="search_option_list" class="dropdown-menu" role="menu">
								<li><a href="#">Log Nr.</a></li>
								<li><a href="#">Message ID</a></li>
								<li><a href="#">Mandant</a></li>
								<li><a href="#">Device SN</a></li>
								<li><a href="#">Client ID</a></li>
								<li><a href="#">Client IP</a></li>
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
				<form class="form-inline" role="search" id="search_form_date">
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
				<th id="th_1">Log Nr.<span ></span></th>
				<th id="th_2">Message ID<span class="glyphicon glyphicon-chevron-down"></span></th>
				<th id="th_3">Mandant<span></span></th>
				<th id="th_4">Device SN<span></span></th>
				<th id="th_5">Client ID<span></span></th>
				<th id="th_6">Client IP<span></span></th>
				<th id="th_7">Action<span></span></th>
				<th id="th_8">Date<span></span></th>
			</tr>
		</thead>
		<tbody id="event_log_list">
			@include('eventlog/eventlog_gui_content')
		</tbody>
	</table><!-- event log table end-->
</div>
<pre id="test_block">
</pre>
<script>
setTableWidth();
var mTableHeight = $(window).height() - 310;
$('#event_log_list').css({
  "max-height": mTableHeight + 'px'
});
$(window).resize(function(event) {
	var mTableHeight = $(window).height() - 310;
	$('#event_log_list').css({
	  "max-height": mTableHeight + 'px'
	});
});
$('#right_navbar').prepend("<li><a href='/get_event_csv'>Generate CSV File</a></li><li><a data-toggle='modal' href='#delete_confirm'>Empty Table</a></li>");

// search conditions
var field='message_id',
value='',
field_operator='<>',
bDateFlag='true',
date_type='insert_date',
datebegin=getDate(-10),
dateend=getDate(0),
orderby='message_id',
inc='ASC';

var mOptionField="Message ID";

$('ul#search_option_list li a').click(function(){
	var mOption = $(this).text();
	mOptionField = mOption;
	$('#search_option').text(mOption+' ');
	$('#search_option').append('<span class="caret"></span>');
});

// search widget submit action
$('#search_form, #search_form_date').submit(function(ev){
	// set up search conditions
	date_type="insert_date";
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
	value=$('#search_input').val();
	if(value.length===0) {
		field_operator = '<>';
	} else {
		field_operator = '=';
	}
	switch (mOptionField) {
		case "Log Nr.":
		field="log_nr";
		break;
		case "Message ID":
		field="message_id";
		break;
		case "Mandant":
		field="mandant_firmname";
		break;
		case "Device SN":
		field="useragent";
		break;
		case "Client ID":
		field="client_id";
		break;
		case "Client IP":
		field="client_ip";
		break;
		case "Action":
		field="action";
		break;
	}
	ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc);
	// disable original submit action
	ev.preventDefault();
});

var mOrderBy=new Array('log_nr','message_id','mandant_firmname', 'useragent', 'client_id', 'client_ip', 'action', 'insert_date');
// realize sort functions
@for ($i = 1; $i < 9; $i++)
var bFlag_{{ $i }}=true;
$('#th_{{ $i }}').click(function(){
	$('thead span').hide().removeClass();
	if(bFlag_{{ $i }}) {
		bFlag_{{ $i }}=false;
		$('#th_{{ $i }} span').addClass("glyphicon glyphicon-chevron-down").show();
		orderby=mOrderBy[{{ $i-1 }}];
		inc='ASC';
		ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc);
	} else {
		bFlag_{{ $i }}=true;
		$('#th_{{ $i }} span').addClass("glyphicon glyphicon-chevron-up").show();
		orderby=mOrderBy[{{ $i-1 }}];
		inc='DESC';
		ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc);
	}
});
@endfor

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
	var width3 = Math.round(tableWidth*0.12)+'px';
	var width4 = Math.round(tableWidth*0.17)+'px';
	var width5 = Math.round(tableWidth*0.1)+'px';
	var width6 = Math.round(tableWidth*0.12)+'px';
	var width7 = Math.round(tableWidth*0.1)+'px';
	var width8 = Math.round(tableWidth*0.15)+'px';
	$('#th_1, td:nth-child(1)').width(width1);
	$('#th_2, td:nth-child(2)').width(width2);
	$('#th_3, td:nth-child(3)').width(width3);
	$('#th_4, td:nth-child(4)').width(width4);
	$('#th_5, td:nth-child(5)').width(width5);
	$('#th_6, td:nth-child(6)').width(width6);
	$('#th_7, td:nth-child(7)').width(width7);
	$('#th_8, td:nth-child(8)').width(width8);
}

// empty confirm button clicked and send ajax to remove all data of error_log table
$('#empty_confirm_button').click(function(){
	sendAjax('/delele_event','',function(result){
		$('#delete_confirm').modal('hide');
		if (result=='Delete Successfully!') {
			$('#event_log_list').html("");
		} else {
			Alert(result);
		}
	});
});

// send ajax request to backend
function ajaxSender(field, value, field_operator, bDateFlag, date_type, datebegin, dateend, orderby, inc) {
	var mData = {
		'field': field,
		'value': value,
		'field_operator': field_operator,
		'bDateFlag' : bDateFlag,
		'date_type' : date_type,
		'datebegin': datebegin,
		'dateend': dateend,
		'orderby': orderby,
		'inc': inc
	};
	sendAjax('/event_search',mData,function(result){
		//$('#test_block').text(result);
		$('#event_log_list').html(result).hide().fadeIn('fast');
		setTableWidth();
	});
}
</script>
@stop
