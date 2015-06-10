@extends('app')

@section('content')
	<h2>From URL Pie</h2>

	<div id="pieChart" style="width: 900px; height: 500px;"></div>

	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Task', 'From URL hostname occurrence'],
				@foreach ($fromUrlStats as $index => $hostname)
					['{{$hostname['from_url_hostname']}}', {{$hostname['occurrenceCount']}}],
				@endforeach
			]);

			var options = {
				title: 'From URL hostname occurrence'
			};

			var chart = new google.visualization.PieChart(document.getElementById('pieChart'));

			chart.draw(data, options);
		}
	</script>
@endsection