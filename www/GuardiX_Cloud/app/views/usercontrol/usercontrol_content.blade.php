@foreach($users as $user)
<tr style="cursor:pointer;">
	<td id="user_id">
		{{ $user->user_id }} 
	</td>
	<td id="user_name">
		{{ $user->username }} 
	</td>
	<td id="user_group">
		{{ $user->group }} 
	</td>
	<td id="create_date">
		{{ $user->create_date }} 
	</td>
	<td id="delete_button" style="width: 1em; visibility:hidden;">
		<a href="#delete">
			<span class="glyphicon glyphicon-trash pull-right">
	    	</span>
    	</a>
	</td>
</tr>
@endforeach