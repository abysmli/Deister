<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="{{ asset('/img/icon.png') }}">
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('css/main.css'); }}
	{{ HTML::style('css/jquery-ui.css'); }}
	{{ HTML::style('css/datepicker.css'); }}
	{{ HTML::script('js/jquery.min.js'); }}
	{{ HTML::script('js/jquery-ui.js'); }}
	{{ HTML::script('js/jquery.ui.datepicker-de.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	{{ HTML::script('js/main.js')}}
	{{ HTML::script('js/send_ajax.js')}}
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script type="text/javascript"
        src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js">
	</script>
	<script type ="text/javascript">
        $(function() {
        $( "#search_date_input_1" ).datepicker($.datepicker.regional[ "de" ]);
        });
	$(function() {
        $( "#search_date_input_2" ).datepicker($.datepicker.regional[ "de" ]);
        });
        </script>
	

</head>
<body>
	<!-- navbar -->
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class ="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Controll Center</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if ($page===1)
						@if ($user['group']==='admins')
						<li class="active"><a href="/admin">Administration</a></li>
						<li><a href="/adminlog">Admin Logs</a></li>
						@endif
						<li><a href="/event">Event Logs</a></li>
						<li><a href="/errorlog">Error Logs</a></li>
					@elseif ($page===2)
						@if ($user['group']==='admins')
						<li><a href="/admin">Administration</a></li>
						<li><a href="/adminlog">Admin Logs</a></li>
						@endif
						<li class="active"><a href="/event">Event Log</a></li>
						<li><a href="/errorlog">Error Logs</a></li>
					@elseif ($page===3)
						@if ($user['group']==='admins')
					    <li><a href="/admin">Administration</a></li>
					    <li><a href="/adminlog">Admin Logs</a></li>
					    @endif
						<li><a href="/event">Event Log</a></li>
						<li class="active"><a href="/errorlog">Error Logs</a></li>
					@elseif ($page===4)
						@if ($user['group']==='admins')
					    <li><a href="/admin">Administration</a></li>
					    <li class="active"><a href="/adminlog">Admin Logs</a></li>
					    @endif
						<li><a href="/event">Event Log</a></li>
						<li><a href="/errorlog">Error Logs</a></li>
					@else
						@if ($user['group']==='admins')
						<li><a href="/admin">Administration</a></li>
						<li><a href="/adminlog">Admin Logs</a></li>
						@endif
						<li><a href="/event">Event Logs</a></li>
						<li><a href="/errorlog">Error Logs</a></li>			
					@endif 
				</ul>
				<ul id="right_navbar" class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $user['username'] }}<b class="caret"></b></a>
						<ul class="dropdown-menu">
							@if ($user['group']==='admins')
							<li>
								<a href="/setting"><span class="glyphicon glyphicon-cog"></span>  Account Setting</a>
							</li>
							@endif
							<li>
								<a href="/logout"><span class="glyphicon glyphicon-share"></span>  Logout</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a data-toggle="modal" data-target="#about_modal" href="#about">About</a>
							</li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<div class="modal fade" id="about_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel">About</h4>
	      </div>
	      <div class="modal-body">
	      	<h4>GuardiX Cloud Administration GUI</h4>
	      	<hr/>
	      	<p>For Company: <a href="http://www.deister.com/">Deister Electronic</a></p>
	      	<p>Developer Team: <a href="http://www.emw.hs-anhalt.de/">Future Internet Lab Anhalt</a></p>
	      	<p>E-Mail: <a href="mailto: yuan.li@student.emw.hs-anhalt.de"> yuan.li@student.emw.hs-anhalt.de</a></p>
	      	<hr/>
	      	<p>Copyright @ 2013 - 2014 by Future Internet Lab Anhalt</p>
	      	<p>All Copyright reserved!</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	{{-- content section will be insert here --}}
	@yield('content')
	<!-- footer of page -->
	<div class="navbar navbar-default navbar-fixed-bottom">
		<div class ="container">
			<p class="navbar-text pull-left"><a href="http://www.deister.com/">Only for GuardiX Cĺoud</a> - <a href="http://www.hs-anhalt.de">Future Internet Lab Anhalt</a></p>
		</div>
	</div>
</body>
</html>
