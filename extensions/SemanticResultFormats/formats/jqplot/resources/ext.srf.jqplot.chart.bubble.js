/**
 * JavaSript for SRF jqPlot bubble module
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

	// Only display errors
	try { console.log('console ready'); } catch (e) { var console = { log: function () { } }; }

	/*global mw:true, colorscheme:true*/

	// Bubble chart data handling is separated from plotting because relevant data array
	// can be checked and if necessary bailout and show an error message instead
	// without causing any type errors
	$.fn.srfjqPlotBubbleChartData = function( options ) {
		var data = options.data;

		// Data array handling
		var errMsg = '',
			dataRenderer = function() {
				var bubbledata = [];

				// Check to avoid TypeErrors
				if ( typeof data.data[0] === 'undefined' ) {
					errMsg = mw.msg( 'srf-error-jqplot-bubble-data-length' );
				} else if ( typeof data.data[1] === 'undefined' ){
					errMsg = mw.msg( 'srf-error-jqplot-bubble-data-length' );
				} else if ( typeof data.data[2] === 'undefined' ){
					errMsg = mw.msg( 'srf-error-jqplot-bubble-data-length' );
				}

				// Data manipulation
				// Convert [x: [label, value ]], [y: [label, value ]], [radius: [label, value ]] into
				// [x, y, radius, <label or object>]
				if ( errMsg === '' ){
					for ( var k = 0; k < data.data[0].length; ++k ) {
						bubbledata.push( [data.data[0][k][1], data.data[1][k][1], data.data[2][k][1], data.data[0][k][0]  ]);
					}
				}
				return [bubbledata];
			};

		// Fetch data array, call it before any other routine otherwise no error msg
		var jqplotbubbledata = dataRenderer();

		// Error message handling
		if ( errMsg.length > 0 ){
			this.html( errMsg ).css( { 'class' : 'error', 'height' : 20 , 'margin' : '5px 5px 5px 5px', 'color': 'red' } );
		}else{
			this.srfjqPlotBubbleChart( { 'id' : options.id, 'barData' : jqplotbubbledata, 'data' : data } );
		}
	};

	// Bubble plotting
	$.fn.srfjqPlotBubbleChart = function( options ) {
		var data = options.data;

		$.jqplot.config.enablePlugins = true;

		var jqplotbubble = $.jqplot( options.id , options.barData, {
			// dataRenderer: dataRenderer,
			title: data.parameters.charttitle,
			seriesColors: data.parameters.seriescolors ? data.parameters.seriescolors : ( data.parameters.colorscheme === null ? null : colorscheme[data.parameters.colorscheme][9] ),
			grid: data.parameters.grid,
			seriesDefaults: {
				renderer: data.renderer === 'bubble' ? $.jqplot.BubbleRenderer : $.jqplot.PieRenderer,
				shadow: data.parameters.theme !== 'simple',
				rendererOptions: {
					autoscalePointsFactor: -0.15,
					autoscaleMultiplier: 0.85,
					highlightMouseOver: true,
					bubbleGradients: true,
					bubbleAlpha: 0.7
				}
			},
			legend: {
				show: data.parameters.chartlegend !== 'none',
				location: data.parameters.chartlegend,
				// labels: data['legendLabels'],
				placement: 'inside',
				xoffset: 10,
				yoffset:10
			}
		} );

		// Call theming
		this.srfjqPlotTheme( { 'plot' : jqplotbubble, 'theme' : data.parameters.theme } );
	};
} )( window.jQuery );