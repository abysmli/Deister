@foreach($events as $event)
<tr>
	<td>
		{{ $event->log_nr }}
	</td>
	<td>
		{{ $event->message_id }} 
	</td>
	<td>
		{{ $event->mandant_firmname }} 
	</td>
	<td>
		{{ $event->useragent }} 
	</td>
	<td>
		{{ $event->client_id }} 
	</td>
	<td>
		{{ $event->client_ip }} 
	</td>
	<td>
		{{ $event->action }}
	</td>
	<td>
		{{ $event->insert_date }}
	</td>
</tr>
@endforeach