/**
 * JavaScript for SRF GridView plugin
 * @see http://www.semantic-mediawiki.org/wiki/Help:Gridview
 *
 * @since 1.8
 * @release 0.3
 *
 * @file
 * @ingroup SRF
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( srf, $ ) {

	"use strict";

	/*global mw:true semanticFormats:true*/

	////////////////////////// PRIVATE METHODS //////////////////////////

	var h = mw.html;
	var UI_BASE = 'srf-gridview';

	/**
	 * Add tab li element
	 * @var Object
	 */
	function _addTabLink( tab ){
		return '<li><a href="#' + tab.id + '">' + tab.msg +'</a></li>';
	}

	/**
	 * Add tab element
	 * @var Object
	 */
	function _addTabElement( options ){
		return options.context.after( h.element( 'div', {
			'id' : options.id,
			'class' : options.elemClass
			}, new h.Raw( options.content )
		) );
	}

	/**
	 * Transform data into a structure like counter, series, data item, data value
	 * @var array
	 */
	function _transformData( options ){
		var gridData = [],
			counter = 0;

		// Data array
		for ( var j = 0; j < options.data.length; ++j ) {
			var ttSeries = options.series[j];
			for ( var i = 0; i < options.data[j].length; ++i ) {
				var row = { id: ++counter , series: ttSeries.label, item: options.data[j][i][0], value: options.data[j][i][1] };
				gridData.push( row );
			}
		}
		return gridData;
	}

	////////////////////////// PUBLIC INTERFACE /////////////////////////

	// Should be initialized but if it isn't create an object
	srf.util = srf.util || {};

	/**
	 * Constructor
	 * Class reference by using new srf.util.grid( options );
	 *
	 * @var Object
	 */
	srf.util.grid = function( settings ) {

		// Set general class and id identifier
		var options = $.extend( {
			'tableID' : settings.id + '-grid',
			'pagerID' : settings.id + '-grid-pager',
			'baseClass' : UI_BASE,
			'tableClass': UI_BASE + '-table',
			'pageClass' : UI_BASE + '-table-pager',
			'queryClass': UI_BASE + '-query-link'
		}, settings );

		$.extend( this, options );

		// Self-invoked init() for direct access to the class reference
		this.init();
	};

	srf.util.grid.prototype = {
		/**
		 * Initializes grid called by the constructor
		 * @var Object
		 */
		init: function () {
			var options = this;
			return this.context.each( function() {

				var obj = $( this ),
					//options = this,
					height = obj.height(),
					width =  options.widthBorder !== undefined ? obj.width() - options.widthBorder : obj.width() - 30,
					tabs = [];

				// Tabs definition
				tabs.chart = _addTabLink( { id: options.id, msg: mw.msg( 'srf-ui-gridview-label-chart-tab' ) } );
				tabs.data  = _addTabLink( { id: options.id + '-data', msg: mw.msg( 'srf-ui-gridview-label-data-tab' ) } );
				tabs.info  = _addTabLink( { id: options.id + '-info', msg: mw.msg( 'srf-ui-gridview-label-info-tab' ) } );

				// Add tab navigation
				obj.prepend( '<ul>' + tabs.chart +
					( options.data.data !== undefined && options.data.data.length > 0 ? tabs.data : '' ) +
					( options.info !== undefined && options.info !== '' ? tabs.info : '' ) + '</ul>'
				);

				var containerContext = obj.find( '.container' );

				// Add info tab element
				if ( options.info !== undefined && options.info !== '' ){
					_addTabElement( {
						context: containerContext,
						content: options.info,
						id : options.id + '-info',
						elemClass: options.baseClass + '-info-tab'
					} );
				}

				// Add data tab element
				if ( options.data.data !== undefined && options.data.data.length > 0 ){
					_addTabElement( {
						context: containerContext,
						content: '',
						id : options.id + '-data',
						elemClass: options.baseClass + '-data-tab'
					} );
				}

				// Init data table
				var tableContext = obj.find( '#' + options.id + '-data');

				tableContext
					.prepend( '<table id="' + options.tableID + '" class="' + options.tableClass + '"></table>' )
					.prepend( '<div id="' + options.pagerID + '" class="' + options.pagerClass + '"></div>' );
				tableContext
					.css( { width: width, height: height } );

				// Create tabs ui
				obj.tabs();

				// Tabs height can vary (due to CSS) therefore after tabs instance was
				// created get the height
				var _tabs = obj.find( '.ui-tabs-nav' );

				// Create Special:Ask query link [+]
				if ( mw.config.get( 'wgCanonicalSpecialPageName' ) === 'Ask' || options.data.sask === undefined ){
					obj.find( '.' + options.queryClass )
						.empty();
				} else {
					_tabs.prepend( '<span class="' + options.queryClass + '">' + options.data.sask + '</span>' );
					obj.find( '.' + options.queryClass )
						.find( 'a' )
						.attr( 'title', mw.msg( 'ask' ) );
				}

				var gridContext = obj.find( '.' + options.tableClass ),
					columnWidth = ( width / 2 ) - 5,
					tableHeight = height - 100 - _tabs.outerHeight();

				// Adopt data item output
				var colModelItem = '';
				if ( options.data.fcolumntypeid === '_dat' ) {
					// Fetch default date display
					var dateFormat = mw.user.options.get( 'date' );
					if ( dateFormat.indexOf( 'ISO' ) >= 0 ){
						dateFormat = "Y-m-d H:i:s";
					} else {
						dateFormat = 'd M Y';
					}

					colModelItem = {
						name:'item',
						index:'item',
						width: columnWidth,
						align:'center',
						sorttype:'date',
						formatter:'date',
						formatoptions: { srcformat: 'U', newformat: dateFormat }
						};
				} else {
					colModelItem = { name:'item', index:'item', width: columnWidth };
				}

				// Create grid instance
				// @see http://www.trirand.com/jqgridwiki/doku.php
				gridContext.jqGrid( {
					datatype: 'local',
					data: _transformData( { data: options.data.data, series: options.data.series } ),
					colNames:[
						'id',
						mw.msg( 'srf-ui-gridview-label-series' ),
						mw.msg( 'srf-ui-gridview-label-item' ),
						mw.msg( 'srf-ui-gridview-label-value' )
					],
					colModel :[
						{ name:'id', index:'id', sorttype: 'int', hidden:true },
						{ name:'series', index:'series', width: 0 },
						colModelItem,
						{ name:'value', index:'value', width: columnWidth, align:"right" }
					],
					pager: '#' + options.pagerID ,
					height: tableHeight,
					rowList:[10,20,30,40,50],
					ignoreCase: true,
					grouping:true,
					groupingView : {
						groupField : ['series'],
						groupColumnShow : [false]
					},
					sortname: 'item',
					sortorder: 'asc',
					viewrecords: true,
					hidegrid: false
				} );

				// Init column search
				gridContext.jqGrid( 'filterToolbar', {
					stringResult: true,
					searchOnEnter: false,
					defaultSearch: "cn"
				} );
			} );
		},

		resize: function( ){
		// Do something here
		}
	};

} )( semanticFormats, jQuery);