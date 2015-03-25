/*!
 * VisualEditor UserInterface MWAlienExtensionInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for editing alienated MediaWiki extensions.
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
ve.ui.MWAlienExtensionInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.initialize.apply( this, arguments );

	this.$attributes = this.$( '<div>' ).addClass( 've-ui-mwAlienExtensionInspector-attributes' );
	this.form.$element.append( this.$attributes );
};

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWAlienExtensionInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var key, attributeInput, field,
				attributes = this.getFragment().getSelectedNode().getAttribute( 'mw' ).attrs;

			if ( attributes && !ve.isEmptyObject( attributes ) ) {
				for ( key in attributes ) {
					attributeInput = new OO.ui.TextInputWidget( {
						$: this.$,
						value: attributes[key]
					} );
					this.attributeInputs[key] = attributeInput;
					field = new OO.ui.FieldLayout(
						attributeInput,
						{
							$: this.$,
							align: 'left',
							label: key
						}
					);
					this.$attributes.append( field.$element );
				}
			}

			this.title.setLabel( this.getFragment().getSelectedNode().getExtensionName() );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWAlienExtensionInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.$attributes.empty();
			this.attributeInputs = {};
		}, this );
};

/** */
ve.ui.MWAlienExtensionInspector.prototype.updateMwData = function ( mwData ) {
	// Parent method
	ve.ui.MWAlienExtensionInspector.super.prototype.updateMwData.call( this, mwData );

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

ve.ui.windowFactory.register( ve.ui.MWAlienExtensionInspector );
