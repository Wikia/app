/*!
 * VisualEditor UserInterface ProgressDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Dialog for showing operations in progress.
 *
 * @class
 * @extends OO.ui.MessageDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.ProgressDialog = function VeUiProgressDialog( config ) {
	// Parent constructor
	ve.ui.ProgressDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.ProgressDialog, OO.ui.MessageDialog );

/* Static Properties */

ve.ui.ProgressDialog.static.name = 'progress';

ve.ui.ProgressDialog.static.size = 'medium';

ve.ui.ProgressDialog.static.actions = [
	{
		action: 'cancel',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'destructive'
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ProgressDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.ProgressDialog.super.prototype.initialize.call( this );

	// Properties
	this.inProgress = 0;
	this.cancelDeferreds = [];
};

/**
 * @inheritdoc
 */
ve.ui.ProgressDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};

	// Parent method
	return ve.ui.ProgressDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var i, l, $row, progressBar, fieldLayout, cancelButton, cancelDeferred,
				progresses = data.progresses;

			this.inProgress = progresses.length;
			this.text.$element.empty();
			this.cancelDeferreds = [];

			for ( i = 0, l = progresses.length; i < l; i++ ) {
				cancelDeferred = $.Deferred();
				$row = this.$( '<div>' ).addClass( 've-ui-progressDialog-row' );
				progressBar = new OO.ui.ProgressBarWidget( { $: this.$ } );
				fieldLayout = new OO.ui.FieldLayout(
					progressBar,
					{
						$: this.$,
						label: progresses[i].label,
						align: 'top'
					}
				);
				cancelButton = new OO.ui.ButtonWidget( {
					$: this.$,
					framed: false,
					icon: 'clear',
					iconTitle: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' )
				} ).on( 'click', cancelDeferred.reject.bind( cancelDeferred ) );

				this.text.$element.append(
					$row.append(
						fieldLayout.$element, cancelButton.$element
					)
				);
				progresses[i].progressBarDeferred.resolve( progressBar, cancelDeferred.promise() );
				/*jshint loopfunc:true */
				progresses[i].progressCompletePromise.then(
					this.progressComplete.bind( this, $row, false ),
					this.progressComplete.bind( this, $row, true )
				);
				this.cancelDeferreds.push( cancelDeferred );
			}
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.ProgressDialog.prototype.getActionProcess = function ( action ) {
	return new OO.ui.Process( function () {
		var i, l;
		if ( action === 'cancel' ) {
			for ( i = 0, l = this.cancelDeferreds.length; i < l; i++ ) {
				this.cancelDeferreds[i].reject();
			}
		}
		this.close( { action: action } );
	}, this );
};

/**
 * Progress has completed for an item
 *
 * @param {jQuery} $row Row containing progress bar which has completed
 * @param {boolean} failed The item failed
 */
ve.ui.ProgressDialog.prototype.progressComplete = function ( $row, failed ) {
	this.inProgress--;
	if ( !this.inProgress ) {
		this.close();
	}
	if ( failed ) {
		$row.remove();
		this.manager.updateWindowSize( this );
	}
};

/* Static methods */

/* Registration */

ve.ui.windowFactory.register( ve.ui.ProgressDialog );
