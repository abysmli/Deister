<div id="mandant_panel" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Mandant Control</h3>
  </div>
  <!-- List group -->
  <div id="mandant_list_group" class="list-group">
    {{-- here insert mandant_lists template --}}
    @include('mandant/mandant_lists')
  </div>
  <!-- mandant control panel -->
  <div class="panel-body">
    <div class="row">
      <div id="alphabet" class="col-md-12">
        <ul class="pagination pagination-sm">
          <li><a href="#">ALL</a></li>
          <li><a href="#">A</a></li>
          <li><a href="#">B</a></li>
          <li><a href="#">C</a></li>
          <li><a href="#">D</a></li>
          <li><a href="#">E</a></li>
          <li><a href="#">F</a></li>
          <li><a href="#">G</a></li>
          <li><a href="#">H</a></li>
          <li><a href="#">I</a></li>
          <li><a href="#">J</a></li>
          <li><a href="#">K</a></li>
          <li><a href="#">L</a></li>
          <li><a href="#">M</a></li>
          <li><a href="#">N</a></li>
          <li><a href="#">O</a></li>
          <li><a href="#">P</a></li>
          <li><a href="#">Q</a></li>
          <li><a href="#">R</a></li>
          <li><a href="#">S</a></li>
          <li><a href="#">T</a></li>
          <li><a href="#">U</a></li>
          <li><a href="#">V</a></li>
          <li><a href="#">W</a></li>
          <li><a href="#">X</a></li>
          <li><a href="#">Y</a></li>
          <li><a href="#">Z</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <button data-toggle="modal" data-target="#mandant_adder" type="button" class="btn btn-primary">Add New Mandant</button>
      </div>
      <div class="col-md-3">
        <!-- Single button -->
        <div class="btn-group dropup">
          <button id="stat_button" type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
            Active <span class="caret"></span>
          </button>
          <ul id="stat_option_list" class="dropdown-menu" role="menu">
            <li><a href="#">Active</a></li>
            <li><a href="#">Inactive</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6">
        <form id="search_form" role="search">
          <div class="input-group">
            <div id="mandant_search_option" class="input-group-btn dropup">
              <button id="search_option" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                Mandant ID <span class="caret"></span>
              </button>
              <ul id="search_option_list" class="dropdown-menu" role="menu">
                <li><a href="#">Mandant ID</a></li>
                <li><a href="#">Mandant Superuser</a></li>
                <li><a href="#">Mandant Company</a></li>
                <li><a href="#">Mandant Address</a></li>
                <li><a href="#">Mandant E-Mail</a></li>
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
$('#mandant_search_option, .btn-group').hover(function() {
  $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
}, function() {
  $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
});
// resize the panel
var mListHeight = $(window).height() - 330;
$('#mandant_list_group').css({
  "max-height": mListHeight + 'px'
});
$(window).resize(function(event) {
  var mListHeight = $(window).height() - 330;
  $('#mandant_list_group').css({
    "max-height": mListHeight + 'px'
  });
});
var mOptionField="Mandant ID";
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
operator='<>',
like='%';

// search widget submit action
$('#search_form').submit(function(ev){
  value=$('#search_input').val();
  if(value.length===0) {
    operator = '<>';
  } else {
    operator = '=';
  }
  switch (mOptionField) {
    case "Mandant ID":
    field="mandant_id";
    break;
    case "Mandant Superuser":
    field="username";
    break;
    case "Mandant Company":
    field="mandant_firmname";
    break;
    case "Mandant Address":
    field="mandant_address";
    break;
    case "Mandant E-Mail":
    field="mandant_contact";
    break;
  }
  AjaxSender(mActiv, field, value, operator, 0, 30, like, function(result) {
    animationRefresh(result);
    mSkip=30, mTake=10, mFlagFinished=false;
  });
  // disable original submit action
  ev.preventDefault();
});

$('#alphabet a').click(function(){
  like=$(this).text()+'%';
  if(like==='ALL%')
  {
    like='%';
  }
  AjaxSender(mActiv, field, value, operator, 0, 30, like, function(result) {
    animationRefresh(result);
    mSkip=30, mTake=10, mFlagFinished=false;
  });
});

// send ajax request to get deactive mandants or active mandants
$('ul#stat_option_list li a').click(function(){
  var mOption = $(this).text();
  $('#stat_button').text(mOption+' ');
  $('#stat_button').append('<span class="caret"></span>');
  if (mOption == 'Active') {
    mActiv = '1';
  } else if (mOption == 'Inactive') {
    mActiv = '0';
  }
  AjaxSender(mActiv, field, value, operator, 0, 30, like, function(result) {
    animationRefresh(result);
    mSkip=30, mTake=10, mFlagFinished=false;
  });
});


// send ajax request to get deactive mandants or active mandants
$('#get_deactive_active_mandant_button').click(function(){
  if (mActiv==='1') {
    AjaxSender('0', field, value, operator, 0, 30, like, function(result) {
      $('#get_deactive_active_mandant_button').text('Actived Mandants');
      $('#mandant_panel_title').text('Deactived Mandant Controll');
      animationRefresh(result);
      mSkip=30, mTake=10, mFlagFinished=false, mActiv='0';
    });
  } else {
    AjaxSender('1', field, value, operator, 0, 30, like, function(result) {
      $('#get_deactive_active_mandant_button').text('Deactived Mandants');
      $('#mandant_panel_title').text('Mandant Controll');
      animationRefresh(result);
      mSkip=30, mTake=10, mFlagFinished=false, mActiv='1';
    });
  }
});

// trigged when user scroll the windows
$('#mandant_list_group').bind('scroll', function () {
  if (scrollOK&&(!mFlagFinished)) {
    if (($(this).scrollTop()+$(this).height()) >= $(this)[0].scrollHeight-10) {
      scrollOK = false;
      AjaxSender(mActiv,field, value, operator, mSkip, mTake, like, function(result){
        mSkip+=mTake;
        scrollOK=true;
        $('#mandant_list_group').append(result);
        if (result==="") {
          mFlagFinished=true;
        }
      });
    }
  }
});

function AjaxSender(mActive,field,value,operator,mSkip,mTake,like,callback) {
  var mData = {
    activ: mActive,
    field: field,
    value: value,
    operator: operator,
    skip: mSkip,
    take: mTake,
    like: like,
  };
  sendAjax('/get_mandantList', mData, callback);
}

function animationRefresh(result) {
  var el=$('#mandant_list_group');
  var curHeight = el.height();
  el.html(result);
  var autoHeight=el.css('height','auto').height();
  el.height(curHeight).animate({height: autoHeight}, 300);
}
</script>
