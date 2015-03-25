/*!
 * VisualEditor UserInterface MWSaveDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for saving MediaWiki pages.
 *
 * Note that most methods are not safe to call before the dialog has initialized, except where
 * noted otherwise.
 *
 * @class
 * @extends OO.ui.ProcessDialog
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

OO.inheritClass( ve.ui.MWSaveDialog, OO.ui.ProcessDialog );

/* Static Properties */

ve.ui.MWSaveDialog.static.name = 'mwSave';

ve.ui.MWSaveDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-savedialog-title-save' );

ve.ui.MWSaveDialog.static.actions = [
	{
		action: 'save',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'primary', 'constructive' ],
		modes: 'save',
		accessKey: 's'
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-savedialog-label-resume-editing' ),
		flags: 'safe',
		modes: [ 'save', 'conflict' ]
	},
	{
		action: 'review',
		label: OO.ui.deferMsg( 'visualeditor-savedialog-label-review' ),
		modes: 'save'
	},
	{
		action: 'approve',
		label: OO.ui.deferMsg( 'visualeditor-savedialog-label-review-good' ),
		flags: [ 'progressive', 'primary' ],
		modes: 'review'
	},
	{
		action: 'resolve',
		label: OO.ui.deferMsg( 'visualeditor-savedialog-label-resolve-conflict' ),
		flags: [ 'primary', 'constructive' ],
		modes: 'conflict'
	}
];

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

/**
 * @event retry
 * Emitted when the user clicks the retry/continue save button after an error.
 */

/* Methods */

/**
 * Set review content and show review panel.
 *
 * @param {string} content Diff HTML or wikitext
 */
ve.ui.MWSaveDialog.prototype.setDiffAndReview = function ( content ) {
	this.$reviewViewer.empty().append( content );
	this.actions.setAbilities( { approve: true } );
	this.popPending();
	this.swapPanel( 'review' );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.pushPending = function () {
	this.getActions().setAbilities( { review: false } );
	return ve.ui.MWSaveDialog.super.prototype.pushPending.call( this );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.popPending = function () {
	var ret = ve.ui.MWSaveDialog.super.prototype.popPending.call( this );
	if ( !this.isPending() ) {
		this.getActions().setAbilities( { review: true } );
	}
	return ret;
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
	// The following messages can be used here:
	// visualeditor-savedialog-title-save
	// visualeditor-savedialog-title-reviews
	// visualeditor-savedialog-title-conflict
	// visualeditor-savedialog-title-nochanges
	this.title.setLabel( ve.msg( 'visualeditor-savedialog-title-' + panel ) );

	// Reset save button if we disabled it for e.g. unrecoverable spam error
	this.actions.setAbilities( { save: true } );

	switch ( panel ) {
		case 'save':
			if ( !this.sanityCheckVerified ) {
				this.showMessage( 'dirtywarning', mw.msg( 'visualeditor-savedialog-warning-dirty' ) );
			}
			this.actions.setMode( 'save' );
			// HACK: FF needs *another* defer
			setTimeout( function () {
				// FIXME we need to add features to OO.ui.TextInputWidget so we don't need to access .$input
				ve.selectEnd( dialog.editSummaryInput.$input[0] );
			} );
			break;
		case 'conflict':
			this.actions
				.setAbilities( { save: false } )
				.setMode( 'conflict' );
			break;
		case 'review':
			this.setSize( 'large' );
			currentEditSummaryWikitext = this.editSummaryInput.getValue();
			if ( this.lastEditSummaryWikitext === undefined || this.lastEditSummaryWikitext !== currentEditSummaryWikitext ) {
				if ( this.editSummaryXhr ) {
					this.editSummaryXhr.abort();
				}
				this.lastEditSummaryWikitext = currentEditSummaryWikitext;
				this.$reviewEditSummary.empty();

				if ( !currentEditSummaryWikitext || currentEditSummaryWikitext.trim() === '' ) {
					// Don't bother with an API request for an empty summary
					this.$reviewEditSummary.parent().hide();
				} else {
					this.$reviewEditSummary.parent().show().addClass( 'mw-ajax-loader' );
					this.editSummaryXhr = new mw.Api().post( {
						action: 'parse',
						summary: currentEditSummaryWikitext
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
			}
			/* falls through */
		case 'nochanges':
			this.actions.setMode( 'review' );
			break;
	}

	// Show the target panel
	this.panels.setItem( panelObj );

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
	this.editSummaryInput.setValue( '' );
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
	this.setupDeferred.done( function () {
		this.$saveOptions.find( '.ve-ui-mwSaveDialog-checkboxes' )
			.html( $checkboxes )
			.find( 'a' )
				.attr( 'target', '_blank' )
				.end()
			.find( 'input' )
				.prop( 'tabIndex', 0 );
	}.bind( this ) );
};

/**
 * Change the edit summary prefilled in the save dialog.
 *
 * This method is safe to call even when the dialog hasn't been initialized yet.
 *
 * @param {string} summary Edit summary to prefill
 */
ve.ui.MWSaveDialog.prototype.setEditSummary = function ( summary ) {
	this.setupDeferred.done( function () {
		this.editSummaryInput.setValue( summary );
	}.bind( this ) );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.initialize = function () {
	var saveAccessKey;

	// Parent method
	ve.ui.MWSaveDialog.super.prototype.initialize.call( this );

	// Properties
	this.panels = new OO.ui.StackLayout( { $: this.$, scrollable: true } );
	this.savePanel = new OO.ui.PanelLayout( {
		$: this.$,
		scrollable: true,
		classes: ['ve-ui-mwSaveDialog-savePanel']
	} );

	// Byte counter in edit summary
	this.editSummaryCountLabel = new OO.ui.LabelWidget ( {
		$: this.$,
		classes: [ 've-ui-mwSaveDialog-editSummary-count' ],
		label: String( this.editSummaryByteLimit ),
		title: ve.msg( 'visualeditor-editsummary-bytes-remaining' )
	} );

	// Save panel
	this.$editSummaryLabel = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-summaryLabel' )
		.html( ve.init.platform.getParsedMessage( 'summary' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.editSummaryInput = new OO.ui.TextInputWidget(
		{ $: this.$, multiline: true, placeholder: ve.msg( 'visualeditor-editsummary' ) }
	);
	this.editSummaryInput.$element.addClass( 've-ui-mwSaveDialog-summary' );
	this.editSummaryInput.$input
		.byteLimit( this.editSummaryByteLimit )
		.prop( 'tabIndex', 0 );
	this.editSummaryInput.on( 'change', function () {
		// TODO: This looks a bit weird, there is no unit in the UI, just numbers
		// Users likely assume characters but then it seems to count down quicker
		// than expected. Facing users with the word "byte" is bad? (bug 40035)
		this.editSummaryCountLabel.setLabel(
			String( this.editSummaryByteLimit - $.byteLength( this.editSummaryInput.getValue() ) )
		);
	}.bind( this ) );

	this.$saveOptions = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-options' ).append(
		this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-checkboxes' ),
		this.editSummaryCountLabel.$element
	);
	this.$saveMessages = this.$( '<div>' );
	this.$saveActions = this.$( '<div>' );
	this.$saveFoot = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-foot' ).append(
		this.$( '<p>' ).addClass( 've-ui-mwSaveDialog-license' )
			.html( ve.init.platform.getParsedMessage( 'copyrightwarning' ) )
			.find( 'a' ).attr( 'target', '_blank' ).end()
	);
	this.savePanel.$element.append(
		this.$editSummaryLabel,
		this.editSummaryInput.$element,
		this.$saveOptions,
		this.$saveMessages,
		this.$saveActions,
		this.$saveFoot
	);

	// Review panel
	this.reviewPanel = new OO.ui.PanelLayout( { $: this.$, scrollable: true } );
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
	this.conflictPanel = new OO.ui.PanelLayout( { $: this.$, scrollable: true } );
	this.$conflict = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-conflict' )
		.html( ve.init.platform.getParsedMessage( 'visualeditor-editconflict' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.conflictPanel.$element.append( this.$conflict );

	// No changes panel
	this.nochangesPanel = new OO.ui.PanelLayout( { $: this.$, scrollable: true } );
	this.$noChanges = this.$( '<div>' ).addClass( 've-ui-mwSaveDialog-nochanges' )
		.html( ve.init.platform.getParsedMessage( 'visualeditor-diff-nochanges' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.nochangesPanel.$element.append( this.$noChanges );

	// Panel stack
	this.panels.$element.addClass( 've-ui-mwSaveDialog-panel' );
	this.panels.addItems( [
		this.savePanel,
		this.reviewPanel,
		this.conflictPanel,
		this.nochangesPanel
	] );

	// Save button for "save" panel
	saveAccessKey = ve.msg( 'accesskey-save' );
	if ( saveAccessKey !== '-' && saveAccessKey !== '' ) {
		this.actions.forEach( { actions: 'save' }, function ( action ) {
			action.setAccessKey( saveAccessKey );
		} );
	}

	// Initialization
	this.$body.append( this.panels.$element );

	this.setupDeferred.resolve();
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWSaveDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Old messages should not persist
			this.clearAllMessages();
			this.swapPanel( 'save' );
			// Update save button label
			this.actions.forEach( { actions: 'save' }, function ( action ) {
				action.setLabel(
					ve.msg(
						// TODO: Actually populate this.resotring with information, right now it is
						// always false because of an oversight when migrating this code from init
						// visualeditor-savedialog-label-restore, visualeditor-savedialog-label-save
						'visualeditor-savedialog-label-' + ( this.restoring ? 'restore' : 'save' )
					)
				);
			} );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'save' ) {
		return new OO.ui.Process( function () {
			var saveDeferred = $.Deferred();
			this.emit( 'save', saveDeferred );
			return saveDeferred.promise();
		}, this );
	}
	if ( action === 'review' || action === 'resolve' ) {
		return new OO.ui.Process( function () {
			this.emit( action );
		}, this );
	}
	if ( action === 'approve' ) {
		return new OO.ui.Process( function () {
			this.swapPanel( 'save' );
		}, this );
	}

	return ve.ui.MWSaveDialog.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getBodyHeight = function () {
	// Don't vary the height when the foot is made visible or not
	return 350 - this.$foot.outerHeight( true );
};

/**
 * Handle retry button click events.
 *
 * Hides errors and then tries again.
 */
ve.ui.MWSaveDialog.prototype.onRetryButtonClick = function () {
	this.emit( 'retry' );
	ve.ui.MWSaveDialog.super.prototype.onRetryButtonClick.apply( this, arguments );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWSaveDialog );
