/*!
 * VisualEditor ContentEditable WikiaGalleryNode class.
 */

/* global require */

/**
 * ContentEditable Wikia gallery node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.FocusableNode
 *
 * @constructor
 * @param {ve.dm.WikiaGalleryNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaGalleryNode = function VeCeWikiaGalleryNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaGalleryNode.super.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );

	// Initialize
	this.rebuild();

	// Events
	this.model.connect( this, {
		'update': 'onModelUpdate'
	} );
	this.connect( this, { 'childUpdate': 'onChildUpdate' } );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryNode, ve.ce.BranchNode );

OO.mixinClass( ve.ce.WikiaGalleryNode, ve.ce.FocusableNode );

/* Static Properties */

ve.ce.WikiaGalleryNode.static.name = 'wikiaGallery';

ve.ce.WikiaGalleryNode.static.tagName = 'div';

/* Methods */

ve.ce.WikiaGalleryNode.prototype.onChildUpdate = function () {
	console.log( 've.ce.WikiaGalleryNode.prototype.onChildUpdate' );
	setTimeout( ve.bind( this.rebuild, this ), 0 );
	//this.rebuild();
};

ve.ce.WikiaGalleryNode.prototype.rebuild = function () {
	var i;
	this.$element.html( '' );
	for( i = 0; i < this.children.length; i++ ) {
		try {
			this.$element.append(
				'CHILD ' + i + ', CAPTION' + this.children[i].children[0].$element.html()
			);
		} catch( e ) {
			this.$element.append('CHILD ' + i + ', NO CAPTION');
		}
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaGalleryNode );
