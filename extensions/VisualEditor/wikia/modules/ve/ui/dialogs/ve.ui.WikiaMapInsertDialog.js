/*!
 * VisualEditor user interface WikiaMapInsertDialog class.
 */

/*global wgCityId */

/**
 * Dialog for inserting Wikia map objects.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMapInsertDialog = function VeUiWikiaMapInsertDialog( config ) {
	config =  $.extend( config, {
		width: '717px'
	} );

	// Parent constructor
	ve.ui.WikiaMapInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMapInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaMapInsertDialog.static.name = 'wikiaMapInsert';

ve.ui.WikiaMapInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-map-insert-title' );

ve.ui.WikiaMapInsertDialog.static.icon = 'map';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaMapInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaMapInsertDialog.super.prototype.initialize.call( this );

	this.panels = {
		'loading': new OO.ui.PanelLayout( { '$': this.$ } ),
		'empty': new OO.ui.PanelLayout( { '$': this.$ } ),
		'results': new OO.ui.PanelLayout( { '$': this.$ } )
	};

	//this.setupLoadingPanel();
	this.setupEmptyPanel();
	this.setupResultsPanel();

	this.stackLayout = new OO.ui.StackLayout( { '$': this.$ } );
	this.stackLayout.addItems( [
		this.panels.loading,
		this.panels.empty,
		this.panels.results
	] );

	this.stackLayout.$element.appendTo( this.$body );
	this.frame.$content.addClass( 've-ui-wikiaMapInsertDialog' );
};

ve.ui.WikiaMapInsertDialog.prototype.setupResultsPanel = function () {
	var $headline = this.$( '<div>' ),
		$headlineText = this.$( '<div>' ),
		headlineButton = new OO.ui.ButtonWidget( { 'label': 'Create map' } );

	$headline.addClass( 've-ui-wikiaMapInsertDialog-results-headline' );

	$headlineText
		.addClass( 've-ui-wikiaMapInsertDialog-results-headline-text' )
		.html( 'Select an existing map or create a map to insert it. <a href="#">Learn more.</a>' )
		.appendTo( $headline ),

	headlineButton.$element
		.addClass( 've-ui-wikiaMapInsertDialog-results-headline-button' )
		.appendTo( $headline );

	this.resultsWidget = new ve.ui.WikiaMediaResultsWidget( { '$': this.$ } );
	this.resultsWidget.on( 'preview', ve.bind( this.onMapSelect, this ) );
	this.selectWidget = this.resultsWidget.getResults();

	this.panels.results.$element.append( $headline, this.resultsWidget.$element );
};
ve.ui.WikiaMapInsertDialog.prototype.setupEmptyPanel = function () {
	var $content = this.$( '<div>' ),
		$headline = this.$( '<div>' ),
		$text = this.$( '<div>' ),
		button = new OO.ui.ButtonWidget( {
			'$': this.$,
			'label': 'Create a map',
			'flags': [ 'primary' ]
		} );


	$content.addClass( 've-ui-wikiaMapInsertDialog-empty-content' );

	$headline
		.addClass( 've-ui-wikiaMapInsertDialog-empty-headline' )
		.html( 'There are no maps created yet' )
		.appendTo( $content );

	$text
		.addClass( 've-ui-wikiaMapInsertDialog-empty-text' )
		.html( 'Collaborate with community by visually pinning locations of interest on maps. <a href="#">Learn more.</a>' )
		.appendTo( $content );

	button.$element
		.addClass( 've-ui-wikiaMapInsertDialog-empty-button' )
		.appendTo( $content );

	$content.appendTo( this.panels.empty.$element );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaMapInsertDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaMapInsertDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.stackLayout.setItem( this.panels.loading );
			this.getMaps().done( ve.bind( this.showResults, this ) );
		}, this );
};

ve.ui.WikiaMapInsertDialog.prototype.getMaps = function() {
	var deferred;
	if ( !this.gettingMaps ) {
		deferred = $.Deferred();
		$.ajax( {
			dataType: 'json',
			url: 'http://dev-interactive-maps.wikia.nocookie.net/api/v1/map?city_id=' + wgCityId
		} )
		.done( function ( data ) {
			deferred.resolve( data.items );
		} )
		.fail( function () {
			// TODO: Add better error handling.
			deferred.resolve( [] );
		} );
		this.gettingMaps = deferred.promise();
	}
	return this.gettingMaps
};

ve.ui.WikiaMapInsertDialog.prototype.showResults = function( data ) {
	var items, i;
	if ( data.length > 0 ) {
		this.stackLayout.setItem( this.panels.results );
		items = [];
		for ( i = 0; i < data.length; i++ ) {
			items.push( {
				type: 'map',
				id: data[i].id,
				title: data[i].title,
				url: data[i].image,
			} );
		}
		this.selectWidget.clearItems();
		this.resultsWidget.addItems( items );
	} else {
		this.stackLayout.setItem( this.panels.empty );
	}
};

ve.ui.WikiaMapInsertDialog.prototype.onMapSelect = function ( option ) {
	this.getFragment().collapseRangeToEnd().insertContent( [
		{
			type: 'wikiaMap',
			attributes: {
				mw: {
					name: 'imap',
					body: { extsrc:'' },
					attrs: { 'map-id': option.getData().id.toString() }
				}
			}
		},
		{ type: '/wikiaMap' }
	] );
	this.close();
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaMapInsertDialog );
