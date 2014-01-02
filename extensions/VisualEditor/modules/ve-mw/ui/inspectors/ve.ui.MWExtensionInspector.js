/*!
 * VisualEditor UserInterface MWExtensionInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki extension inspector.
 *
 * @class
 * @abstract
 * @extends ve.ui.Inspector
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWExtensionInspector = function VeUiMWExtensionInspector( surface, config ) {
	// Parent constructor
	ve.ui.Inspector.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWExtensionInspector, ve.ui.Inspector );

/* Static properties */

ve.ui.MWExtensionInspector.static.nodeView = null;

ve.ui.MWExtensionInspector.static.nodeModel = null;

ve.ui.MWExtensionInspector.static.removeable = false;

/* Methods */

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.MWExtensionInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.Inspector.prototype.initialize.call( this );

	this.input = new ve.ui.TextInputWidget( {
		'$$': this.frame.$$,
		'overlay': this.surface.$localOverlay,
		'multiline': true
	} );
	this.input.$.addClass( 've-ui-mwExtensionInspector-input' );

	// Initialization
	this.$form.append( this.input.$ );
};


/**
 * Handle the inspector being opened.
 */
ve.ui.MWExtensionInspector.prototype.onOpen = function () {
	var extsrc = '';

	// Parent method
	ve.ui.Inspector.prototype.onOpen.call( this );

	this.node = this.surface.getView().getFocusedNode();

	if ( this.node ) {
		extsrc = this.node.getModel().getAttribute( 'mw' ).body.extsrc;
	}

	// Wait for animation to complete
	setTimeout( ve.bind( function () {
		// Setup input text
		this.input.setValue( extsrc );
		this.input.$input.focus().select();
	}, this ), 200 );
};

/**
 * Handle the inspector being closed.
 *
 * @param {string} action Action that caused the window to be closed
 */
ve.ui.MWExtensionInspector.prototype.onClose = function ( action ) {
	var mwData,
		surfaceModel = this.surface.getModel();

	// Parent method
	ve.ui.Inspector.prototype.onClose.call( this, action );

	if ( this.node instanceof this.constructor.static.nodeView ) {
		mwData = ve.copy( this.node.getModel().getAttribute( 'mw' ) );
		mwData.body.extsrc = this.input.getValue();
		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges(
				surfaceModel.getDocument(), this.node.getOuterRange().start, { 'mw': mwData }
			)
		);
	} else {
		mwData = {
			'name': this.constructor.static.nodeModel.static.extensionName,
			'attrs': {},
			'body': {
				'extsrc': this.input.getValue()
			}
		};
		surfaceModel.getFragment().collapseRangeToEnd().insertContent( [
			{
				'type': this.constructor.static.nodeModel.static.name,
				'attributes': {
					'mw': mwData
				}
			},
			{ 'type': '/' + this.constructor.static.nodeModel.static.name }
		] );
	}
};
