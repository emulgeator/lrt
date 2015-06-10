@extends('app')

@section('content')
	<h2>BL Dom Bar</h2>

	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				["Bl dom range", "Count"],
				@foreach ($blDomStats as $index => $range)
					['{{$range['blDomRange']}}', {{$range['occurrenceCount']}}],
				@endforeach
			]);

			var options = {
				title: 'Population of Largest U.S. Cities',
				chartArea: {width: '50%'},
				hAxis: {
					title: 'Total Population',
					minValue: 0
				},
				vAxis: {
					title: 'City'
				}
			};

			var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

			chart.draw(data, options);
		}
	</script>

	<div id="chart_div" style="width: 900px; height: 300px;"></div>
@endsection