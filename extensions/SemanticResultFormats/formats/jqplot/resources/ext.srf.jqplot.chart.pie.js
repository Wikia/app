/**
 * JavaSript for SRF jqPlot pie module
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

	/*global colorscheme:true*/

	// Pie/donut handling
	$.fn.srfjqPlotPieChart = function( options ) {
		var data = options.data;

		// Handle data array
		var jqplotpiedata = [];

		var dataRenderer = function() {
				jqplotpiedata = data.data;
			// jqplotpiedata.push( data.data );
			return jqplotpiedata;
		};

		// Default settings
		var seriesDefaults = {
			renderer: data.renderer === 'donut' ? $.jqplot.DonutRenderer : $.jqplot.PieRenderer,
			shadow: data.parameters.theme !== 'simple',
			rendererOptions: {
				fill: data.parameters.filling,
				lineWidth: 2,
				showDataLabels: ( data.parameters.datalabels === 'percent' || data.parameters.datalabels === 'value' || data.parameters.datalabels === 'label' ? true : false ),
				dataLabels: data.parameters.datalabels,
				sliceMargin: 2,
				dataLabelFormatString: data.parameters.datalabels === 'label' ? null : ( !data.parameters.valueformat ? '%d' : data.parameters.valueformat )
			}
		};

		// Activate plug-ins
		$.jqplot.config.enablePlugins = true;

		// Render plot
		var jqplotpie = $.jqplot( options.id, [] , {
			dataRenderer: dataRenderer,
			title: data.parameters.charttitle,
			seriesColors: data.parameters.seriescolors ?  data.parameters.seriescolors :  ( data.parameters.colorscheme === null ? null : colorscheme[data.parameters.colorscheme][9] ),
			grid: data.parameters.grid,
			highlighter: { show: false },
			cursor: { show: false },
			seriesDefaults: seriesDefaults,
			legend: {
				show: data.parameters.chartlegend !== 'none',
				location: data.parameters.chartlegend,
				placement: 'inside',
				xoffset: 10,
				yoffset:10
			}
		} ); // end of jqplot object

		// Call theming
		this.srfjqPlotTheme( { 'plot' : jqplotpie, 'theme' : data.parameters.theme } );
	};
} )( window.jQuery );