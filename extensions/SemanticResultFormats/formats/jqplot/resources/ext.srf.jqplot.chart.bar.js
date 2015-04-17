/**
 * JavaSript for SRF jqPlot bar/line/scatter module
 *
 * The script is designed to handle single and series data sets
 *
 * Release 0.6 has been checked agains jsHint which passed all conditions
 *
 * @licence: GNU GPL v2 or later
 * @author:  mwjames
 *
 * @release: 0.6
 */
( function( $ ) {
	"use strict";

	/*global mw:true, colorscheme:true*/

	// Bar/line data handling is separated from plotting because relevant data array
	// can be checked and if necessary bailout and show an error message instead
	// without causing any type errors
	$.fn.srfjqPlotBarChartData = function( options ) {
		var chartID = options.id,
		height = options.height,
		data   = options.data,
		width  = options.width,
		chart  = options.chart;

		// Global data array
		var labels = [];

		// Function handles all data array miracles
		var errMsg = '',
			dataRenderer = function() {
			var jqplotdata = [],
				ttLength = 0,
				ptLength = 0;

				// Count the amount of series
				for ( var k = 0; k < data.data.length; ++k ) {
					var ttData = [];
					ttLength = data.data[k].length;

					// Check if data series has the same length otherwise
					// stackseries throws an error
					if ( ttLength !== ptLength && k > 0 && data.parameters.stackseries === true ){
						errMsg = mw.msg( 'srf-error-jqplot-stackseries-data-length' );
					}

					// Individual data within a series
					for ( var j = 0; j < ttLength; ++j ) {
						if ( data.parameters.direction === 'horizontal' ){
							if ( data.fcolumntypeid === '_num' ){
								// Numeric x-value is handled differently
								ttData.push ( [data.data[k][j][1], data.data[k][j][0]] );
							}else{
								ttData.push ( [data.data[k][j][1], j+1] );
							}
						} else {
							if ( data.fcolumntypeid === '_num' ){
								// Numeric x-value is handled differently
								ttData.push ( [data.data[k][j][0], data.data[k][j][1]] );
							}else{
								ttData[j] = data.data[k][j][1];
							}
						}
						// Handle labels in extra array
						labels[j] = data.data[k][j][0];
					}
					jqplotdata.push( ttData );
					// Store previous length to compare both
					ptLength = ttLength;
				}
			return jqplotdata;
		};

		// Get data array
		var jqplotbardata = dataRenderer();

		// Error message handling
		if ( errMsg.length > 0 ){
			this.html( errMsg ).css( { 'class' : 'error', 'height' : 20 , 'margin' : '5px 5px 5px 5px', 'color': 'red' } );
		}else{
			this.srfjqPlotBarChart( { 'id' : chartID, 'data' : data, 'barData' : jqplotbardata, 'labels' : labels, 'height' : height, 'width' : width, 'chart' : chart } );
		}
	};

	// Bar/line/scatter plotting
	$.fn.srfjqPlotBarChart = function( options ) {
		var labels = options.labels,
		data = options.data;

		// Number axis
		var numberaxis = {
			ticks: data.parameters.stackseries || data.parameters.autoscale ?  [] : data.ticks, // use autoscale for staked series
			label: data.parameters.numbersaxislabel,
			labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
			autoscale: data.parameters.stackseries || data.parameters.autoscale ? true : false,
			padMax: 0,
			padMin: 0,
			tickOptions: {
			angle: data.parameters.direction === 'horizontal' ? 0 : -40,
			formatString: !data.parameters.valueformat ? '%d' : data.parameters.valueformat  // %d default
			}
		};

		// Helper function to get the Max value of the Array
		var max = function( array ){
			return Math.max.apply( Math, array );
		};

		// Helper function to get the Min value of the Array
		var min = function( array ){
			return Math.min.apply( Math, array );
		};

		var base = Math.pow( 1, Math.floor( Math.log( max( labels ), 10 ) ) );

		// Label axis
		var labelaxis = {
			// Depending on first column type values/labels are handled differently
			renderer: data.fcolumntypeid === '_num' ? $.jqplot.LinearAxisRenderer : $.jqplot.CategoryAxisRenderer,
			ticks:  data.fcolumntypeid === '_num' ? [] : labels,
			label: data.parameters.labelaxislabel,
			tickRenderer: $.jqplot.CanvasAxisTickRenderer,
			min: data.fcolumntypeid === '_num' ? Math.round( min( labels ) ) - base : '',
			max: data.fcolumntypeid === '_num' ? Math.round( max( labels ) ) + base : '',
			//tickInterval: 2,
			tickOptions: {
				angle: ( data.parameters.direction === 'horizontal' ? 0 : -40 ),
				formatString: !data.parameters.valueformat ? '%d' : data.parameters.valueformat  // %d default
			}
		};

		// Required for horizontal view
		var single = [ {
			renderer: data.renderer === 'bar' ? $.jqplot.BarRenderer : $.jqplot.LineRenderer,
			rendererOptions: {
				barDirection: data.parameters.direction,
				barPadding: 6,
				barMargin: data.parameters.direction === 'horizontal' ? 8 : 6,
				barWidth: data.renderer === 'vector' || data.renderer === 'simple' ? 20 : null,
				smooth: data.parameters.smoothlines,
				varyBarColor: true
			}
		} ];

		var highlighter = {
			show: data.parameters.highlighter  && data.renderer === 'line' ? true : false,
			showTooltip: data.parameters.highlighter,
			tooltipLocation: 'w',
			useAxesFormatters: data.parameters.highlighter,
			tooltipAxes: data.parameters.direction === 'horizontal' ? 'x' : 'y'
		};

		// Format individual data labels
		$.jqplot.LabelFormatter = function( format, val ) {
			var num = typeof val === 'object' ? val[1] : val;

			// Single mode
			if ( data.mode === 'single' ){
				if ( data.parameters.pointlabels === 'label' ){
					return labels[num];
				}else if ( data.parameters.pointlabels === 'percent' ) {
					return ( num / data.total  * 100 ).toFixed(2) + '% (' + num + ')';
				} else {
					return num;
				}
			}

			// Series mode
			if ( data.parameters.pointlabels === 'percent' ){
				return ( num / data.total  * 100 ).toFixed(2) + '% (' + num + ')';
			} else if ( data.parameters.pointlabels === 'label' ){
					return labels[num];
			} else if ( data.parameters.direction === 'horizontal' && data.renderer === 'line' ){
				// This case is weird because val returns with the index number and not with the value
				// which means all values displayed do mislead
				return '(n/a)';
			}else{
				return format !== '' ? val : val;
			}
		};

		var pointLabels = {
			show: data.parameters.pointlabels,
			location: data.parameters.direction === 'vertical' ? 'n' : 'e',
			edgeTolerance: data.renderer === 'bar' ? '-35': '-20',
			formatString: data.parameters.valueformat === '' ? '%d' : data.parameters.valueformat,
			formatter: $.jqplot.LabelFormatter,
			labels: data.parameters.pointlabels === 'label' ? data.labels : data.numbers
		};

		var seriesDefaults = {
			renderer: data.renderer === 'bar' ? $.jqplot.BarRenderer : $.jqplot.LineRenderer,
			fillToZero: true,
			shadow: data.parameters.theme !== 'simple',
			rendererOptions: {
				smooth: data.parameters.smoothlines
			},
			trendline: { show : false },
			pointLabels: pointLabels
		};

		var legend = {
			renderer: $.jqplot.EnhancedLegendRenderer,
			show: data.parameters.chartlegend !== 'none',
			location: data.parameters.chartlegend,
			labels:	data.legendLabels,
			placement: 'inside',
			xoffset: 10,
			yoffset: 10
		};

		// Series information
		var series = data.series;

		// Color information
		var seriesColors = data.parameters.seriescolors ? data.parameters.seriescolors : data.parameters.colorscheme === null ? null : colorscheme[data.parameters.colorscheme][9];

		// Enable jqplot plugins
		$.jqplot.config.enablePlugins = true;

		// Now we are plotting
		var jqplotbar = $.jqplot( options.id , options.barData , {
			title: data.parameters.charttitle,
			//dataRenderer: dataRenderer,
			stackSeries: data.parameters.stackseries,
			seriesColors: seriesColors,
			axesDefaults: {
				showTicks: data.parameters.ticklabels,
				tickOptions: { showMark: false }
			},
			grid: data.parameters.grid,
			highlighter: highlighter,
			seriesDefaults: seriesDefaults,
			cursor: {
				show: $.inArray( data.parameters.cursor, ['zoom','tooltip'] ) > -1 && $.inArray( data.fcolumntypeid, ['_num','_dat'] ) > -1,
				zoom: data.parameters.cursor === 'zoom',
				looseZoom:  data.parameters.cursor === 'zoom',
				showTooltip: data.parameters.cursor === 'tooltip'
			},
			series: data.mode === 'single' ?  single : series,
			axes: {
				xaxis : ( data.parameters.direction === 'vertical' ? labelaxis : numberaxis ),
				yaxis : ( data.parameters.direction === 'vertical' ? numberaxis : labelaxis )
				// x2axis : ( data.parameters.direction == 'vertical' ?  label2axis : number2axis ) ,
				// y2axis : ( data.parameters.direction == 'vertical' ?  number2axis : label2axis )
			},
			legend: data.parameters.chartlegend === 'none' ? null : legend
		} ); // enf of $.jqplot

		// Call theming
		this.srfjqPlotTheme( { 'plot' : jqplotbar, 'theme' : data.parameters.theme } );
	};
} )( window.jQuery );