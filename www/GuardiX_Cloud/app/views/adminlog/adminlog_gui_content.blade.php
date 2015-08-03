@foreach($adminlogs as $adminlog)
<tr>
	<td>
		{{ $adminlog->log_nr }} 
	</td>
	<td>
		{{ $adminlog->username }} 
	</td>
	<td>
		{{ $adminlog->actor_id }} 
	</td>
	<td>
		{{ $adminlog->ip }} 
	</td>
	<td style="text-align: left;">
		<pre>{{ $adminlog->action }} </pre>
	</td>
	<td>
		{{ $adminlog->date }} 
	</td>
</tr>
@endforeach