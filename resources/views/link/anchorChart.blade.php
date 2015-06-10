@extends('app')

@section('content')
	<h2>Anchor Cloud</h2>

	<div id="anchorCloud"></div>

	<script type="text/javascript">
		google.load("visualization", "1");
		google.setOnLoadCallback(draw);
		function draw() {
			data = new google.visualization.DataTable();
			data.addColumn('string', 'Label');
			data.addColumn('number', 'Value');
			data.addRows({{count($anchorStats)}});
			@foreach ($anchorStats as $index => $anchor)
				data.setValue({{$index}}, 0, '{{$anchor['anchor_text']}}');
				data.setValue({{$index}}, 1, '{{$anchor['occurrenceCount']}}');
			@endforeach
			var outputDiv = document.getElementById('anchorCloud');
			var tc = new TermCloud(outputDiv);
			tc.draw(data, null);
		}
	</script>
@endsection