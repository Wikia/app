/*!
 * VisualEditor LinkContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context item for a link.
 *
 * @class
 * @extends ve.ui.LinearContextItem
 *
 * @param {ve.ui.Context} context Context item is in
 * @param {ve.dm.Model} model Model item is related to
 * @param {Object} config Configuration options
 */
ve.ui.LinkContextItem = function VeUiLinkContextItem( context, model, config ) {
	// Parent constructor
	ve.ui.LinkContextItem.super.call( this, context, model, config );

	// Initialization
	this.$element.addClass( 've-ui-linkContextItem' );
};

/* Inheritance */

OO.inheritClass( ve.ui.LinkContextItem, ve.ui.LinearContextItem );

/* Static Properties */

ve.ui.LinkContextItem.static.name = 'link';

ve.ui.LinkContextItem.static.icon = 'link';

ve.ui.LinkContextItem.static.label = OO.ui.deferMsg( 'visualeditor-linkinspector-title' );

ve.ui.LinkContextItem.static.modelClasses = [ ve.dm.LinkAnnotation ];

ve.ui.LinkContextItem.static.embeddable = false;

ve.ui.LinkContextItem.static.commandName = 'link';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.LinkContextItem.prototype.getDescription = function () {
	return this.model.getHref();
};

/**
 * @inheritdoc
 */
ve.ui.LinkContextItem.prototype.renderBody = function () {
	var htmlDoc = this.context.getSurface().getModel().getDocument().getHtmlDocument();
	this.$body.empty().append(
		$( '<a>' )
			.text( this.getDescription() )
			.attr( {
				href: ve.resolveUrl( this.model.getHref(), htmlDoc ),
				target: '_blank'
			} )
	);
};

/* Registration */

ve.ui.contextItemFactory.register( ve.ui.LinkContextItem );
