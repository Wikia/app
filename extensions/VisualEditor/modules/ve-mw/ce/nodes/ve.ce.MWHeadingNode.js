/*!
 * VisualEditor ContentEditable MWHeadingNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MW heading node.
 *
 * @class
 * @extends ve.ce.HeadingNode
 * @constructor
 * @param {ve.dm.MWHeadingNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWHeadingNode = function VeCeMWHeadingNode( model, config ) {
	// Parent constructor
	ve.ce.HeadingNode.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWHeadingNode, ve.ce.HeadingNode );

/* Static Properties */

ve.ce.MWHeadingNode.static.name = 'mwHeading';

/* Methods */

ve.ce.MWHeadingNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.HeadingNode.prototype.onSetup.call( this );

	// Make reference to the surface
	this.surface = this.root.getSurface().getSurface();
	this.rebuildToc();
};

ve.ce.MWHeadingNode.prototype.onTeardown = function () {
	// Parent method
	ve.ce.HeadingNode.prototype.onTeardown.call( this );

	this.rebuildToc();
};

ve.ce.MWHeadingNode.prototype.rebuildToc = function () {
	if ( this.surface.mwTocWidget ) {
		this.surface.mwTocWidget.rebuild();
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWHeadingNode );
