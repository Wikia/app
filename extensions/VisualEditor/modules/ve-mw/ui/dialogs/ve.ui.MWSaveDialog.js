/*!
 * VisualEditor UserInterface MWSaveDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Dialog for saving MediaWiki articles.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Config options
 */
ve.ui.MWSaveDialog = function VeUiMWSaveDialog( windowSet, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'small': true }, config );

	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );

	// Properties
	this.sanityCheckVerified = false;
	this.editSummaryByteLimit = 255;
	this.restoring = false;
	this.messages = {};
};

/* Inheritance */

OO.inheritClass( ve.ui.MWSaveDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWSaveDialog.static.name = 'mwSave';

ve.ui.MWSaveDialog.static.titleMessage = 'visualeditor-savedialog-title-save';

/* Methods */

ve.ui.MWSaveDialog.prototype.onSaveButtonClick = function () {
	this.emit( 'save' );
};

ve.ui.MWSaveDialog.prototype.onReviewButtonClick = function () {
	this.emit( 'review' );
};

ve.ui.MWSaveDialog.prototype.onReviewGoodButtonClick = function () {
	this.swapPanel( 'save' );
};

ve.ui.MWSaveDialog.prototype.onResolveConflictButtonClick = function () {
	this.emit( 'resolve' );
};

/**
 * Set review content and show review panel
 *
 * @param {string} content Diff HTML or wikitext
 */
ve.ui.MWSaveDialog.prototype.setDiffAndReview = function ( content ) {
	this.$reviewViewer.empty().append( content );
	this.reviewGoodButton.setDisabled( false );
	this.$loadingIcon.hide();
	this.swapPanel( 'review' );
};

/**
 * Set sanity check flag
 *
 * @param {boolean} verified Status of sanity check
 */
ve.ui.MWSaveDialog.prototype.setSanityCheck = function ( verified ) {
	this.sanityCheckVerified = !!verified;
};

/**
 * Swap state in the save dialog.
 *
 * @param {string} panel One of 'save', 'review', 'conflict' or 'nochanges'
 * @returns {jQuery} The now active panel
 * @throws {Error} Unknown saveDialog panel
 */
ve.ui.MWSaveDialog.prototype.swapPanel = function ( panel ) {
	var dialog = this,
		panelObj = dialog[panel + 'Panel'];

	if ( ve.indexOf( panel, [ 'save', 'review', 'conflict', 'nochanges' ] ) === -1 ) {
		throw new Error( 'Unknown saveDialog panel: ' + panel );
	}

	// Update the window title
	this.setTitle( ve.msg( 'visualeditor-savedialog-title-' + panel ) );

	// Old messages should not persist after panel changes
	this.clearAllMessages();

	// Reset save button if we disabled it for e.g. unrecoverable spam error
	this.saveButton.setDisabled( false );

	switch( panel ) {
		case 'save':
			if ( !this.sanityCheckVerified ) {
				this.showMessage( 'dirtywarning', mw.msg( 'visualeditor-savedialog-warning-dirty' ) );
			}
			this.saveButton.$element.show();
			this.reviewButton.$element.show();
			this.reviewGoodButton.$element.hide();
			this.resolveConflictButton.$element.hide();
			setTimeout( function () {
				// fix input reference
				var $textarea = dialog.editSummaryInput.$input;
				$textarea.focus();
				// If message has be pre-filled (e.g. section edit), move cursor to end
				if ( $textarea.val() !== '' ) {
					ve.selectEnd( $textarea[0] );
				}
			} );
			break;
		case 'conflict':
			this.saveButton.$element.hide();
			this.reviewButton.$element.hide();
			this.reviewGoodButton.$element.hide();
			this.resolveConflictButton.$element.show();
			break;
		case 'review':
			// Make room for the diff by transitioning to a non-small window
			this.$frame.removeClass( 've-ui-window-frame-small' );
			/* falls through */
		case 'nochanges':
			this.saveButton.$element.hide();
			this.reviewButton.$element.hide();
			this.reviewGoodButton.$element.show();
			this.resolveConflictButton.$element.hide();
			break;
	}

	if ( panel !== 'review' ) {
		// Restore original "small" size
		this.$frame.addClass( 've-ui-window-frame-small' );
	}

	// Show the target panel
	this.panel.showItem( panelObj );

	mw.hook( 've.saveDialog.stateChanged' ).fire();

	return dialog;
};

/**
 * Show a message in the save dialog.
 *
 * @param {string} name Message's unique name
 * @param {string|jQuery|Array} message Message content (string of HTML, jQuery object or array of
 *  Node objects)
 * @param {Object} [options]
 * @param {boolean} [options.wrap="warning"] Whether to wrap the message in a paragraph and if
 *  so, how. One of "warning", "error" or false.
 */
ve.ui.MWSaveDialog.prototype.showMessage = function ( name, message, options ) {
	var $message;
	if ( !this.messages[name] ) {
		options = options || {};
		if ( options.wrap === undefined ) {
			options.wrap = 'warning';
		}
		$message = this.$( '<div class="ve-ui-mwSaveDialog-message"></div>' );
		if ( options.wrap !== false ) {
			$message.append( this.$( '<p>').append(
				 // visualeditor-savedialog-label-error
				 // visualeditor-savedialog-label-warning
				this.$( '<strong>' ).text( mw.msg( 'visualeditor-savedialog-label-' + options.wrap ) ),
				document.createTextNode( mw.msg( 'colon-separator' ) ),
				message
			) );
		} else {
			$message.append( message );
		}
		this.$saveMessages.append( $message );

		this.messages[name] = $message;
	}
};

/**
 * Remove a message from the save dialog.
 * @param {string} name Message's unique name
 */
ve.ui.MWSaveDialog.prototype.clearMessage = function ( name ) {
	if ( this.messages[name] ) {
		this.messages[name].remove();
		delete this.messages[name];
	}
};

/**
 * Remove all messages from the save dialog.
 */
ve.ui.MWSaveDialog.prototype.clearAllMessages = function () {
	this.$saveMessages.empty();
	this.messages = {};
};

/**
 * Reset the fields of the save dialog.
 *
 * @method
 */
ve.ui.MWSaveDialog.prototype.reset = function () {
	// Reset summary input
	this.editSummaryInput.$input.val( '' );
	// Uncheck minoredit
	this.$saveOptions.find( '.ve-ui-mwSaveDialog-checkboxes' )
		.find( '#wpMinoredit' ).prop( 'checked', false );
	// Clear the diff
	this.$reviewViewer.empty();
};

/**
 * Initialize MediaWiki page specific checkboxes
 *
 * @param {string} checkboxes Multiline HTML
 */
ve.ui.MWSaveDialog.prototype.setupCheckboxes = function ( checkboxes ) {
	this.$saveOptions.find( '.ve-ui-mwSaveDialog-checkboxes' )
		.html( checkboxes )
		.find( 'a' )
			.attr( 'target', '_blank' )
			.end()
		.find( '#wpMinoredit' )
			.prop( 'checked', mw.user.options.get( 'minordefault' ) )
			.prop( 'tabIndex', 0 )
			.end()
		.find( '#wpWatchthis' )
			.prop( 'checked',
				mw.user.options.get( 'watchdefault' ) ||
				( mw.user.options.get( 'watchcreations' ) && !this.pageExists ) ||
				mw.config.get( 'wgVisualEditor' ).isPageWatched
			).prop( 'tabIndex', 0 );
	// TODO: Need to set all checkboxes provided by api tabindex to 0 for proper accessibility
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.initialize = function () {
	var saveDialog = this;
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.savePanel = new OO.ui.PanelLayout( { '$': this.$, 'scrollable': true } );

	// Save panel
	this.$editSummaryLabel = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-summaryLabel' )
		.html( ve.init.platform.getParsedMessage( 'summary' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.editSummaryInput = new OO.ui.TextInputWidget(
		{ '$': this.$, 'multiline': true, 'placeholder': ve.msg( 'visualeditor-editsummary' ) }
	);
	this.editSummaryInput.$element.addClass( 've-ui-mwSaveDialog-summary' );
	this.editSummaryInput.$input
		.placeholder()
		.byteLimit( this.editSummaryByteLimit )
		.prop( 'tabIndex', 0 );
	this.editSummaryInput.on( 'change', ve.bind( function () {
		var $textarea = this.editSummaryInput.$input,
			$editSummaryCount = this.savePanel.$element.find( '.ve-ui-mwSaveDialog-editSummary-count' );
		// TODO: This looks a bit weird, there is no unit in the UI, just numbers
		// Users likely assume characters but then it seems to count down quicker
		// than expected. Facing users with the word "byte" is bad? (bug 40035)
		setTimeout( function () {
			$editSummaryCount.text(
				saveDialog.editSummaryByteLimit - $.byteLength( $textarea.val() )
			);
		} );
	}, this ) );

	this.$saveOptions = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-options' ).append(
		this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-checkboxes' ),
		new OO.ui.InputLabelWidget( { '$': this.$, 'label': 'text' } ).$element
			.addClass( 've-ui-mwSaveDialog-editSummary-count' ).text( this.editSummaryByteLimit )
	);
	this.$saveMessages = this.$( '<div>' );
	this.$captcha = this.$( '<div>' ).attr( 'id', 've-ui-mwSaveDialog-captcha' );
	this.$saveActions = this.$( '<div>' ).append(
		this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-dirtymsg' )
	);
	this.$saveFoot = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-foot' ).append(
		this.$( '<p>' ).addClass( 've-ui-mwSaveDialog-license' )
			.html( ve.init.platform.getParsedMessage( 'copyrightwarning' ) )
			.find( 'a' ).attr( 'target', '_blank' ).end()
	);
	this.savePanel.$element.append(
		this.$editSummaryLabel,
		this.editSummaryInput.$element,
		this.$saveOptions,
		this.$captcha,
		this.$saveMessages,
		this.$saveActions,
		this.$saveFoot
	);

	// Review panel
	this.reviewPanel = new OO.ui.PanelLayout( { '$': this.$, 'scrollable': true } );
	this.$reviewViewer = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-viewer' );
	this.$reviewActions = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-actions' );
	this.reviewPanel.$element.append( this.$reviewViewer, this.$reviewActions );

	// Conflict panel
	this.conflictPanel = new OO.ui.PanelLayout( { '$': this.$, 'scrollable': true } );
	this.$conflict = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-conflict' )
		.html( ve.init.platform.getParsedMessage( 'visualeditor-editconflict' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.conflictPanel.$element.append( this.$conflict );

	// No changes panel
	this.nochangesPanel = new OO.ui.PanelLayout( { '$': this.$, 'scrollable': true } );
	this.$noChanges = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-nochanges' )
		.html( ve.init.platform.getParsedMessage( 'visualeditor-diff-nochanges' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.nochangesPanel.$element.append( this.$noChanges );

	// Panel stack
	this.panel = new OO.ui.StackPanelLayout( { '$': this.$, 'scrollable': true } );
	this.panel.$element.addClass( 've-ui-mwSaveDialog-panel' );
	this.panel.addItems( [this.savePanel, this.reviewPanel, this.conflictPanel, this.nochangesPanel], 0 );

	/* Buttons */

	// Save button for "save" panel
	this.saveButton = new OO.ui.PushButtonWidget( {
		'label': ve.msg(
			 // visualeditor-savedialog-label-restore, visualeditor-savedialog-label-save
			'wikia-visualeditor-savedialog-label-' + ( this.restoring ? 'restore' : 'save' )
		),
		'flags': ['constructive']
	} );
	this.saveButton.connect( this, { 'click': 'onSaveButtonClick' } );

	// Review button for "save" panel
	this.reviewButton = new OO.ui.PushButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-review' )
	} );
	this.reviewButton.connect( this, { 'click': 'onReviewButtonClick' } );

	// Review good button on "review" panel
	this.reviewGoodButton = new OO.ui.PushButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-review-good' ),
		'flags': ['constructive']
	} );
	this.reviewGoodButton.connect( this, { 'click': 'onReviewGoodButtonClick' } );
	// Resolve conflict
	this.resolveConflictButton = new OO.ui.PushButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-resolve-conflict' ),
		'flags': ['constructive']
	} );
	this.resolveConflictButton.connect( this, { 'click': 'onResolveConflictButtonClick' } );

	this.$loadingIcon = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-working' );

	// Initialization
	this.$body.append( this.panel.$element );
	this.$foot.append(
		this.reviewButton.$element,
		this.saveButton.$element,
		this.reviewGoodButton.$element,
		this.resolveConflictButton.$element,
		this.$loadingIcon
	);
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWSaveDialog );
