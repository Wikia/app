/*!
 * VisualEditor UserInterface MWSaveDialog class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for saving MediaWiki pages.
 *
 * Note that most methods are not safe to call before the dialog has initialized, except where
 * noted otherwise.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.MWSaveDialog = function VeUiMwSaveDialog( config ) {
	// Parent constructor
	ve.ui.MWSaveDialog.super.call( this, config );

	// Properties
	this.editSummaryByteLimit = 255;
	this.restoring = false;
	this.messages = {};
	this.setupDeferred = $.Deferred();
	this.target = null;
	this.checkboxesByName = null;

	// Initialization
	this.$element.addClass( 've-ui-mwSaveDialog' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWSaveDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.MWSaveDialog.static.name = 'mwSave';

ve.ui.MWSaveDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-savedialog-title-save' );

ve.ui.MWSaveDialog.static.actions = [
	{
		action: 'save',
		label: OO.ui.deferMsg( 'visualeditor-savedialog-label-save' ),
		flags: [ 'primary', 'constructive' ],
		modes: [ 'save', 'review' ],
		accessKey: 's'
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-savedialog-label-resume-editing' ),
		flags: [ 'safe', 'back' ],
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
 * Swap state in the save dialog.
 *
 * @param {string} panel One of 'save', 'review', 'conflict' or 'nochanges'
 * @return {jQuery} The now active panel
 * @throws {Error} Unknown saveDialog panel
 */
