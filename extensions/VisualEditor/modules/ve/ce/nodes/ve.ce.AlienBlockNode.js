/**
 * VisualEditor content editable AlienBlockNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for an alien block node.
 *
 * @class
 * @constructor
 * @extends {ve.ce.AlienNode}
 * @param {ve.dm.AlienBlockNode} model Model to observe.
 */
ve.ce.AlienBlockNode = function VeCeAlienBlockNode( model ) {
	// Parent constructor
	ve.ce.AlienNode.call( this, 'alienBlock', model );

	// DOM Changes
	this.$.addClass( 've-ce-alienBlockNode' );

	// Events
	this.addListenerMethod( this, 'live', 'onLive' );
	this.$.on( 'mouseenter', ve.bind( this.onMouseEnter, this ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.AlienBlockNode, ve.ce.AlienNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.AlienBlockNode.rules = {
	'canBeSplit': false
};

/* Methods */
ve.ce.AlienBlockNode.prototype.onMouseEnter = function () {
	var	$phantoms = $( [] ),
		$phantomTemplate = ve.ce.Surface.static.$phantomTemplate,
		surface = this.root.getSurface();

	this.$.find( '.ve-ce-node-shield' ).each( function () {
		var	$shield = $( this ),
			offset = $shield.offset();
		$phantoms = $phantoms.add(
			$phantomTemplate.clone().css( {
				'top': offset.top,
				'left': offset.left,
				'height': $shield.height(),
				'width': $shield.width(),
				'background-position': -offset.left + 'px ' + -offset.top + 'px'
			} )
		);
	} );
	surface.$phantoms.empty().append( $phantoms );
	surface.$.on( 'mousemove.phantoms', ve.bind( this.onSurfaceMouseMove, this ) );
};

ve.ce.AlienBlockNode.prototype.onLive = function (live) {
	if( this.live === true ) {
		var $shieldTemplate = this.constructor.static.$shieldTemplate;
		this.$.add( this.$.find( '*' ) ).each( function () {
			var $this = $( this );
			if ( this.nodeType === Node.ELEMENT_NODE ) {
				if (
					( $this.css( 'float' ) === 'none' || $this.css( 'float' ) === '' ) &&
					!$this.hasClass( 've-ce-alienBlockNode' )
				) {
					return;
				}
				$this.append( $shieldTemplate.clone() );
			}
		} );
	}
};

/* Registration */

ve.ce.nodeFactory.register( 'alienBlock', ve.ce.AlienBlockNode );
