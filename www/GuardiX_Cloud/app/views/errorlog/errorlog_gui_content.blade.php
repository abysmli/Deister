@foreach($errors as $error)
<tr>
	<td>
		{{ $error->log_nr }} 
	</td>
	<td>
		{{ $error->actor }} 
	</td>
	<td>
		{{ $error->actor_id }} 
	</td>
	<td>
		{{ $error->ip }} 
	</td>
	<td>
		{{ $error->error_code }} 
	</td>
	<td>
		{{ $error->action }} 
	</td>
	<td>
		{{ $error->date }} 
	</td>
</tr>
@endforeach