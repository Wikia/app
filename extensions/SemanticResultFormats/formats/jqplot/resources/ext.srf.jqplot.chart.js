/**
 * JavaScript for SRF jqPlot chart/series module
 * @see http://www.semantic-mediawiki.org/wiki/Help:Jqplotchart format
 * @see http://www.semantic-mediawiki.org/wiki/Help:Jplotseries format
 *
 * @since 1.8
 * @release 0.3
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( $, srf ) {
	'use strict';

	/*global mw:true*/

	////////////////////////// PRIVATE METHODS ////////////////////////

	var util = new srf.util();

	// Browser information
	var profile = $.client.profile();

	// Attribute information can only be gathered after they have been applied to
	// an element
	function _getElementAttribute( options ){
		var p = $("<p></p>").hide().appendTo( options.context ).addClass( options.className ),
			value = parseInt( p.css( options.attribute ), 10 );
			p.remove();
		return value;
	}

	////////////////////////// PUBLIC METHODS ////////////////////////

	// Global jqplot container handling
	$.fn.srfjqPlotChartContainer = function() {

		var chart = this,
			container = chart.find( ".container" ),
			chartID   = container.attr( "id" ),
			height    = container.height(),
			width     = container.width(),
			json      = mw.config.get( chartID );

		// Parse json string and convert it back
		var data = typeof json === 'string' ? jQuery.parseJSON( json ) : json;

		var adjustChartElement = 'srf-jqplot-chart-adjust ' + data.parameters.gridview + ' ' + profile.name,
			adjustTableElement = 'srf-jqplot-table-adjust ' + data.parameters.gridview + ' ' + profile.name,
			adjustTextElement = 'srf-jqplot-text-adjust ' + data.parameters.gridview + ' ' + profile.name;

		// Assign height/width important when dealing with % values
		chart.css( { 'height': height , 'width': width } );
		container.css( {
			'height': chart.height() - _getElementAttribute( { context: container, className: adjustChartElement,  attribute: 'height' } ),
			'width': chart.width() - _getElementAttribute( { context: container, className: adjustChartElement,  attribute: 'width' } )
		} );

		// Hide processing image
		util.spinner.hide( { context: chart } );

		// Release chart/graph
		container.show();

		// Was reported to solve some memory leak problems on IE in connection with
		// canvas objects
		container.find( 'canvas' ).remove();

		// Call gridview plugin
		if ( data.parameters.gridview === 'tabs' ){
			// Set options
			var options ={
					'context'    : chart,
					'id'         : chartID,
					'container'  : container,
					'widthBorder': _getElementAttribute( { context: container, className: adjustTableElement, attribute: 'width' } ),
					'info'       : data.parameters.infotext,
					'data'       : data
				};

			// Grid view instance
			new srf.util.grid( options );
		}

		// Tabs height can vary (due to CSS) therefore after tabs instance was
		// created get the height
		var _tabsHeight = chart.find( '.ui-tabs-nav' ).outerHeight();

		// Add chart text
		var chartText = data.parameters.charttext,
			chartTextHeight = 0;
		if ( chartText.length > 0 ) {
			container.prepend( '<div id="' + chartID + '-text' + '" class="srf-jqplot-chart-text">' + chartText + '</div>' );
			container.find( '.srf-jqplot-chart-text' )
				.addClass( ( data.parameters.gridview === 'tabs' ? 'tabs ' + data.renderer : data.renderer ) );
			chartTextHeight = container.find( '.srf-jqplot-chart-text' ).height() +
			_getElementAttribute( { context: container, className: adjustTextElement,  attribute: 'height' } ) ;
		}

		// Adjust height and width according to current customizing
		container.css( { height: container.height() - _tabsHeight } );
		// Get height,width for plotting area
		width = container.width();
		height = container.height() - chartTextHeight;

		// Plotting area
		var plotID = chartID + '-plot';
		container.prepend( '<div id="' + plotID + '" class="srf-jqplot-plot"></div>' );
		var plot = chart.find( '.srf-jqplot-plot' );
		plot
			.css( { 'height': height, 'width': width } )
			.addClass( ( data.parameters.gridview === 'tabs' ? 'tabs ' + data.renderer : data.renderer ) );

		// Chart plotting
		if ( data.renderer === 'pie' || data.renderer === 'donut' ){
			plot.srfjqPlotPieChart( { 'id' : plotID, 'height' : height, 'width' : width, 'chart' : container, 'data' : data } );
		} else if ( data.renderer === 'bubble' ){
			plot.srfjqPlotBubbleChartData( { 'id' : plotID, 'height' : height, 'width' : width, 'chart' : container, 'data' : data } );
		} else {
			plot.srfjqPlotBarChartData( { 'id' : plotID, 'height' : height , 'width' : width , 'chart' : container, 'data' : data } );
		}

	};

	// Theming
	$.fn.srfjqPlotTheme = function( options ) {
		/*global simple:true, vector:true*/

		// Reposition chart text to adjust for the tick label margin
		var textmargin = this.find( '.jqplot-axis.jqplot-yaxis').width();
		this.find( '.srf-jqplot-chart-text' ).css( { 'margin-left': textmargin , 'display': 'block'} );

		// Theming support for commonly styled attributes of plot elements
		// using jqPlot's "themeEngine"
		options.plot.themeEngine.newTheme( 'simple', simple );
		options.plot.themeEngine.newTheme( 'vector', vector );

		// Only overwrite the default for cases with a theme
		if ( options.theme !== null ){
			options.plot.activateTheme( options.theme );
		}
	};

	////////////////////////// IMPLEMENTATION ////////////////////////

	$( document ).ready( function() {
		// Check if eachAsync exists, and if so use it to increase browsers responsiveness
		if( $.isFunction( $.fn.eachAsync ) ){
				$( "[class^=srf-jqplot]" ).eachAsync( {
				delay: 100,
				bulk: 0,
				loop: function(){
					$( this ).srfjqPlotChartContainer();
				}
			} );
		}else{
			$( "[class^=srf-jqplot]" ).each( function() {
				$( this ).srfjqPlotChartContainer();
			} );
		}
	} );
} )( jQuery, semanticFormats );