ve.ui.MWSaveDialog.prototype.swapPanel = function ( panel ) {
	var currentEditSummaryWikitext,
		dialog = this,
		panelObj = dialog[ panel + 'Panel' ];

	if ( ( [ 'save', 'review', 'conflict', 'nochanges' ].indexOf( panel ) ) === -1 ) {
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
			this.actions.setMode( 'save' );
			// HACK: FF needs *another* defer
			setTimeout( function () {
				dialog.editSummaryInput.moveCursorToEnd();
			} );
			break;
		case 'conflict':
			this.actions
				.setAbilities( { save: false } )
				.setMode( 'conflict' );
			break;
		case 'review':
			this.setSize( 'larger' );
			currentEditSummaryWikitext = this.editSummaryInput.getValue();
			if ( this.lastEditSummaryWikitext === undefined || this.lastEditSummaryWikitext !== currentEditSummaryWikitext ) {
				if ( this.editSummaryXhr ) {
					this.editSummaryXhr.abort();
				}
				this.lastEditSummaryWikitext = currentEditSummaryWikitext;
				this.$reviewEditSummary.empty();

				if ( !currentEditSummaryWikitext || currentEditSummaryWikitext.trim() === '' ) {
					// Don't bother with an API request for an empty summary
					this.$reviewEditSummary.parent().addClass( 'oo-ui-element-hidden' );
				} else {
					this.$reviewEditSummary.parent()
						.removeClass( 'oo-ui-element-hidden' )
						.addClass( 'mw-ajax-loader' );
					this.editSummaryXhr = new mw.Api().post( {
						action: 'parse',
						summary: currentEditSummaryWikitext
					} ).done( function ( result ) {
						if ( result.parse.parsedsummary[ '*' ] === '' ) {
							dialog.$reviewEditSummary.parent().addClass( 'oo-ui-element-hidden' );
						} else {
							dialog.$reviewEditSummary.html( ve.msg( 'parentheses', result.parse.parsedsummary[ '*' ] ) );
						}
					} ).fail( function () {
						dialog.$reviewEditSummary.parent().addClass( 'oo-ui-element-hidden' );
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
	if ( !this.messages[ name ] ) {
		options = options || {};
		if ( options.wrap === undefined ) {
			options.wrap = 'warning';
		}
		$message = $( '<div class="ve-ui-mwSaveDialog-message"></div>' );
		if ( options.wrap !== false ) {
			$message.append( $( '<p>' ).append(
				// visualeditor-savedialog-label-error
				// visualeditor-savedialog-label-warning
				$( '<strong>' ).text( mw.msg( 'visualeditor-savedialog-label-' + options.wrap ) ),
				document.createTextNode( mw.msg( 'colon-separator' ) ),
				message
			) );
		} else {
			$message.append( message );
		}
		this.$saveMessages.append( $message );

		this.messages[ name ] = $message;
	}
};

/**
 * Remove a message from the save dialog.
 *
 * @param {string} name Message's unique name
 */
ve.ui.MWSaveDialog.prototype.clearMessage = function ( name ) {
	if ( this.messages[ name ] ) {
		this.messages[ name ].remove();
		delete this.messages[ name ];
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
	if ( this.checkboxesByName.wpMinoredit ) {
		this.checkboxesByName.wpMinoredit.setSelected( false );
	}
	// Clear the diff
	this.$reviewViewer.empty();
};

/**
 * Initialize MediaWiki page specific checkboxes.
 *
 * This method is safe to call even when the dialog hasn't been initialized yet.
 *
 * @param {OO.ui.FieldLayout[]} checkboxFields Checkbox fields
 */
ve.ui.MWSaveDialog.prototype.setupCheckboxes = function ( checkboxFields ) {
	var dialog = this;
	this.setupDeferred.done( function () {
		checkboxFields.forEach( function ( field ) {
			dialog.$saveCheckboxes.append( field.$element );
		} );
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
	var dialog = this;
	this.setupDeferred.done( function () {
		dialog.editSummaryInput.setValue( summary );
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.initialize = function () {
	var saveAccessKey,
		dialog = this;

	// Parent method
	ve.ui.MWSaveDialog.super.prototype.initialize.call( this );

	// Properties
	this.panels = new OO.ui.StackLayout( { scrollable: true } );
	this.savePanel = new OO.ui.PanelLayout( {
		scrollable: true,
		padded: true,
		classes: [ 've-ui-mwSaveDialog-savePanel' ]
	} );

	// Byte counter in edit summary
	this.editSummaryCountLabel = new OO.ui.LabelWidget( {
		classes: [ 've-ui-mwSaveDialog-editSummary-count' ],
		label: String( this.editSummaryByteLimit ),
		title: ve.msg( 'visualeditor-editsummary-bytes-remaining' )
	} );

	// Save panel
	this.$editSummaryLabel = $( '<div>' ).addClass( 've-ui-mwSaveDialog-summaryLabel' )
		.html( ve.init.platform.getParsedMessage( 'summary' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.editSummaryInput = new OO.ui.TextInputWidget( {
		multiline: true,
		placeholder: ve.msg( 'visualeditor-editsummary' ),
		classes: [ 've-ui-mwSaveDialog-summary' ],
		inputFilter: function ( value ) {
			// Prevent the user from inputting newlines (this kicks in on paste, etc.)
			return value.replace( /\r?\n/g, ' ' );
		}
	} );
	// Prevent the user from inputting newlines from keyboard
	this.editSummaryInput.$input.on( 'keypress', function ( e ) {
		if ( e.which === OO.ui.Keys.ENTER ) {
			e.preventDefault();
		}
	} );
	// Limit byte length, and display the remaining bytes
	this.editSummaryInput.$input.byteLimit( this.editSummaryByteLimit );
	this.editSummaryInput.on( 'change', function () {
		// TODO: This looks a bit weird, there is no unit in the UI, just numbers
		// Users likely assume characters but then it seems to count down quicker
		// than expected. Facing users with the word "byte" is bad? (bug 40035)
		dialog.editSummaryCountLabel.setLabel(
			String( dialog.editSummaryByteLimit - $.byteLength( dialog.editSummaryInput.getValue() ) )
		);
	} );

	this.$saveCheckboxes = $( '<div>' ).addClass( 've-ui-mwSaveDialog-checkboxes' );
	this.$saveOptions = $( '<div>' ).addClass( 've-ui-mwSaveDialog-options' ).append(
		this.$saveCheckboxes,
		this.editSummaryCountLabel.$element
	);
	this.$saveMessages = $( '<div>' );
	this.$saveActions = $( '<div>' );
	this.$saveFoot = $( '<div>' ).addClass( 've-ui-mwSaveDialog-foot' ).append(
		$( '<p>' ).addClass( 've-ui-mwSaveDialog-license' )
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
	this.reviewPanel = new OO.ui.PanelLayout( {
		scrollable: true,
		padded: true
	} );
	this.$reviewViewer = $( '<div>' ).addClass( 've-ui-mwSaveDialog-viewer' );
	this.$reviewEditSummary = $( '<span>' ).addClass( 've-ui-mwSaveDialog-summaryPreview' ).addClass( 'comment' );
	this.$reviewActions = $( '<div>' ).addClass( 've-ui-mwSaveDialog-actions' );
	this.reviewPanel.$element.append(
		$( '<div>' )
			.addClass( 'mw-summary-preview' )
			.text( ve.msg( 'summary-preview' ) )
			.append( $( '<br>' ), this.$reviewEditSummary ),
		this.$reviewViewer,
		this.$reviewActions
	);

	// Conflict panel
	this.conflictPanel = new OO.ui.PanelLayout( {
		scrollable: true,
		padded: true
	} );
	this.$conflict = $( '<div>' ).addClass( 've-ui-mwSaveDialog-conflict' )
		.html( ve.init.platform.getParsedMessage( 'visualeditor-editconflict' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.conflictPanel.$element.append( this.$conflict );

	// No changes panel
	this.nochangesPanel = new OO.ui.PanelLayout( {
		scrollable: true,
		padded: true
	} );
	this.$noChanges = $( '<div>' ).addClass( 've-ui-mwSaveDialog-nochanges' )
		.html( ve.init.platform.getParsedMessage( 'visualeditor-diff-nochanges' ) )
		.find( 'a' ).attr( 'target', '_blank' ).end();
	this.nochangesPanel.$element.append( this.$noChanges );

	// Panel stack
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
			this.target = data.target;
			if ( data.editSummary !== undefined ) {
				this.setEditSummary( data.editSummary );
			}
			this.setupCheckboxes( data.checkboxFields || [] );
			this.checkboxesByName = data.checkboxesByName || {};
			// Old messages should not persist
			this.clearAllMessages();
			this.swapPanel( 'save' );
			// Update save button label
			this.actions.forEach( { actions: 'save' }, function ( action ) {
				action.setLabel(
					ve.msg(
						// TODO: Actually populate this.restoring with information. Right now it is
						// always false because of an oversight when migrating this code from init.
						// Possible messages:
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
ve.ui.MWSaveDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWSaveDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.editSummaryInput.focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWSaveDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			this.emit( 'close' );
			this.target = null;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWSaveDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'save' ) {
		return new OO.ui.Process( function () {
			var saveDeferred = $.Deferred();
			this.swapPanel( 'save' );
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
