/*!
 * VisualEditor user interface WikiaMapInsertDialog class.
 */

/*global wgCityId, mw */

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
	// Parent constructor
	ve.ui.WikiaMapInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMapInsertDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.WikiaMapInsertDialog.static.name = 'wikiaMapInsert';

ve.ui.WikiaMapInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-map-insert-title' );

// as in OO.ui.WindowManager.static.sizes
ve.ui.WikiaMapInsertDialog.static.size = '717px';

ve.ui.WikiaMapInsertDialog.static.learnMoreUrl = 'http://maps.wikia.com/wiki/Maps_Wiki';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaMapInsertDialog.prototype.getBodyHeight = function () {
	return 600;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaMapInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaMapInsertDialog.super.prototype.initialize.call( this );

	this.panels = {
		loading: new OO.ui.PanelLayout( { $: this.$ } ),
		empty: new OO.ui.PanelLayout( { $: this.$ } ),
		results: new OO.ui.PanelLayout( { $: this.$ } )
	};

	//this.setupLoadingPanel();
	this.setupEmptyPanel();
	this.setupResultsPanel();

	this.stackLayout = new OO.ui.StackLayout( { $: this.$ } );
	this.stackLayout.addItems( [
		this.panels.loading,
		this.panels.empty,
		this.panels.results
	] );

	this.stackLayout.$element.appendTo( this.$body );
	this.$content.addClass( 've-ui-wikiaMapInsertDialog' );

	if ( localStorage ) {
		this.$( window ).on( 'storage', function ( e ) {
			if ( e.originalEvent.key === 'mapCreated' && e.originalEvent.newValue ) {
				this.gettingMaps = null;
				this.loadMaps();
			}
		}.bind( this ) );
	}
};

ve.ui.WikiaMapInsertDialog.prototype.setupResultsPanel = function () {
	var $headline = this.$( '<div>' ),
		$headlineText = this.$( '<div>' ),
		headlineButton = new OO.ui.ButtonWidget( { label: ve.msg( 'wikia-visualeditor-dialog-wikiamapinsert-create-button' ), flags: 'primary' } );

	$headline.addClass( 've-ui-wikiaMapInsertDialog-results-headline' );

	$headlineText
		.addClass( 've-ui-wikiaMapInsertDialog-results-headline-text' )
		.html( ve.msg( 'wikia-visualeditor-dialog-wikiamapinsert-headline', this.constructor.static.learnMoreUrl ) )
		.appendTo( $headline );

	headlineButton.$element
		.addClass( 've-ui-wikiaMapInsertDialog-results-headline-button' )
		.appendTo( $headline );
	headlineButton.on( 'click', this.onCreateClick.bind( this ) );

	this.resultsWidget = new ve.ui.WikiaMediaResultsWidget( { $: this.$ } );
	this.resultsWidget.on( 'select', this.onMapSelect.bind( this ) );
	this.selectWidget = this.resultsWidget.getResults();

	this.panels.results.$element.append( $headline, this.resultsWidget.$element );
};

ve.ui.WikiaMapInsertDialog.prototype.setupEmptyPanel = function () {
	var $content = this.$( '<div>' ),
		$headline = this.$( '<div>' ),
		$text = this.$( '<div>' ),
		button = new OO.ui.ButtonWidget( {
			$: this.$,
			label: ve.msg( 'wikia-visualeditor-dialog-wikiamapinsert-create-button' ),
			flags: [ 'primary' ]
		} );

	$content.addClass( 've-ui-wikiaMapInsertDialog-empty-content' );

	$headline
		.addClass( 've-ui-wikiaMapInsertDialog-empty-headline' )
		.html( ve.msg( 'wikia-visualeditor-dialog-wikiamapinsert-empty-headline' ) )
		.appendTo( $content );

	$text
		.addClass( 've-ui-wikiaMapInsertDialog-empty-text' )
		.html( ve.msg( 'wikia-visualeditor-dialog-wikiamapinsert-empty-text', this.constructor.static.learnMoreUrl ) )
		.appendTo( $content );

	button.$element
		.addClass( 've-ui-wikiaMapInsertDialog-empty-button' )
		.appendTo( $content );
	button.on( 'click', this.onCreateClick.bind( this ) );

	$content.appendTo( this.panels.empty.$element );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaMapInsertDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaMapInsertDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.inserting = null;
			this.stackLayout.setItem( this.panels.loading );
			this.loadMaps();
		}, this );
};

ve.ui.WikiaMapInsertDialog.prototype.loadMaps = function () {
	this.getMaps().done( this.showResults.bind( this ) );
};

ve.ui.WikiaMapInsertDialog.prototype.getMaps = function () {
	var deferred;
	if ( !this.gettingMaps ) {
		deferred = $.Deferred();
		$.ajax( {
			dataType: 'json',
			url: mw.config.get( 'interactiveMapsApiURL' ) + '/map?city_id=' + wgCityId
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
	return this.gettingMaps;
};

ve.ui.WikiaMapInsertDialog.prototype.showResults = function ( data ) {
	var items, i;
	if ( data.length > 0 ) {
		this.stackLayout.setItem( this.panels.results );
		items = [];
		for ( i = 0; i < data.length; i++ ) {
			items.push( {
				type: 'map',
				id: data[i].id,
				title: data[i].title,
				url: data[i].image
			} );
		}
		this.selectWidget.clearItems();
		this.resultsWidget.addItems( items );
	} else {
		this.stackLayout.setItem( this.panels.empty );
	}
};

ve.ui.WikiaMapInsertDialog.prototype.onMapSelect = function ( option ) {
	if ( !this.inserting ) {
		this.inserting = true;
		this.getFragment().collapseToEnd().insertContent( [
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
		ve.track( 'wikia', {
			action: ve.track.actions.ADD,
			label: 'dialog-map-insert'
		} );
	}
};

ve.ui.WikiaMapInsertDialog.prototype.onCreateClick = function () {
	window.open( new mw.Title( 'Special:Maps' ).getUrl() + '#createMap' );
	ve.track( 'wikia', {
		action: ve.track.actions.ADD,
		label: 'dialog-map-create'
	} );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaMapInsertDialog );
