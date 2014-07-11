/*!
 * VisualEditor UserInterface MWSaveDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Dialog for saving MediaWiki articles.
 *
 * Note that most methods are not safe to call before the dialog has initialized, except where
 * noted otherwise.
 *
 * @class
 * @extends ve.ui.ActionDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.MWSaveDialog = function VeUiMWSaveDialog( config ) {
	// Parent constructor
	ve.ui.MWSaveDialog.super.call( this, config );

	// Properties
	this.sanityCheckVerified = false;
	this.editSummaryByteLimit = 255;
	this.restoring = false;
	this.messages = {};
	this.setupDeferred = $.Deferred();
};

/* Inheritance */

OO.inheritClass( ve.ui.MWSaveDialog, ve.ui.ActionDialog );

/* Static Properties */

ve.ui.MWSaveDialog.static.name = 'mwSave';

ve.ui.MWSaveDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-savedialog-title-save' );

/* Events */

/**
 * @event save
 * @param {jQuery.Deferred} saveDeferred Deferred object to resolve/reject when the save
 *  succeeds/fails.
 * Emitted when the user clicks the save button
 */

/**
 * @event review
 * Emitted when the user clicks the review changes button
 */

/**
 * @event resolve
 * Emitted when the user clicks the resolve conflict button
 */

/* Methods */

/**
 * Set review content and show review panel.
 *
 * @param {string} content Diff HTML or wikitext
 */
ve.ui.MWSaveDialog.prototype.setDiffAndReview = function ( content ) {
	this.$reviewViewer.empty().append( content );
	this.reviewGoodButton.setDisabled( false );
	this.popPending();
	this.swapPanel( 'review' );
};

/**
 * Clear the diff displayed in the review panel, if any.
 */
