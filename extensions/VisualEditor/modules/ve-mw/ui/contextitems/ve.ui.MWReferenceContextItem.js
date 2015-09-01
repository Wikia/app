/*!
 * VisualEditor MWReferenceContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context item for a MWReference.
 *
 * @class
 * @extends ve.ui.LinearContextItem
 *
 * @constructor
 * @param {ve.ui.Context} context Context item is in
 * @param {ve.dm.Model} model Model item is related to
 * @param {Object} config Configuration options
 */
ve.ui.MWReferenceContextItem = function VeUiMWReferenceContextItem() {
	// Parent constructor
	ve.ui.MWReferenceContextItem.super.apply( this, arguments );
	this.view = null;
	// Initialization
	this.$element.addClass( 've-ui-mwReferenceContextItem' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceContextItem, ve.ui.LinearContextItem );

/* Static Properties */

ve.ui.MWReferenceContextItem.static.name = 'reference';

ve.ui.MWReferenceContextItem.static.icon = 'reference';

ve.ui.MWReferenceContextItem.static.label = OO.ui.deferMsg( 'visualeditor-dialogbutton-reference-title' );

ve.ui.MWReferenceContextItem.static.modelClasses = [ ve.dm.MWReferenceNode ];

ve.ui.MWReferenceContextItem.static.commandName = 'reference';

/* Methods */

/**
 * Get a DOM rendering of the reference.
 *
 * @private
 * @return {jQuery} DOM rendering of reference
 */
ve.ui.MWReferenceContextItem.prototype.getRendering = function () {
	var refModel;
	if ( this.model.isEditable() ) {
		refModel = ve.dm.MWReferenceModel.static.newFromReferenceNode( this.model );
		this.view = new ve.ui.PreviewWidget(
			refModel.getDocument().getInternalList().getItemNode( refModel.getListIndex() )
		);

		// The $element property may be rendered into asynchronously, update the context's size when the
		// rendering is complete if that's the case
		this.view.once( 'render', this.context.updateDimensions.bind( this.context ) );

		return this.view.$element;
	} else {
		return $( '<div>' )
			.addClass( 've-ui-mwReferenceContextItem-muted' )
			.text( ve.msg( 'visualeditor-referenceslist-missingref' ) );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceContextItem.prototype.getDescription = function () {
	return this.model.isEditable() ? this.getRendering().text() : ve.msg( 'visualeditor-referenceslist-missingref' );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceContextItem.prototype.renderBody = function () {
	this.$body.empty().append( this.getRendering() );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceContextItem.prototype.teardown = function () {
	if ( this.view ) {
		this.view.destroy();
	}

	// Call parent
	ve.ui.MWReferenceContextItem.super.prototype.teardown.call( this );
};

/* Registration */

ve.ui.contextItemFactory.register( ve.ui.MWReferenceContextItem );
