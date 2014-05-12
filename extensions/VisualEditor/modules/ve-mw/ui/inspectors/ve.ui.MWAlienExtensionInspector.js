/*!
 * VisualEditor UserInterface MWAlienExtensionInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki alien extension inspector.
 *
 * @class
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWAlienExtensionInspector = function VeUiMWAlienExtensionInspector( config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, config );

	// Properties
	this.attributeInputs = {};
	this.$attributes = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWAlienExtensionInspector, ve.ui.MWExtensionInspector );

/* Static properties */

ve.ui.MWAlienExtensionInspector.static.name = 'alienExtension';

ve.ui.MWAlienExtensionInspector.static.icon = 'alienextension';

ve.ui.MWAlienExtensionInspector.static.title =
	OO.ui.deferMsg( 'visualeditor-mwalienextensioninspector-title' );

ve.ui.MWAlienExtensionInspector.static.nodeModel = ve.dm.MWAlienExtensionNode;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.getTitle = function () {
	return this.getFragment().getSelectedNode().getExtensionName();
};

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.initialize.apply( this, arguments );

	this.$attributes = this.$( '<div>' ).addClass( 've-ui-mwAlienExtensionInspector-attributes' );
	this.$form.append( this.$attributes );
};

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.setup = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.setup.apply( this, arguments );

	var key, attributeInput, field,
		attributes = this.getFragment().getSelectedNode().getAttribute( 'mw' ).attrs;

	if ( attributes && !ve.isEmptyObject( attributes ) ) {
		for ( key in attributes ) {
			attributeInput = new OO.ui.TextInputWidget( {
				'$': this.$,
				'value': attributes[key]
			} );
			this.attributeInputs[key] = attributeInput;
			field = new OO.ui.FieldLayout(
				attributeInput,
				{
					'$': this.$,
					'align': 'left',
					'label': key
				}
			);
			this.$attributes.append( field.$element );
		}
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.teardown = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.teardown.apply( this, arguments );

	this.$attributes.empty();
	this.attributeInputs = {};
};

/** */
ve.ui.MWAlienExtensionInspector.prototype.updateMwData = function ( mwData ) {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.updateMwData.call( this, mwData );

	var key;

	if ( !ve.isEmptyObject( this.attributeInputs ) ) {
		// Make sure we have an attrs object to populate
		mwData.attrs = mwData.attrs || {};
		for ( key in this.attributeInputs ) {
			mwData.attrs[key] = this.attributeInputs[key].getValue();
		}
	}
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWAlienExtensionInspector );
