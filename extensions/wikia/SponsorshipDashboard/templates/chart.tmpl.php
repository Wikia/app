<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->


	<? if( !empty($tagPosition) ){ ?>
	<p id="hubposition" >
	<?
		echo wfMsg('pv-ranking').' ';
		$tmpArray = array();
		foreach ( $tagPosition as $val ) {
			$tmpArray[] = wfMsg('hub-position', $val['position'], $val['name'] );
		}
		echo implode ( ', ', $tmpArray );
	?>
	</p>
	<? } ?>
	<div id="placeholder" ></div>
	<div id="overview" ></div>
	<h3 id="show" ><? echo wfMsg('show'); ?></h3><p id="choices"></p>
	
<!--[if IE]><script language="javascript" type="text/javascript" src="excanvas.pack.js"></script><![endif]-->
<script id="source" language="javascript" type="text/javascript">
$(function () {

	var datasets = <?=$datasets ?>;
	var predefinedColors = [	"#edc240", "#afd8f8", "#cb4b4b", "#4da74d", "#9440ed",
					"#C29F34", "#8FB1CB", "#953737", "#387938", "#512381",
					"#F7E3A8", "#E2F1FC", "#F1CECE", "#BEDFBE", "#D8BAF8" ];
	// hard-code color indices to prevent them from shifting as
	// countries are turned on/off
	var i = 0;
	var plot = null;
	var overview = null;
	var data = [];
	var selectionRanges = null;
	var options = {
				colors: predefinedColors,
				yaxis: { min: 0 },
				xaxis: { ticks: <?=$ticks; ?> },
				grid: { backgroundColor: '#FFFFFF',
					hoverable: true },
				series: {
					points: { show: true },
					lines: { show: true }
				},
				legend: { show: false }
			}

	var overviewOptions = {
				colors: predefinedColors,
				yaxis: { ticks: [], min: 0, autoscaleMargin: 0.1 },
				xaxis: { ticks: [] },
				grid: { backgroundColor: '#FFFFFF' },
				selection: { mode: "x" },
				series: {
					lines: { show: true, lineWidth: 1 },
					shadowSize: 0
				},
				legend: { show: false }
			}
			
	$.each(datasets, function(key, val) {
		val.color = i;
		++i;
	});
    
	// insert checkboxes
	var choiceContainer = $("#choices");
	$.each(datasets, function(key, val) {
		choiceContainer.append('<div class="colorHolder" style="background-color: ' + predefinedColors[val.color] +'"><input type="checkbox" name="' + key +
                               '" checked="checked" id="id' + key + '"></div>' +
			       '<label for="id' + key + '"> '
                                + val.label + '</label><br/>');
	});
	choiceContainer.find("input").click( plotAccordingToChoices );
 
	function plotAccordingToChoices( stopRedrawOverview ) {

		data = [];
 		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) data.push(datasets[key]);
		});
		if (data.length > 0){
			plot = $.plot($("#placeholder"), data, options);
			if ( !( stopRedrawOverview === true ) ){
				overview = $.plot( $("#overview"), data, overviewOptions );
				if ( selectionRanges != null ){
					overview.setSelection( selectionRanges );
				}
			}
		}
	}

	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css( {
		    top: y + 5,
			left: x + 25,
			position: 'absolute',
			display: 'none',
			color: '#000',
			padding: '2px',
			'background-color': '#fff',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
	}

	var previousPoint = null;
	
	$("#placeholder").bind("plothover", function (event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));
		if (item) {
			if (previousPoint != item.datapoint) {
			    previousPoint = item.datapoint;
			    $("#tooltip").remove();
			    var x = item.datapoint[0].toFixed(2),
				y = item.datapoint[1].toFixed(2);

			    showTooltip(item.pageX, item.pageY, y);
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
	});

	$("#placeholder").bind("plotselected", function (event, ranges) {
		// do the zooming

		options = $.extend(true, {}, options, {
			xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to }
		});
		selectionRanges = { x1: ranges.xaxis.from, x2: ranges.xaxis.to }
		// don't fire event on the overview to prevent eternal loop
		overview.setSelection(ranges, true);
		plotAccordingToChoices( true );
	});

	$("#overview").bind("plotselected", function (event, ranges) {
		plot.setSelection(ranges);
	});

	plotAccordingToChoices();
});
</script> 
<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
