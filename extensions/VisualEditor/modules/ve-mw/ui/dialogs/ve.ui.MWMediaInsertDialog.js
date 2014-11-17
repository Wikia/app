/*!
 * VisualEditor user interface MediaInsertDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaInsertDialog = function VeUiMWMediaInsertDialog( config ) {
	// Configuration initialization
	config = ve.extendObject( { 'footless': true }, config );

	// Parent constructor
	ve.ui.Dialog.call( this, config );

	// Properties
	this.sources = {};
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.MWMediaInsertDialog.static.name = 'mediaInsert';

ve.ui.MWMediaInsertDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-media-insert-title' );

ve.ui.MWMediaInsertDialog.static.icon = 'picture';

/* Methods */

/**
 * Handle search result selection.
 *
 * @param {ve.ui.MWMediaResultWidget|null} item Selected item
 */
ve.ui.MWMediaInsertDialog.prototype.onSearchSelect = function ( item ) {
	var info, newDimensions, scalable, offset, structuralOffset;

	if ( item ) {
		info = item.imageinfo[0];
		// Create a scalable for calculations
		scalable = new ve.dm.Scalable( {
			'originalDimensions': {
				'width': info.width,
				'height': info.height
			}
		} );

		// Resize to default thumbnail size, but only if the image itself
		// isn't smaller than the default size
		// For svg/drawings, the default wiki size is always applied
		if ( info.width > this.defaultThumbSize || info.mediatype === 'DRAWING' ) {
			newDimensions = scalable.getDimensionsFromValue( {
				'width': this.defaultThumbSize
			} );
		} else {
			newDimensions = {
				'width': info.width,
				'height': info.height
			};
		}

		// Go to start of paragraph
		offset = this.getFragment().getRange().start;
		structuralOffset = this.getFragment().getDocument().data.getNearestStructuralOffset( offset, -1 );
		this.fragment = this.getFragment().clone( new ve.Range( structuralOffset ) );
		this.fragment.insertContent( [
			{
				'type': 'mwBlockImage',
				'attributes': {
					'type': 'thumb',
					'align': 'default',
					// Per https://www.mediawiki.org/w/?diff=931265&oldid=prev
					'href': './' + item.title,
					'src': info.thumburl,
					'width': newDimensions.width,
					'height': newDimensions.height,
					'resource': './' + item.title,
					'mediaType': info.mediatype,
					'defaultSize': true
				}
			},
			{ 'type': 'mwImageCaption' },
			{ 'type': '/mwImageCaption' },
			{ 'type': '/mwBlockImage' }
		] );

		this.close();
	}
};

/**
 * Get the object of file repos to use for the media search
 *
 * @returns {jQuery.Promise}
 */
ve.ui.MWMediaInsertDialog.prototype.getFileRepos = function () {
	var deferred = $.Deferred();

	// We will only ask for the ajax call if this.sources
	// isn't already set up
	if ( ve.isEmptyObject( this.sources ) ) {
		// Take sources from api.php?action=query&meta=filerepoinfo&format=jsonfm
		// The decision whether to take 'url' or 'apiurl' per each repository is made
		// in the MWMediaSearchWidget depending on whether it is local and has apiurl
		// defined at all.
		ve.init.target.constructor.static.apiRequest( {
			'action': 'query',
			'meta': 'filerepoinfo'
		} )
		.done( function ( resp ) {
			deferred.resolve( resp.query.repos );
		} )
		.fail( function () {
			deferred.resolve( [ {
				'url': mw.util.wikiScript( 'api' ),
				'local': true
			} ] );
		} );
	} else {
		// There was no need to ask for the resources again
		// return false so we can skip setting the sources
		deferred.resolve( false );
	}

	return deferred.promise();
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWMediaInsertDialog.super.prototype.initialize.call( this );

	this.defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' )
		.defaultUserOptions.defaultthumbsize;

	// Widget
	this.search = new ve.ui.MWMediaSearchWidget( { '$': this.$ } );

	// Initialization
	this.search.$element.addClass( 've-ui-mwMediaInsertDialog-select' );

	// Events
	this.search.connect( this, { 'select': 'onSearchSelect' } );

	this.$spinner = this.$( '<div>' ).addClass( 've-specialchar-spinner' );
	this.$body.append( this.$spinner, this.search.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaInsertDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWMediaInsertDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Show a spinner while we check for file repos.
			// this will only be done once per session.
			//
			// This is in .setup rather than .initialize so that
			// the user has visual indication (spinner) during the
			// ajax request
			this.$spinner.show();
			this.search.$element.hide();

			// Get the repos from the API first
			// The ajax request will only be done once per session
			this.getFileRepos().done( ve.bind( function ( repos ) {
				if ( repos ) {
					this.sources = repos;
					this.search.setSources( this.sources );
				}
				// Done, hide the spinner
				this.$spinner.hide();

				// Show the search and query the media sources
				this.search.$element.show();
				this.search.queryMediaSources();

				// Initialization
				// This must be done only after there are proper
				// sources defined
				this.search.getQuery().focus().select();
				this.search.getResults().selectItem();
				this.search.getResults().highlightItem();
			}, this ) );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaInsertDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWMediaInsertDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.search.getQuery().setValue( '' );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWMediaInsertDialog );
