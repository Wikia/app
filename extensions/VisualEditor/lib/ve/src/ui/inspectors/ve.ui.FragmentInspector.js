/*!
 * VisualEditor UserInterface FragmentInspector class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Inspector for working with fragments of content.
 *
 * @class
 * @extends OO.ui.ProcessDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.FragmentInspector = function VeUiFragmentInspector( config ) {
	// Parent constructor
	ve.ui.FragmentInspector.super.call( this, config );

	// Properties
	this.fragment = null;
	this.previousSelection = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.FragmentInspector, OO.ui.ProcessDialog );

/* Static Properties */

ve.ui.FragmentInspector.static.actions = ve.ui.FragmentInspector.super.static.actions.concat( [
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: [ 'safe', 'back' ],
		modes: [ 'edit', 'insert' ]
	},
	{
		action: 'done',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-done' ),
		flags: [ 'progressive', 'primary' ],
		modes: 'edit'
	},
	{
		action: 'done',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-insert' ),
		flags: [ 'constructive', 'primary' ],
		modes: 'insert'
	}
] );

ve.ui.FragmentInspector.static.size = 'large';

/* Methods */

/**
 * Handle form submit events.
 *
 * Executes the 'done' action when the user presses enter in the form.
 *
 * @method
 */
ve.ui.FragmentInspector.prototype.onFormSubmit = function () {
	this.executeAction( 'done' );
};

/**
 * Get the surface fragment the inspector is for.
 *
 * @return {ve.dm.SurfaceFragment|null} Surface fragment the inspector is for, null if the
 *   inspector is closed
 */
ve.ui.FragmentInspector.prototype.getFragment = function () {
	return this.fragment;
};

/**
 * Get a symbolic mode name.
 *
 * @localdoc If the fragment being inspected selects at least one model the mode will be `edit`,
 *   otherwise the mode will be `insert`
 *
 * @return {string} Symbolic mode name
 */
ve.ui.FragmentInspector.prototype.getMode = function () {
	if ( this.fragment ) {
		return this.fragment.getSelectedModels().length ? 'edit' : 'insert';
	}
	return '';
};

/**
 * @inheritdoc
 */
ve.ui.FragmentInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.FragmentInspector.super.prototype.initialize.call( this );

	// Properties
	this.container = new OO.ui.PanelLayout( {
		scrollable: true, classes: [ 've-ui-fragmentInspector-container' ]
	} );
	this.form = new OO.ui.FormLayout( {
		classes: [ 've-ui-fragmentInspector-form' ]
	} );

	// Events
	this.form.connect( this, { submit: 'onFormSubmit' } );

	// Initialization
	this.$element.addClass( 've-ui-fragmentInspector' );
	this.$content.addClass( 've-ui-fragmentInspector-content' );
	this.container.$element.append( this.form.$element, this.$otherActions );
	this.$body.append( this.container.$element );
};

/**
 * @inheritdoc
 */
ve.ui.FragmentInspector.prototype.getActionProcess = function ( action ) {
	if ( action === 'done' ) {
		return new OO.ui.Process( function () {
			this.close( { action: 'done' } );
		}, this );
	}
	return ve.ui.FragmentInspector.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.FragmentInspector.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.FragmentInspector.super.prototype.getSetupProcess.call( this, data )
		.first( function () {
			if ( !( data.fragment instanceof ve.dm.SurfaceFragment ) ) {
				throw new Error( 'Cannot open inspector: opening data must contain a fragment' );
			}
			this.fragment = data.fragment;
			this.previousSelection = this.fragment.getSelection();
		}, this )
		.next( function () {
			this.actions.setMode( this.getMode() );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.FragmentInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.FragmentDialog.super.prototype.getTeardownProcess.apply( this, data )
		.next( function () {
			this.fragment = null;
			this.previousSelection = null;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.FragmentInspector.prototype.getReadyProcess = function ( data ) {
	return ve.ui.FragmentInspector.super.prototype.getReadyProcess.call( this, data )
		// Add a 0ms timeout before doing anything. Because... Internet Explorer :(
		.first( 0 );
};

/**
 * @inheritdoc
 */
ve.ui.FragmentInspector.prototype.getBodyHeight = function () {
	// HACK: Chrome gets the height wrong by 1px for elements with opacity < 1
	// e.g. a disabled button.
	return Math.ceil( this.container.$element[ 0 ].scrollHeight ) + 1;
};
