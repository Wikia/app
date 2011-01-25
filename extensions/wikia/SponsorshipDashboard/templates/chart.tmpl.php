<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->


<div class="description"><b><? echo ( isset( $title )) ? $title : ''; ?></b> - <? echo ( isset( $description )) ? $description : '';  ?></div>

<? if( !empty($tagPosition) ){ ?>
	<p id="hubposition<?=$number; ?>" class="hubposition" >
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

	<div class="sponsorship-dashboard-panel left">
		<h3 id="show<?=$number; ?>" class="sponsorship-dashboard-show"><? echo wfMsg('sponsorship-dashboard-variables'); ?></h3>
		<? if( !empty( $selectorItems ) && !empty( $current ) ){ ?>
			<div class="sponsorship-dashboard-form">
				<div class="sponsorship-dashboard-form-text"><?=wfMsg('sponsorship-dashboard-city-select'); ?></div>
				<ul class="wikia-menu-button secondary">
					<li>
						<a id="sponsorship-dashboard-form-current" href="<?=$path; ?>"><?=$current['name']; ?></a>
						<img src="http://images1.wikia.nocookie.net/__cb27571/common/skins/common/blank.gif" class="chevron">
						<ul style="min-width: 116px; ">
						<? foreach ( $selectorItems as $key => $item ){?>
							<li<? if( $current['id'] == $item ){?> class="selected" <?}?>><a href="<?=$path; ?>?cityHub=<?=$item; ?>" id="sponsorship-dashboard-<?=$item; ?>"><?=$key; ?></a></li>
						<? } ?>
						</ul>
					</li>
				</ul>
			</div>
		<? } ?>
		<p id="choices<?=$number; ?>" class="sponsorship-dashboard-choices"></p>
		<div>
			<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-select<?=$number; ?>">select all</a>
			<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-deselect<?=$number; ?>">deselect all</a>
		</div>
	</div>
	<div class="sponsorship-dashboard-panel right">
		<div class="sponsorship-dashboard-panel-header">
			<div class="datepicker left">
				<div id="overviewLabel<?=$number; ?>" class="overviewLabel"><? 
					echo wfMsg('sponsorship-dashboard-from-label');
				?></div>
				<select id="sd-year-from" class="sd-datepicker">
					<?
						for ( $i = $fromYear; $i <= date('Y'); $i++ ){
							echo '<option value="'.$i.'"';
							if ( ( date('Y') - 1 ) == $i ) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
						}
					?>
				</select>-<select id="sd-month-from" class="sd-datepicker">
					<?
						for ( $i = 1; $i <= 12; $i++ ){
							echo '<option value="';
							if ( $i < 10 ){ echo '0'; };
							echo $i.'"';
							if ( date('m') == $i ) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
						}
					?>
				</select><? if( empty( $monthly ) ){ ?>-<select id="sd-day-from" class="sd-datepicker">
					<?
						for ( $i = 1; $i <= 31; $i++ ){
							echo '<option value="';
							if ( $i < 10 ){ echo '0'; };
							echo $i.'"';
							if ( date('d') == $i ) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
						}
					?>
				</select>
				<? } ?>
			</div>
			<div class="datepicker">
				<div id="overviewLabel<?=$number; ?>" class="overviewLabel"><?
					echo wfMsg('sponsorship-dashboard-to-label');
				?></div>
				<select id="sd-year-to" class="sd-datepicker">
					<?
						for ( $i = $fromYear; $i <= date('Y'); $i++ ){
							echo '<option value="'.$i.'"';
							if ( date('Y') == $i ) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
						}
					?>
				</select>-<select id="sd-month-to" class="sd-datepicker">
					<?
						for ( $i = 1; $i <= 12; $i++ ){
							echo '<option value="';
							if ( $i < 10 ){ echo '0'; };
							echo $i.'"';
							if ( date('m') == $i ) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
						}
					?>
				</select><? if( empty( $monthly ) ){ ?>-<select id="sd-day-to" class="sd-datepicker">
					<?
						for ( $i = 1; $i <= 31; $i++ ){
							echo '<option value="';
							if ( $i < 10 ){ echo '0'; };
							echo $i.'"';
							if ( date('d') == $i ) echo ' selected="selected" ';
							echo '>'.$i.'</option>';
						}
					?>
				</select>
				<? } ?>
			</div>
			<div id="overviewWrapper<?=$number; ?>" class="overviewWrapper" >
				<div id="overviewLabel<?=$number; ?>" class="overviewLabel"><? echo wfMsg('sponsorship-dashboard-overview-label'); ?></div>
				<div id="overview<?=$number; ?>" class="overview" ></div>
			</div>
		</div>
		<div class="sponsorship-dashboard-panel-body">
			<div id="placeholder<?=$number; ?>" class="placeholder" ></div>
		</div>
	</div>
<!--[if IE]><script language="javascript" type="text/javascript" src="excanvas.pack.js"></script><![endif]-->
<script id="source<?=$number; ?>" language="javascript" type="text/javascript">
$(function () {
	var hiddenSeries = <?=$hiddenSeries ?>;
	var datasets = <?=$datasets ?>;
	var fullTicks = <?=$fullTicks ?>;
	var predefinedColors = [	"#cb4b4b", "#4da74d", "#edc240", "#afd8f8", "#9440ed", "#BEBE5D", "#FF00CC", "#0099FF",
					"#953737", "#387938", "#C29F34", "#8FB1CB", "#512381", "#999900", "#8B006F", "#006FB9",
					"#F1CECE", "#BEDFBE", "#F7E3A8", "#E2F1FC", "#D8BAF8", "#ECECD1", "#FF8BE8", "#D1ECFF"  ];
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
		y2axis: { min: 0, max: 100, tickFormatter: function (v, axis) { return v.toFixed(axis.tickDecimals) +"%" } },
		grid: { backgroundColor: '#FFFFFF',
			hoverable: true },
		series: {
			points: { show: false },
			lines: { show: true }
		},
		legend: { show: false }
	}

	var overviewOptions = {
		colors: predefinedColors,
		yaxis: { ticks: [], min: 0, autoscaleMargin: 0.1 },
		y2axis: { min: 0, max: 100 },
		xaxis: { ticks: [] },
		grid: { backgroundColor: '#FFFFFF' },
		selection: { mode: "x" },
		series: {
			lines: { show: true, lineWidth: 1 },
			shadowSize: 1
		},
		legend: { show: false }
	}

	$.each(datasets, function(key, val) {
		val.color = i;
		++i;
	});

	// insert checkboxes
	var choiceContainer = $('#choices<?=$number; ?>');
	
	$.each(datasets, function(key, val) {
		var tmpText = '<div class="colorHolder" style="background-color: ' + predefinedColors[val.color] +'"><input type="checkbox" name="' + key + '" ';
		if ( jQuery.inArray( key, hiddenSeries ) == -1 ){
			tmpText = tmpText +' checked="checked"';
		}
		tmpText = tmpText +' id="id' + key + '<?=$number; ?>"></div><label for="id' + key + '<?=$number; ?>"> ' + val.label + '</label><br/>';

		choiceContainer.append( tmpText );
	});
	
	choiceContainer.find('input').click( plotAccordingToChoices );
 
	function plotAccordingToChoices( stopRedrawOverview ) {

		data = [];
 		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) data.push(datasets[key]);
		});
		if (data.length > 0){
			plot = $.plot($("#placeholder<?=$number; ?>"), data, options);
			if ( !( stopRedrawOverview === true ) ){
				overview = $.plot( $("#overview<?=$number; ?>"), data, overviewOptions );
				if ( selectionRanges != null ){
					overview.setSelection( selectionRanges );
				}
			}
		}
	}

	function showTooltip(x, y, contents) {
	
		$('<div id="tooltip<?=$number; ?>">' + contents + '</div>').css( {
			
			top: y + 5,
			left: x + 25,
			position: 'absolute',
			display: 'none',
			color: '#000',
			padding: '2px',
			'background-color': '#fff',
			opacity: 0.80,
			'z-index': 999

		}).appendTo("body").fadeIn(200);
	}

	var previousPoint = null;

	function drawFromPickers(){

		
		var fromData = $('#sd-year-from').val();
		fromData = fromData + '-' + $('#sd-month-from').val();
		<? if( empty( $monthly ) ){ ?>
			fromData = fromData + '-'+$('#sd-day-from').val();
		<? } ?>;
		var toData = $('#sd-year-to').val()
		toData = toData + '-' + $('#sd-month-to').val()
		<? if( empty( $monthly ) ){ ?> 
			toData = toData + '-' + $('#sd-day-to').val();
		<? } ?>;

		var fromDataAfter = 0;
		var toDataAfter = 0

		var fromDataBuffer = 0;
		var toDataBuffer = 1;

		var fulltickAsInt = 0;
		for( var i in fullTicks ){

			fulltickAsInt = fullTicks[i][0].replace(/-/gi, "");
			if ( parseInt( fromData.replace(/-/gi, "") ) > ( fulltickAsInt )  ){
				fromDataBuffer = fullTicks[i][1];
			}
			if ( parseInt( toData.replace(/-/gi, "") ) > ( fulltickAsInt )  ){
				toDataBuffer = fullTicks[i][1];
			}
			if ( fromData == fullTicks[i][0]) {
				fromDataAfter = fullTicks[i][1];
			}
			if ( toData == fullTicks[i][0] ){
				toDataAfter = fullTicks[i][1];
			}
		}

		if ( fromDataAfter == 0 ) fromDataAfter = fromDataBuffer;
		if ( toDataAfter == 0 ) toDataAfter = toDataBuffer;

		overview = $.plot( $("#overview<?=$number; ?>"), data, overviewOptions );
		overview.setSelection({ x1: fromDataAfter, x2: toDataAfter });
		
	}

	$('#placeholder<?=$number; ?>').bind('plothover', function (event, pos, item) {
		
		$("#x<?=$number; ?>").text(pos.x.toFixed(2));
		$("#y<?=$number; ?>").text(pos.y.toFixed(2));
		
		if ( item ) {
			if (previousPoint != item.datapoint) {
				
				previousPoint = item.datapoint;
				$("#tooltip<?=$number; ?>").remove();
				var	x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);

				var xText = '';
				for ( var i in fullTicks ){
					if ( fullTicks[i][1] == item.datapoint[0] ){
						xText = fullTicks[i][0]
					}
				}
				
				showTooltip( item.pageX, item.pageY, xText + ' ' + y + ' - ' + item.series.label );
			}
		} else {
			$("#tooltip<?=$number; ?>").remove();
			previousPoint = null;
		}
	});

	$('#placeholder<?=$number; ?>').bind('plotselected', function (event, ranges) {
		// do the zooming

		options = $.extend(true, {}, options, {
			xaxis: { min: Math.round( ranges.xaxis.from ), max: Math.round( ranges.xaxis.to ) }
		});
		
		selectionRanges = { x1: Math.round( ranges.xaxis.from ), x2: Math.round( ranges.xaxis.to ) }

		for( var i in fullTicks ){
			if ( fullTicks[i][1] == Math.round( ranges.xaxis.from ) ){

				var data2split = fullTicks[i][0].split('-');
				$('#sd-year-from').val( data2split[0] );
				$('#sd-month-from').val( data2split[1] );
				<? if( empty( $monthly ) ){ ?>$('#sd-day-from').val( data2split[2] ); <? } ?>
			}
			if ( fullTicks[i][1] == Math.round( ranges.xaxis.to ) ){

				var data2split = fullTicks[i][0].split('-');
				$('#sd-year-to').val( data2split[0] );
				$('#sd-month-to').val( data2split[1] );
				<? if( empty( $monthly ) ){ ?>$('#sd-day-to').val( data2split[2] ); <? } ?>
			}
		}

		// don't fire event on the overview to prevent eternal loop
		overview.setSelection(ranges, true);
		plotAccordingToChoices( true );
	});

	$( '#sponsorship-dashboard-select<?=$number; ?>' ).bind('click', function(){
		choiceContainer.find( "INPUT[type='checkbox']" ).attr('checked', true);
		plotAccordingToChoices();
		
	});
	
	$('#sponsorship-dashboard-deselect<?=$number; ?>').bind('click', function(){
		choiceContainer.find( "INPUT[type='checkbox']" ).attr('checked', false);
		plotAccordingToChoices();
	});

	$('#overview<?=$number; ?>').bind('plotselected', function (event, ranges) {
		plot.setSelection(ranges);
	});

	$('.datepicker').bind('change', drawFromPickers );
	
	plotAccordingToChoices();
	drawFromPickers();
	
});
</script>
<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
