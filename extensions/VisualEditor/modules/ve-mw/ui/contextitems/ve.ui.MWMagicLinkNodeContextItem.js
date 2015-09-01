/*!
 * VisualEditor MWMagicLinkNodeContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context item for a MWMagicLinkNode.
 *
 * @class
 * @extends ve.ui.LinkContextItem
 *
 * @constructor
 * @param {ve.ui.Context} context Context item is in
 * @param {ve.dm.MWMagicLinkNode} model Model item is related to
 * @param {Object} config Configuration options
 */
ve.ui.MWMagicLinkNodeContextItem = function VeUiMWMagicLinkNodeContextItem() {
	// Parent constructor
	ve.ui.MWMagicLinkNodeContextItem.super.apply( this, arguments );

	// Initialization
	this.$element.addClass( 've-ui-mwMagicLinkNodeContextItem' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMagicLinkNodeContextItem, ve.ui.LinkContextItem );

/* Static Properties */

ve.ui.MWMagicLinkNodeContextItem.static.name = 'link/mwMagic';

ve.ui.MWMagicLinkNodeContextItem.static.label = null; // see #setup()

ve.ui.MWMagicLinkNodeContextItem.static.modelClasses = [ ve.dm.MWMagicLinkNode ];

/* Methods */

ve.ui.MWMagicLinkNodeContextItem.prototype.setup = function () {
	// Set up label
	var msg = 'visualeditor-magiclinknodeinspector-title-' +
		this.model.getMagicType().toLowerCase();
	this.setLabel( OO.ui.deferMsg( msg ) );
	// Invoke superclass method.
	return ve.ui.MWMagicLinkNodeContextItem.super.prototype.setup.call( this );
};

ve.ui.MWMagicLinkNodeContextItem.prototype.getDescription = function () {
	return this.model.getAttribute( 'content' );
};

/* Registration */

ve.ui.contextItemFactory.register( ve.ui.MWMagicLinkNodeContextItem );