ve.ui.MWSaveDialog.prototype.clearDiff = function () {
	this.$reviewViewer.empty();
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
	var currentEditSummaryWikitext,
		dialog = this,
		panelObj = dialog[panel + 'Panel'];

	if ( ve.indexOf( panel, [ 'save', 'review', 'conflict', 'nochanges' ] ) === -1 ) {
		throw new Error( 'Unknown saveDialog panel: ' + panel );
	}

	this.setSize( 'medium' );

	// Update the window title
	this.setTitle( ve.msg( 'visualeditor-savedialog-title-' + panel ) );

	// Reset save button if we disabled it for e.g. unrecoverable spam error
	this.applyButton.setDisabled( false );

	switch ( panel ) {
		case 'save':
			this.isApplyable = true;
			if ( !this.sanityCheckVerified ) {
				this.showMessage( 'dirtywarning', mw.msg( 'visualeditor-savedialog-warning-dirty' ) );
			}
			this.applyButton.$element.show();
			this.reviewButton.$element.show();
			this.reviewGoodButton.$element.hide();
			this.resolveConflictButton.$element.hide();
			// HACK: FF needs *another* defer
			setTimeout( function () {
				var $textarea = dialog.editSummaryInput.$input;
				$textarea.focus();
				// If message has be pre-filled (e.g. section edit), move cursor to end
				if ( $textarea.val() !== '' ) {
					ve.selectEnd( $textarea[0] );
				}
			} );
			break;
		case 'conflict':
			this.applyButton.setDisabled( true ).$element.hide();
			this.reviewButton.$element.hide();
			this.reviewGoodButton.$element.hide();
			this.resolveConflictButton.$element.show();
			break;
		case 'review':
			this.setSize( 'large' );
			currentEditSummaryWikitext = this.editSummaryInput.getValue();
			if ( this.lastEditSummaryWikitext === undefined || this.lastEditSummaryWikitext !== currentEditSummaryWikitext ) {
				if ( this.editSummaryXhr ) {
					this.editSummaryXhr.abort();
				}
				this.lastEditSummaryWikitext = currentEditSummaryWikitext;
				this.$reviewEditSummary.empty()
					.parent().show().addClass( 'mw-ajax-loader' );
				this.editSummaryXhr = new mw.Api().post( {
					action: 'parse',
					summary: currentEditSummaryWikitext,
					page: mw.config.get( 'wgRelevantPageName' ) /* Wikia change for VE-1054. Page param required in our version of Api.php */
				} ).done( function ( result ) {
					if ( result.parse.parsedsummary['*'] === '' ) {
						dialog.$reviewEditSummary.parent().hide();
					} else {
						dialog.$reviewEditSummary.html( ve.msg( 'parentheses', result.parse.parsedsummary['*'] ) );
					}
				} ).fail( function () {
					dialog.$reviewEditSummary.parent().hide();
				} ).always( function () {
					dialog.$reviewEditSummary.parent().removeClass( 'mw-ajax-loader' );
				} );
			}
			/* falls through */
		case 'nochanges':
			this.applyButton.$element.hide();
			this.reviewButton.$element.hide();
			this.reviewGoodButton.$element.show();
			this.resolveConflictButton.$element.hide();
			break;
	}

	// Show the target panel
	this.panel.setItem( panelObj );

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
 * Initialize MediaWiki page specific checkboxes.
 *
 * This method is safe to call even when the dialog hasn't been initialized yet.
 *
 * @param {jQuery} $checkboxes jQuery collection of checkboxes
 */
ve.ui.MWSaveDialog.prototype.setupCheckboxes = function ( $checkboxes ) {
	var saveDialog = this;
	this.setupDeferred.done( function () {
		saveDialog.$saveOptions.find( '.ve-ui-mwSaveDialog-checkboxes' )
			.html( $checkboxes )
			.find( 'a' )
				.attr( 'target', '_blank' )
				.end()
			.find( 'input' )
				.prop( 'tabIndex', 0 );
	} );
};

/**
 * Change the edit summary prefilled in the save dialog.
 *
 * This method is safe to call even when the dialog hasn't been initialized yet.
 *
 * @param {string} summary Edit summary to prefill
 */
ve.ui.MWSaveDialog.prototype.setEditSummary = function ( summary ) {
	var saveDialog = this;
	this.setupDeferred.done( function () {
		saveDialog.editSummaryInput.setValue( summary );
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.initialize = function () {
	var saveDialog = this;
	// Parent method
	ve.ui.MWSaveDialog.super.prototype.initialize.call( this );

	// Properties
	this.savePanel = new OO.ui.PanelLayout( {
		'$': this.$,
		'scrollable': true,
		'classes': ['ve-ui-mwSaveDialog-savePanel']
	} );

	// Save panel
	this.$editSummaryLabel = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-summaryLabel' )
		.html( ve.init.platform.getParsedMessage( 'summary' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.editSummaryInput = new OO.ui.TextInputWidget(
		{ '$': this.$, 'multiline': true, 'placeholder': ve.msg( 'visualeditor-editsummary' ) }
	);
	this.editSummaryInput.$element.addClass( 've-ui-mwSaveDialog-summary' );
	this.editSummaryInput.$input
		.byteLimit( this.editSummaryByteLimit )
		.prop( 'tabIndex', 0 );
	this.editSummaryInput.on( 'change', function () {
		// TODO: This looks a bit weird, there is no unit in the UI, just numbers
		// Users likely assume characters but then it seems to count down quicker
		// than expected. Facing users with the word "byte" is bad? (bug 40035)
		saveDialog.savePanel.$element.find( '.ve-ui-mwSaveDialog-editSummary-count' ).text(
			saveDialog.editSummaryByteLimit - $.byteLength( saveDialog.editSummaryInput.getValue() )
		);
	} );

	this.$saveOptions = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-options' ).append(
		this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-checkboxes' ),
		new OO.ui.LabelWidget( { '$': this.$ } ).$element
			.addClass( 've-ui-mwSaveDialog-editSummary-count' ).text( this.editSummaryByteLimit )
			.attr( 'title', ve.msg( 'visualeditor-editsummary-bytes-remaining' ) )
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
	this.$reviewEditSummary = this.$( '<span>' ).addClass( 've-ui-mwSaveDialog-summaryPreview' ).addClass( 'comment' );
	this.$reviewActions = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-actions' );
	this.reviewPanel.$element.append(
		$( '<br>' ),
		$( '<div>' )
			.addClass( 'mw-summary-preview' )
			.text( ve.msg( 'summary-preview' ) )
			.append( $( '<br>' ), this.$reviewEditSummary ),
		this.$reviewViewer,
		this.$reviewActions
	);

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
	this.panel = new OO.ui.StackLayout( { '$': this.$, 'scrollable': true } );
	this.panel.$element.addClass( 've-ui-mwSaveDialog-panel' );
	this.panel.addItems( [this.savePanel, this.reviewPanel, this.conflictPanel, this.nochangesPanel], 0 );

	/* Buttons */

	// Save button for "save" panel
	if ( ve.msg( 'accesskey-save' ) !== '-' && ve.msg( 'accesskey-save' ) !== '' ) {
		this.applyButton.$button.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}

	// Review button for "save" panel
	this.reviewButton = new OO.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-review' ),
		'flags': ['secondary']
	} );
	this.reviewButton.connect( this, { 'click': [ 'emit', 'review' ] } );

	// Review good button on "review" panel
	this.reviewGoodButton = new OO.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-review-good' )
	} );
	this.reviewGoodButton.connect( this, { 'click': [ 'swapPanel', 'save' ] } );
	// Resolve conflict
	this.resolveConflictButton = new OO.ui.ButtonWidget( {
		'label': ve.msg( 'visualeditor-savedialog-label-resolve-conflict' ),
		'flags': ['constructive']
	} );
	this.resolveConflictButton.connect( this, { 'click': [ 'emit', 'resolve' ] } );

	// Wikia change: keep old loading indicator style
	this.$loadingIcon = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-working' );

	// Initialization
	this.$body.append( this.panel.$element );
	this.$foot.append(
		this.reviewButton.$element,
		this.applyButton.$element,
		this.reviewGoodButton.$element,
		this.resolveConflictButton.$element,
		this.$loadingIcon
	);

	this.setupDeferred.resolve();
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWSaveDialog.super.prototype.getSetupProcess.call( this, data )
		.first( function () {
			this.swapPanel( 'save' );
			// Old messages should not persist after panel changes
			this.clearAllMessages();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWSaveDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.editSummaryInput.focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getApplyButtonFlags = function () {
	return [ 'constructive' ];
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getApplyButtonLabel = function () {
	return ve.msg(
		// visualeditor-savedialog-label-restore, visualeditor-savedialog-label-save
		'wikia-visualeditor-savedialog-label-' + ( this.restoring ? 'restore' : 'save' )
	);
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.pushPending = function () {
	this.$loadingIcon.show();
	// Parent method
	ve.ui.MWSaveDialog.super.prototype.pushPending.call( this );

	this.applyButton.setDisabled( !this.isApplyable || this.isPending() );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.popPending = function () {
	this.$loadingIcon.hide();
	// Parent method
	ve.ui.MWSaveDialog.super.prototype.popPending.call( this );

	this.applyButton.setDisabled( !this.isApplyable || this.isPending() );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.applyChanges = function () {
	var saveDeferred = $.Deferred();
	this.emit( 'save', saveDeferred );
	return saveDeferred.promise();
};

/*
 * @inheritdoc
 * @param {boolean} [allowReapply=true] Whether or not to allow the user to reapply.
 *  Reset when swapping panels. Assumed to be true unless explicitly set to false.
 */
ve.ui.MWSaveDialog.prototype.onApplyChangesFail = function ( errors, allowReapply ) {
	if ( allowReapply === false ) {
		this.isApplyable = false;
	}
	this.dismissErrors();

	// Parent method
	ve.ui.MWSaveDialog.super.prototype.onApplyChangesFail.call( this, errors );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWSaveDialog );
