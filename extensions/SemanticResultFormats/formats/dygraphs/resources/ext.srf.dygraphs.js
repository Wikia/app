/**
 * JavaScript for SRF dygraphs module
 * @see http://www.semantic-mediawiki.org/wiki/Help:Dygraphs format
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
( function( $, mw, srf ) {
	'use strict';

	/*global mw:true Dygraph:true mediaWiki:true*/

	////////////////////////// PRIVATE METHODS ////////////////////////

	var util = new srf.util();
	var tooltip = new smw.util.tooltip();

	/**
	 * Add icon image
	 *
	 * @return object
	 */
	var _addIcon = function( options ){
		var h = mw.html,
			icon = h.element( 'span', { 'class' : options.className, 'style': 'display:inline;' },
			new h.Raw( h.element( 'img', {
					src: mw.config.get( 'wgExtensionAssetsPath' ) + '/SemanticMediaWiki/resources/images/' + options.image,
					title: options.title
				}
			) )
		);
		return icon;
	},

	/**
	 * Add checkbox element
	 *
	 * @return object
	 */
	_addCheckboxItem = function( options ){
		var item = '';
			$.each( options.array, function( index, value ) {
				item +='<input type=checkbox class="' + options.className + '" id=' + index + ' checked><label for="' + index +'">'+ value + '</label><br />';
			} );
		return item;
	},

	/**
	 * Add chart text element
	 *
	 * @return number
	 */
	_addChartText =	function( options ){
		if( options.text.length > 0 ){
			options.instance.after( '<span class="' + options.className + ' ' + options.extraClass + '">' + options.text + '</span>' );
			return options.instance.next().height();
		} else {
			return 0;
		}
	},

	/**
	 * Add chart source element
	 *
	 * @return number
	 */
	_addChartSource = function( options ){
		if( options.source.length > 0 ){
			options.instance
				.after( '<span class="' + options.className + ' ' + options.extraClass + '">' + '[ ' + options.source + ' ]</span>' );

			// Don't browse the whole DOM tree, just use the next element we created
			// and adopt the title
			var object = options.instance.next();
			object.find( 'a' ).text( options.sourceTitle );
			return object.height();
		} else {
			return 0;
		}
	};

	////////////////////////// PUBLIC METHODS ////////////////////////

	$.fn.extend( {
		srfdygraphs: function( options ) {
			return this.each( function() {

				var chart = $(this),
					container = chart.find( '.container' ),
					chartID   = container.attr( 'id' ),
					json      = mw.config.get( chartID );

			// Parse json string
			var data = typeof json === 'string' ? jQuery.parseJSON( json ) : json;

			/**
			 * @var plotClass identifies the class that holds the plot
			 * @var plotID identifies the ID that holds the plot mainly used by dygraphs
			 *
			 * Instances
			 *
			 * plotInstance = plotting area
			 * container  = all additional elements
			 * chart = container + processing
			 */
			var plotClass = 'srf-dygraphs-plot',
				plotInstance  = '',
				seriesInstance = '',
				plotID = chartID + '-plot',
				width = data.parameters.width,
				height = data.parameters.height,
				h = mw.html;

			// Fetch the data from the source
			getData( data );

			/**
			 * Release the container and hide the processing image
			 *
			 */
			function showContainer(){
				container.show();
				util.spinner.hide( { context: chart } );
			}

			/**
			 * Instead of dygraphs making a var req = new XMLHttpRequest()
			 * we fetch the data via ajax
			 *
			 */
			function getData( options ){

				var jqxhr = $.ajax( {
					url: options.data.source.url
				} )
				.done(function( data ) {

					// What we try to do here is that people might start adding [[Category]] or worst
					// {{#subobject}} annotions within the same raw data and to avoid any possible
					// interference delete all [[]] and {{}} tags from the raw data
					var rawData = data.replace(/\[\[(.*)\]\]|\{\{(.*)\}\}/igm, '' );

					// Try the filter first line and find the labels used
					var line_delimiter = Dygraph.detectLineDelimiter( rawData );
					var delim = ',';
					var lines = rawData.split( line_delimiter || "\n", 1 );
					var labels = lines[0].split( delim );

					// In aynchronous mode only now are we able to proceed
					prepareContainer( { labels: labels } );
					initGraph( { data: rawData, labels: labels } );
				} )
				.fail(function( error ) {
					// Release visual container
					showContainer();

					var responseText = error.responseText !== '' ?  ' (' + error.responseText + ')' : '';

					// Init error tooltip
					tooltip.add( {
						targetClass: 'smwtticon warning',
						context: container,
						title: mw.msg( 'smw-ui-tooltip-title-warning' ),
						type: 'warning',
						button: true,
						content: mw.msg(
							'srf-ui-common-label-ajax-error',
							h.element( 'a', { 'href' : options.data.source.url }, mw.msg( 'srf-ui-common-label-request-object', responseText ) ),
							h.element( 'a', { 'href' : 'http://www.semantic-mediawiki.org/wiki/Help:Ajax' }, mw.msg( 'srf-ui-common-label-help-section' ) ) )
					} );
				} )
				.always(function( complete ) {
				} );
			}

			/**
			 * Visual instance for displaying the container content
			 *
			 */
			function prepareContainer( options ){

				// Set overall chart height and width
				chart.css( { 'height': height , 'width': width } );

				// Add the plotting area
				container.prepend( h.element( 'div', { 'id': plotID , 'class' : plotClass }, null ) );
				plotInstance = container.find( '.' + plotClass );

				// Adjustments for cases where jquery ui is involved
				// @var addedHeight collects heights of objects other that the chart in order
				width = chart.width() - ( data.parameters.gridview === 'tabs' ? 30 : 0 );
				height = height - ( data.parameters.gridview === 'tabs' ? 20 : 20 );

				// Release container in order to measure adjustments
				showContainer();

				height = height - _addChartSource( {
					instance: plotInstance,
					source: ( data.data.source.subject !== undefined ? data.data.source.subject : data.data.source.link !== undefined ? data.data.source.link : null ),
					extraClass: data.parameters.gridview,
					sourceTitle: mw.msg( 'srf-ui-common-label-datasource' ),
					className: 'srf-ui-chart-source'
				} );

				height = height - _addChartText( {
					instance: plotInstance,
					text: data.parameters.charttext,
					extraClass: data.parameters.gridview,
					className: 'srf-ui-chart-text'
				} );

				// Adjust height and width after text etc. has been generated
				container.css( { 'height': height, 'width': width } );

				// Fit the plotting area
				container.find( '.' + plotClass ).css( { 'height': height , 'width': width } );
			}

			/**
			 * GridView plugin
			 *
			 */
			function initGridView(){
				var dataSeries = [],
					dataTable = [];

				// Prepare datatable
				if ( data.data.source.annotation !== undefined ){
					$.map( data.data.source.annotation , function( val ){
						dataSeries.push ( { label: val.series } );
						dataTable.push ( [[ val.shortText + ' (' + val.text + ')', val.x]] );
					} );
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
						'sask'  : data.sask
					}
				};

				// Grid view instance
				new srf.util.grid( gridOptions );
			}

			/**
			 * Prepare annotations
			 *
			 */
			function getAnnotations ( annotations ){
				if ( annotations !== undefined ){
					$.map( annotations , function(key){
						// Determine correct width of the shortText (use a <div> as vehicle)
						// and not the length (such as key.shortText.length)
						var o = $('<div>' + key.shortText + '</div>')
							.css( {'position': 'absolute', 'float': 'left', 'white-space': 'nowrap', 'visibility': 'hidden'} )
							.appendTo( container );
							key.width = o.width() + 5;
							o.remove();
					} );
				return annotations;
				}
			}

			/**
			 * Generate checkboxes from available lables and initialize/show
			 * the tooltip with available options
			 *
			 */
			function getSeries( options ){
				// Slice from position 1 because the 0 is the x-value descriptor wich is not needed here
				var seriesItem = _addCheckboxItem( {
					array : options.labels.slice(1),
					className : 'srf-dygraphs-series-item'
				} );

				// Create option set which is displayed as tooltip to safe space and
				// only displays it when the user demands it
				tooltip.add( {
					contextClass: 'srf-dygraphs-series',
					contentClass: 'srf-dygraphs-series-content',
					targetClass : 'srf-dygraphs series icon',
					context: container.find( '.srf-ui-chart-source' ),
					title: mw.msg( 'srf-ui-tooltip-title-scope' ),
					type: 'info',
					button: true,
					content: seriesItem
				} );

				// Store seriesInstance
				seriesInstance = container.find( '.srf-dygraphs-series-item' );
			}

			/**
			 * Create dygraph instance
			 *
			 * @see http://dygraphs.com/
			 *
			 */
			function initGraph( options ){

				var g = new Dygraph(
					document.getElementById( plotID ),
					function() { return options.data; },{
						rollPeriod: data.parameters.rollerperiod,
						showRoller: data.parameters.rollerperiod > 0 ? true : false,
						title: data.parameters.charttitle,
						ylabel: data.parameters.ylabel,
						xlabel: data.parameters.xlabel,
						labelsKMB: true,
						customBars: data.parameters.errorbar === 'range',
						fractions: data.parameters.errorbar === 'fraction',
						errorBars: data.parameters.errorbar === 'sigma',
						legend: 'always',
						//labels: data.parameters.group === 'label' ? dataSeriesLabel : data.parameters.datasource !== 'file' ? null : dataSeriesLabel,
						labelsDivStyles: { 'textAlign': 'right', 'background': 'transparent' },
						labelsSeparateLines: true,
						underlayCallback: function(canvas, area, g) {

							// Allow background to be white
							canvas.fillStyle = 'white';
							canvas.fillRect(area.x, area.y, area.w, area.h);
						},

						// drawCallback gets called every time the dygraph is drawn. This includes
						// the initial draw, after zooming and repeatedly while panning
						// @see http://dygraphs.com/options.html#Callbacks
						drawCallback: function(g, is_initial) {
							if ( !is_initial ){
								return;
							} else {

								// GridView plug-in processing
								if ( data.parameters.gridview === 'tabs' ) {
									initGridView();
								}

								// Adjust table height due to possible changes initiated by the
								// jquery ui tabs
								var tabsHeight = chart.find( '.ui-tabs-nav' ).outerHeight() ;
								plotInstance.css( { height: plotInstance.height() - tabsHeight } );
								g.resize();

								// Create and display annotations
								var annotations = getAnnotations( data.data.source.annotation );
								if ( annotations !== undefined ){
									g.setAnnotations( annotations );
								}
							}
						}
					}
				);

				// Get series labels and create series label tooltip
				getSeries( {labels: options.labels } );

				// Catch series label toggle change and set visibility
				seriesInstance.change( function( el ){
					g.setVisibility( $(this).attr('id'), el.currentTarget.checked );
				} );
			}
		} );
		}
	} );

	////////////////////////// IMPLEMENTATION ////////////////////////

	/**
	 * Dygraphs
	 *
	 * If eachAsync is available call each instance as async in order
	 * to increase browsers responsiveness
	 */
	var dygraphs = {
		init: function () {
			$( document ).ready( function() {
				if( $.isFunction( $.fn.eachAsync ) ){
						$( '.srf-dygraphs' ).eachAsync( {
						delay: 100,
						bulk: 0,
						loop: function(){
							$( this ).srfdygraphs();
						}
					} );
				} else {
					$( '.srf-dygraphs' ).each( function() {
						$( this ).srfdygraphs();
					} );
				}
			} );
	} };

	/**
	 * Check browser profile
	 *
	 * IE sucks because of that we have to jump some loops here to ensure that
	 * for < IE9 excanvas module is loaded
	 */
	var p = $.client.profile();

	if ( p.name === 'msie' && p.versionNumber < 9 ) {
		// mw.loader.using( 'ext.dygraphs.excanvas', dygraphs.init );
		dygraphs.init();
	} else {
		dygraphs.init();
	}
} )( jQuery, mediaWiki, semanticFormats );