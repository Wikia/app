/**
 * JavaScript for SRF timeseries
 * @see http://www.semantic-mediawiki.org/wiki/Help:Timeseries format
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

	var methods = {
		/**
		 * Initialization method
		 *
		 * @since 1.8
		 */
		init : function() {
			var chart = this,
				container = this.find( ".container" ),
				chartID   = container.attr( "id" ),
				json      = mw.config.get( chartID );

			// Parse json string and convert it back
			var data = typeof json === 'string' ? jQuery.parseJSON( json ) : json;

			/**
			 * @var plotClass identifies class that holds the plot
			 * @var addedHeight collects heights of objects other that the chart in order
			 * to be able to adjust the height of the chart and sray within the limits
			 * specified by the query printer
			 */
			var plotClass = 'srf-flot-plot',
				addedHeight = 0,
				width = data.parameters.width,
				height = data.parameters.height;

			// Extend option settings
			var settings = $.extend( {
				'height' : height,
				'width'  : width,
				'plotclass' : plotClass,
				'chartid' : chartID
			}, data );

			// Set chart height and width and reassign to catch px instead of % value
			container.css( { 'height': height, 'width': width } );
			chart.css( { 'height': container.height(), 'width': container.width() } );
			container.css( {
				'height': height - ( data.parameters.gridview === 'tabs' ? 20 : 0 ),
				'width': chart.width() - ( data.parameters.gridview === 'tabs' ? 20 : 0 )
			} );

			// Make sure to keep converted px values because canvas elements can't deal with %
			height = container.height();
			width = container.width();

			// Hide processing
			util.spinner.hide( { context: chart } );

			// Release chart container
			container.show();

			// Timeseries plot container
			container.prepend( '<div class="' + plotClass + '"></span>' );

			// Set-up chart title
			var chartTitle = data.parameters.charttitle;
			if ( chartTitle.length > 0 ) {
				container.find( '.' + plotClass )
					.before( '<span class="srf-flot-chart-title">' + chartTitle + '</span>' );
				addedHeight += container.find( '.srf-flot-chart-title' ).height();
			}

			// Set-up chart text
			var chartText = data.parameters.charttext;
			if ( chartText.length > 0 ) {
				container.find( '.' + plotClass )
					.after( '<span class="srf-flot-chart-text">' + chartText + '</span>' );
				container.find( '.srf-flot-chart-text' )
					.addClass( ( data.parameters.gridview === 'tabs' ? 'tabs' : '' ) );
				addedHeight += container.find( '.srf-flot-chart-text' ).height() - 20;
			}

			// Set-up zoom box
			var zoom  = '<div class="' + plotClass + '-zoom" style="height:50px"></div>';
			if ( data.parameters.zoom === 'top'){
				container.find( '.' + plotClass ).before( zoom ).css( 'width', width );
			}else if ( data.parameters.zoom === 'bottom' ){
				container.find( '.' + plotClass ).after( zoom ).css( 'width', width );
			}
			addedHeight += container.find( '.' + plotClass + '-zoom' ).height();

			// Keep the overall height and width and apply possible changes onto the chart
			height = height - addedHeight;

			// Handle jqGrid table
			if ( data.parameters.gridview === 'tabs' ) {
				// gridview declaration
				var dataSeries = [];
				var dataTable = [];
				var newRow = {};
				for ( var j = 0; j < data.data.length; ++j ) {
					newRow = { 'label' : data.data[j].label };
					dataSeries.push ( newRow );
					dataTable.push ( data.data[j].data );
				}

				// Set options
				var gridOptions = {
					'context'   : chart,
					'id'        : chartID,
					'container' : container,
					'info'      : data.parameters.infotext,
					'data' : {
						'series': dataSeries,
						'data'  : dataTable,
						'fcolumntypeid': data.fcolumntypeid,
						'sask'  : data.sask
					}
				};

				// Grid view instance
				new srf.util.grid( gridOptions );
			}

			// Tabs height can vary (due to CSS) therefore after tabs instance was
			// created get the height
			var _tabs = chart.find( '.ui-tabs-nav' );
			container.find( '.' + plotClass ).css( { 'height': height - _tabs.outerHeight() , 'width': width } );

			// Draw chart
			container.srfFlotTimeSeries( 'chart', settings );
		},
		/**
		 * Chart handling method
		 *
		 * @since 1.8
		 */
		chart : function( content ) {
			var plotArea = this.find( '.' + content.plotclass ),
				plotZoomArea = this.find( '.' + content.plotclass + '-zoom' ),
				data = content.data;

			// Javascript timestamp is the number of milliseconds since
			// January 1, 1970 00:00:00 UTC therefore * 1000
			// correct timestamps daily midnights in UTC+0100, add one hour to hit
			// the midnights in the plot
			function convertData( tseries ) {
				var ttData =[];
				var max = 0;
				var len=tseries.length;
					for ( var j = 0; j < len; ++j ) {
						ttData  = tseries[j].data;
							for ( var p = 0; p < ttData.length; ++p ) {
								ttData[p][0] = ( ttData[p][0] * 1000 ) + ( 60 * 60 * 1000 );
								max = max > ttData[p][1] ? max : ttData[p][1];
						}
					}
				return ttData;
			}

			// Data conversion
			convertData( data  );

			// Helper function for returning the weekends in a period
			function weekendAreas(axes) {
				var markings = [];
				var d = new Date(axes.xaxis.min);

				// go to the first Saturday
				d.setUTCDate(d.getUTCDate() - ( ( d.getUTCDay() + 1 ) % 7) );
				d.setUTCSeconds(0);
				d.setUTCMinutes(0);
				d.setUTCHours(0);
				var i = d.getTime();
				do {
					// when we don't set yaxis, the rectangle automatically
					// extends to infinity upwards and downwards
					markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
					i += 7 * 24 * 60 * 60 * 1000;
				} while (i < axes.xaxis.max);

				return markings;
			}

			// Set-up plot options
			var options = {
				xaxis: { mode: "time", tickLength: 5 },
				alignTicksWithAxis: 1,
				selection: { mode: content.parameters.zoom === 'top' || content.parameters.zoom === 'bottom' ? "x" : null },
				bars: content.parameters.charttype === 'bar' ? { show: true, barWidth: 0.6 } : false,
				colors: content.parameters.seriescolors,
				grid: { markings: weekendAreas, hoverable: true, clickable: true, borderColor: '#BBB', borderWidth: 1, backgroundColor: '#FFF' }
			};

			// Draw actual plot
			var plot = $.plot( plotArea , data, options );

			if ( content.parameters.zoom === 'top' || content.parameters.zoom === 'bottom' ){

				// Init zoom box
				var zoombox = $.plot( plotZoomArea , data , {
					series: {
						lines: content.parameters.charttype === 'bar' ? false: { show: true, lineWidth: 1 },
						bars:  content.parameters.charttype === 'bar' ? { show: true, barWidth: 0.6 } : false,
						shadowSize: 0
					},
					grid: { borderColor: '#BBB', borderWidth: 1, backgroundColor: '#FFF' },
					colors: content.parameters.seriescolors,
					legend: { show: false },
					xaxis: { ticks: [], mode: "time" , timeformat: "%y-%m-%d" },
					yaxis: { ticks: [], min: 0, autoscaleMargin: 0.1 },
					selection: { mode: "x" }
				} );

				// Connect zoom box and chart
				this.bind("plotselected", function (event, ranges) {
					if (ranges.xaxis.to - ranges.xaxis.from < 0.00001){
						ranges.xaxis.to = ranges.xaxis.from + 0.00001;
					}
					if (ranges.yaxis.to - ranges.yaxis.from < 0.00001){
						ranges.yaxis.to = ranges.yaxis.from + 0.00001;
					}

					// Calculate y-min and y-max for the selected x range
					var ymin, ymax;
					var plotdata = plot.getData();
						$.each(plotdata, function (e, val) {
						$.each(val.data, function (e1, val1) {
							if ((val1[0] >= ranges.xaxis.from) && (val1[0] <= ranges.xaxis.to)) {
								if (ymax == null || val1[1] > ymax) { ymax = val1[1]; }
									if (ymin == null || val1[1] < ymin) { ymin = val1[1]; }
								}
							} );
						} );

					ranges.yaxis.from = Math.round( ymin ).toFixed(0);
					ranges.yaxis.to   = Math.round( ymax + ( ymax / Math.log(ymax)/Math.log(10) ) ).toFixed(0);

				// Do the zooming
				plot = $.plot( plotArea , data ,
					$.extend(true, {}, options, {
						xaxis: { min: ranges.xaxis.from, max: ranges.xaxis.to },
						yaxis: { min: ranges.yaxis.from, max: ranges.yaxis.to }
					} )
				);

				// Don't fire event on the overview to prevent eternal loop
				zoombox.setSelection(ranges, true);
			} );

			plotZoomArea.bind("plotselected", function (event, ranges) {
				plot.setSelection(ranges);
			} );
		}
			// Tool tip for line chart
			function showTooltip(x, y, contents) {
				$('<div class="srf-flot-tooltip">' + contents + '</div>').css( {
					position: 'absolute',
					display: 'none',
					top: y + 5,
					left: x + 5,
					//border: '1px solid #0070A3',
					padding: '2px',
					// 'background-color': '#fee',
					opacity: 0.80
				} ).appendTo("body").fadeIn(200);
			}

			var b = function (i) {
					return i < 10 ? "0" + i : i;
				},
					h = function (i) {
						var l = i.getUTCFullYear() + "-" + b(i.getUTCMonth() + 1);
						return l + "-" + b( i.getUTCDate() );
				};

			var previousPoint = null;

			$( "#" + content.chartid ).bind("plothover", function (event, pos, item) {
				$("#x").text(pos.x.toFixed(2));
				$("#y").text(pos.y.toFixed(2));
					if (item) {
						if (previousPoint !== item.datapoint) {
								previousPoint = item.datapoint;
								$( '.srf-flot-tooltip' ).remove();
									var x = item.datapoint[0],
										y = item.datapoint[1];
									showTooltip(item.pageX, item.pageY, h( new Date( x ) ) + " : " + y );
						}
					} else {
							$( '.srf-flot-tooltip' ).remove();
								previousPoint = null;
					}
			} );
		}
	};

	/**
	 * Method handling
	 *
	 * @since 1.8
	 */
	$.fn.srfFlotTimeSeries = function( method ) {
		if ( methods[method] ) {
			return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ) );
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' + method + ' does not exist within the jQuery.srf.plugin pool' );
		}
	};

	$( document ).ready( function() {
		// Check if eachAsync exists, and if so use it to increase browsers responsiveness
		if( $.isFunction( $.fn.eachAsync ) ){
				$( ".srf-timeseries" ).eachAsync( {
				delay: 100,
				bulk: 0,
				loop: function(){
					$( this ).srfFlotTimeSeries();
				}
			} );
		}else{
			$( ".srf-timeseries" ).each( function() {
				$( this ).srfFlotTimeSeries();
			} );
		}
	} );
} )( jQuery, semanticFormats );