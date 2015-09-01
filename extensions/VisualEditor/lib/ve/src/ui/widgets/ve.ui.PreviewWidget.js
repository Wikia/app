/*!
 * VisualEditor UserInterface PreviewWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.PreviewWidget object.
 *
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {ve.dm.Node} nodeModel Model from which to create a preview
 * @param {Object} [config] Configuration options
 */
ve.ui.PreviewWidget = function VeUiPreviewWidget( nodeModel, config ) {
	var promise, promises = [],
		widget = this;

	// Parent constructor
	OO.ui.Widget.call( this, config );

	this.model = nodeModel;

	// Initial CE node
	this.rendering = ve.ce.nodeFactory.create( this.model.getType(), this.model );

	// Traverse children to see when they are all rerendered
	if ( this.rendering instanceof ve.ce.BranchNode ) {
		ve.BranchNode.static.traverse( this.rendering, function ( node ) {
			if ( typeof node.generateContents === 'function' ) {
				if ( node.isGenerating() ) {
					promise = $.Deferred();
					node.once( 'rerender', promise.resolve );
					promises.push( promise );
				}
			}
		} );
	} else if ( typeof this.rendering.generateContents === 'function' ) {
		if ( this.rendering.isGenerating() ) {
			promise = $.Deferred();
			this.rendering.once( 'rerender', promise.resolve );
			promises.push( promise );
		}
	}

	// When all children are rerendered, replace with dm DOM
	$.when.apply( $, promises )
		.then( function () {
			// Verify that the widget and/or the ce node weren't destroyed
			if ( widget.rendering ) {
				widget.replaceWithModelDom();
			}
		} );

	// Initialize
	this.$element.addClass( 've-ui-previewWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.PreviewWidget, OO.ui.Widget );

/**
 * Destroy the preview node.
 */
ve.ui.PreviewWidget.prototype.destroy = function () {
	if ( this.rendering ) {
		this.rendering.destroy();
		this.rendering = null;
	}
};

/**
 * Replace the content of the body with the model DOM
 *
 * @fires render
 */
ve.ui.PreviewWidget.prototype.replaceWithModelDom = function () {
	var preview = ve.dm.converter.getDomFromModel( this.model.getDocument(), true ),
		$preview = $( preview.body );

	// Resolve attributes
	ve.resolveAttributes(
		$preview,
		this.model.getDocument().getHtmlDocument(),
		ve.dm.Converter.computedAttributes
	);

	// Make all links open in a new window (sync rendering)
	$preview.find( 'a' ).attr( 'target', '_blank' );

	// Replace content
	this.$element.empty().append( $preview.contents() );

	// Event
	this.emit( 'render' );

	// Cleanup
	this.rendering.destroy();
	this.rendering = null;
};

/**
 * Check if the preview is still generating
 *
 * @return {boolean} Still generating
 */
ve.ui.PreviewWidget.prototype.isGenerating = function () {
	return this.rendering && this.rendering.isGenerating();
};
