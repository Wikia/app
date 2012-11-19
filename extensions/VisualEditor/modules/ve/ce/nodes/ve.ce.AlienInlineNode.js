/**
 * VisualEditor content editable AlienInlineNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for an alien inline node.
 *
 * @class
 * @constructor
 * @extends {ve.ce.AlienNode}
 * @param {ve.dm.AlienInlineNode} model Model to observe.
 */
ve.ce.AlienInlineNode = function VeCeAlienInlineNode( model ) {
	// Parent constructor
	ve.ce.AlienNode.call( this, 'alienInline', model );

	// DOM Changes
	this.$.addClass( 've-ce-alienInlineNode' );

	// Events
	this.$.on( 'mouseenter', ve.bind( this.onMouseEnter, this ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.AlienInlineNode, ve.ce.AlienNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.AlienInlineNode.rules = {
	'canBeSplit': false
};

/* Methods */

ve.ce.AlienInlineNode.prototype.onMouseEnter = function () {
	var	$phantom = ve.ce.Surface.static.$phantomTemplate.clone(),
		offset = this.$.offset(),
		surface = this.root.getSurface();
	$phantom.css( {
		'top': offset.top,
		'left': offset.left,
		'height': this.$.height(),
		'width': this.$.width()
	} );
	surface.$phantoms.empty().append( $phantom );
	surface.$.on( 'mousemove.phantoms', ve.bind( this.onSurfaceMouseMove, this ) );
};

/* Registration */

ve.ce.nodeFactory.register( 'alienInline', ve.ce.AlienInlineNode );
