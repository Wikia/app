/*!
 * VisualEditor UserInterface FieldsetLayout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Fieldset layout.
 *
 * @class
 * @extends ve.ui.Layout
 * @mixins ve.ui.LabeledElement
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [icon] Symbolic icon name
 */
ve.ui.FieldsetLayout = function VeUiFieldsetLayout( config ) {
	// Config initialization
	config = config || {};

	// Parent constructor
	ve.ui.Layout.call( this, config );

	// Mixin constructors
	ve.ui.LabeledElement.call( this, this.$$( '<legend>' ), config );

	// Initialization
	if ( config.icon ) {
		this.$.addClass( 've-ui-fieldsetLayout-decorated' );
		this.$label.addClass( 've-ui-icon-' + config.icon );
	}
	this.$.addClass( 've-ui-fieldsetLayout' );
	if ( config.icon || config.label ) {
		this.$
			.addClass( 've-ui-fieldsetLayout-labeled' )
			.append( this.$label );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.FieldsetLayout, ve.ui.Layout );

ve.mixinClass( ve.ui.FieldsetLayout, ve.ui.LabeledElement );

/* Static Properties */

ve.ui.FieldsetLayout.static.tagName = 'fieldset';
