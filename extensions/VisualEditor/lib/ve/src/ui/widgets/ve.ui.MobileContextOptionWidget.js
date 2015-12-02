/*!
 * VisualEditor Mobile Context Item widget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Mobile version of context item widget
 *
 * @class
 * @extends ve.ui.ContextOptionWidget
 *
 * @constructor
 * @param {Function} tool
 * @param {ve.dm.Node|ve.dm.Annotation} model
 * @param {Object} [config]
 */
ve.ui.MobileContextOptionWidget = function VeUiContextOptionWidget() {
	// Parent constructor
	ve.ui.MobileContextOptionWidget.super.apply( this, arguments );

	this.$element.addClass( 've-ui-mobileContextOptionWidget' );
	this.setLabel(
		this.$( '<span>' ).addClass( 've-ui-mobileContextOptionWidget-label-secondary' )
			.text( ve.msg( 'visualeditor-contextitemwidget-label-secondary' ) )
			.add(
				this.$( '<span>' ).addClass( 've-ui-mobileContextOptionWidget-label-primary' )
					.text( this.getDescription() )
			)
	);
};

/* Setup */

OO.inheritClass( ve.ui.MobileContextOptionWidget, ve.ui.ContextOptionWidget );
