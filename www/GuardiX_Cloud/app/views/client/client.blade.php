<div id="client_panel" class="panel panel-default">
	<div class="panel-heading">
		<h3 id="client_panel_title" class="panel-title">Client Control</h3>
	</div>
	<!-- List group -->
	<div id="client_list_group" class="list-group">
		@include('client/client_lists')
	</div>
	<!-- client control panel -->
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<button id="add_client_button" data-toggle="modal" data-target="#client_adder" type="button" class="btn btn-primary">Add New Client</button>
			</div>
			<div class="col-md-3">
				<button id="get_deactive_active_client_button" type="button" class="btn btn-warning">Deactived Clients</button>
			</div>
			<div class="col-md-6">
				<form id="search_form" role="search">
					<div class="input-group">
						<div id="client_search_option" class="input-group-btn dropup">
							<button id="search_option" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
								Client ID <span class="caret"></span>
							</button>
							<ul id="search_option_list" class="dropdown-menu" role="menu">
								<li><a href="#">Client ID</a></li>
								<li><a href="#">Client Sort</a></li>
								<li><a href="#">Client Name</a></li>
								<li><a href="#">Belong to Mandant ID</a></li>
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
		</div>
	</div>
</div>
<script>
// mouse hover animation over dropdown-menu widget
$('#client_search_option').hover(function() {
  $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
}, function() {
  $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
});
// resize the panel
var mListHeight = $(window).height() - 270;
$('#client_list_group').css({
	"max-height": mListHeight + 'px'
});
$(window).resize(function(event) {
	var mListHeight = $(window).height() - 270;
	$('#client_list_group').css({
		"max-height": mListHeight + 'px'
	});
});
var mOptionField="Client ID";
$('ul#search_option_list li a').click(function(){
	var mOption = $(this).text();
	mOptionField = mOption;
	$('#search_option').text(mOption+' ');
	$('#search_option').append('<span class="caret"></span>');
});

// search conditions
var mSkip=30,
mTake=10,
mActiv='1',
mFlagFinished=false,
scrollOK = true;
field='mandant_id',
value='0',
operator='<>';

// search widget submit action
$('#search_form').submit(function(ev){
	value=$('#search_input').val();
	if(value.length===0) {
		operator = '<>';
	} else {
		operator = '=';
	}
	switch (mOptionField) {
		case "Client ID":
		field="client_id";
		break;
		case "Client Sort":
		field="client_sort";
		break;
		case "Client Name":
		field="client_login";
		break;
		case "Belong to Mandant ID":
		field="mandant_id";
		break;
	}
	AjaxSender(mActiv, field, value, operator, 0, 30, function(result) {
		animationRefresh(result);
		mSkip=30, mTake=10, mFlagFinished=false;
	});
	// disable original submit action
	ev.preventDefault();
});
$('#add_client_button').click(function(){
	$('#add_mandant_id_input_client').val("").prop('disabled',false);
    $('#add_mandant_id_input_client').val("");
    $('#add_id_input_client').val("");
	$('#add_password_input_client').val("");
	$('#add_login_input_client').val("");
	$('#add_sort_input_client').val("device");
	$('#add_client_Error_Message').text("").hide();
});
var mSkip=30, mTake=10, mActiv='1', mFlagFinished=false, scrollOK = true;
// send ajax request to get deactive clients or active clients
$('#get_deactive_active_client_button').click(function(){
	if (mActiv==='1') {
		AjaxSender('0', field, value, operator, 0, 30, function(result){
			$('#get_deactive_active_client_button').text('Actived Clients');
			$('#client_panel_title').text('Deactived Client Controll');
			animationRefresh(result);
			mSkip=30, mTake=10, mFlagFinished=false, mActiv='0';
		});
	} else {
		AjaxSender('1', field, value, operator, 0, 30, function(result){
			$('#get_deactive_active_client_button').text('Deactived Clients');
			$('#client_panel_title').text('Client Controll');
			animationRefresh(result);
			mSkip=30, mTake=10, mFlagFinished=false, mActiv='1';
		});
	}
});
// trigged when user scroll the windows
$('#client_list_group').bind('scroll', function () {
	if (scrollOK&&(!mFlagFinished)) {
		if (($(this).scrollTop()+$(this).height()) >= $(this)[0].scrollHeight-10) {
			scrollOK = false;
			AjaxSender(mActiv,field, value, operator, mSkip, mTake, function(result){
				mSkip+=mTake;
				scrollOK=true;
				$('#client_list_group').append(result);
				if (result==="") {
					mFlagFinished=true;
				}
			});
		}
	}
});
function AjaxSender(mActive,field,value,operator,mSkip,mTake,callback){
  var mData = {
    activ: mActive,
    field: field,
    value: value,
    operator: operator,
    skip: mSkip,
    take: mTake,
  };
  sendAjax('/get_clientList', mData, callback);
}
function animationRefresh(result) {
  var el=$('#client_list_group');
  var curHeight = el.height();
  el.html(result);
  var autoHeight=el.css('height','auto').height();
  el.height(curHeight).animate({height: autoHeight}, 300);
}
</script>