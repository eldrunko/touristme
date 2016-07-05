<form action="/prenota" method="post">
{{ csrf_field() }}
	<input type="hidden" name="guide_id" value="{{$id_prenotando}}">
	<input type="hidden" name="user_id" value="1">
	<input type="hidden" name="date" value="2010-01-01">
	<input type="hidden" name="time" value="1">
	<!--<input type="hidden" name="date" value="">
	<input type="hidden" name="time" value="">-->
	<input type="submit" name="prenota la suddetta guida">
	<!--TODO: aggiungere infos extra e dettagli-->
</form>