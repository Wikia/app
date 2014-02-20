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
 * @param {ve.ui.WindowSet} windowSet Window set this inspector is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWExtensionInspector = function VeUiMWExtensionInspector( windowSet, config ) {
	// Parent constructor
	ve.ui.Inspector.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWExtensionInspector, ve.ui.Inspector );

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

	this.input = new OO.ui.TextInputWidget( {
		'$': this.$,
		'overlay': this.surface.$localOverlay,
		'multiline': true
	} );
	this.input.$element.addClass( 've-ui-mwExtensionInspector-input' );

	// Initialization
	this.$form.append( this.input.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.Inspector.prototype.setup.call( this, data );

	// Initialization
	this.node = this.surface.getView().getFocusedNode();
	this.input.setValue( this.node ? this.node.getModel().getAttribute( 'mw' ).body.extsrc : '' );

	// Direction of the input textarea should correspond to the
	// direction of the surrounding content of the node itself
	// rather than the GUI direction:
	this.input.setRTL( this.node.$element.css( 'direction' ) === 'rtl' );
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.ready = function () {
	// Parent method
	ve.ui.Inspector.prototype.ready.call( this );

	// Focus the input
	this.input.$input.focus().select();
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.teardown = function ( data ) {
	var mwData,
		surfaceModel = this.surface.getModel();

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

	// Parent method
	ve.ui.Inspector.prototype.teardown.call( this, data );
};
