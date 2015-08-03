@extends('layout')

@section('content')
<div class="container">
	<!-- welcome informations -->
	<div class="jumbotron">
		<p style="color: #4473FF;">Welcome, <em>{{ $user['username'] }}</em>, You belong to <b>{{ $user['group'] }} group</b></p>
	    <h1>GuardiX Cloud</h1>
	    <p>Administration && Event Logs GUI for Deister Electronic GmbH</p>
	    <hr/>
	    <a href="http://www.deister.com/‎" class="btn btn-primary btn-lg" role="button">Learn more</a>
	</div>
</div>
@stop