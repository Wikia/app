<h1><?= $header ?></h1>
<br>
Properties (select multiple properties using ctrl/shift):<br>
<form action="" method="get">
	<select size="10" id="propertySelect" name="prop[]" multiple>
	<?php
	$selected = '';
	foreach ( $wikiData as $propName ) {
		if (!empty($selectedProps)) {
			$selected = in_array( $propName, $selectedProps ) ? ' selected' : '';
		}
		echo "\t\t<option value=\"$propName\"$selected>$propName</option>\n";
	}
	?>
	</select>
	<br>
	<input type="submit" value="Show stats">
</form>

<?php if (!empty($selectedProps)) { ?>
<div id="graphs">
	<h1><?= wfMsg('userpreferencesstats-graphs-header') ?></h1>
	<!-- graphs added by JS -->
</div>
<div id="hover"></div>

<script>
var data = {}, htmlLabels = {};
<?php
	foreach ($data as $propName => $propData) {
		echo "data['$propName'] = [];\n";
		echo "htmlLabels['$propName'] = '" . addslashes(wfMsgExt( 'userpreferencesstats-property-label', array('parseinline', 'parsemag'), $propName, count( $data[$propName] ) )) . "';\n";
		foreach ( $propData as $propValue => $propCount ) {
			echo "data['$propName'].push({label: '$propValue', data: $propCount});\n";
		}
	}
?>
$.each(data, function(index, value) {
	$().log('adding graph: ' + index);
	var graph = $('<div class="graph-plot" id="' + index + '">');
//		.bind('plothover', function(event, pos, obj) {
//		if (!obj) return;
//		var percent = parseFloat(obj.series.percent).toFixed(2);
//		$("#hover").html('<span style="color: ' + obj.series.color+'">' + obj.series.label + ' (' + percent + '%)</span>');
//		});

	var graphLabel = $('<span class="graph-label">').html(htmlLabels[index]);
	var graphWrapper = $('<div class="graph-wrapper">').append(graphLabel).append(graph);
	$('#graphs').append(graphWrapper);
	$.plot(graph, data[index], {
		grid: {
			hoverable: true
		},
		legend: {
			show: false
		},
		series: {
			pie: {
				combine: {
					threshold: 0.1
				},
				label: {
					background: {
						color: '#000',
						opacity: 0.5
					},
					formatter: function(label, series) {
						return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">value:&nbsp;<b>' + label + '</b><br>users:&nbsp;<b>' + series.data[0][1] + '</b><br>percentage:&nbsp;<b>' + Math.round(series.percent) + '%</b></div>';
					},
					radius: 3/4,
					show: true
				},
				radius: 1,
				show: true
			}
		}
	});
});
</script>
<?php } ?>