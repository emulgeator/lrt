@extends('app')

@section('content')
	<h2>Link Status Pie</h2>

	<div id="pieChart" style="width: 900px; height: 500px;"></div>

	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Task', 'Link Status occurrence'],
				@foreach ($linkStatusStats as $index => $linkStatus)
					['{{$linkStatus['link_status']}}', {{$linkStatus['occurrenceCount']}}],
				@endforeach
			]);

			var options = {
				title: 'Link Status occurrence'
			};

			var chart = new google.visualization.PieChart(document.getElementById('pieChart'));

			chart.draw(data, options);
		}
	</script>
@endsection