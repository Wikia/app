/*!
 * VisualEditor ContentEditable ProtectedNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable protected node.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} [$phantomable=this.$] Element to show a phantom for
 */
ve.ce.ProtectedNode = function VeCeProtectedNode( $phantomable ) {
	// Properties
	this.$phantoms = $( [] );
	this.$shields = $( [] );
	this.$phantomable = $phantomable || this.$;
	this.isSetup = false;

	// Events
	this.connect( this, {
		'setup': 'onProtectedSetup',
		'teardown': 'onProtectedTeardown'
	} );
};

/* Static Properties */

ve.ce.ProtectedNode.static = {};

/**
 * Template for shield elements.
 *
 * Uses data URI to inject a 1x1 transparent GIF image into the DOM.
 *
 * @property {jQuery}
 * @static
 * @inheritable
 */
ve.ce.ProtectedNode.static.$shieldTemplate = $( '<img>' )
	.addClass( 've-ce-protectedNode-shield' )
	.attr( 'src', 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' );

/**
 * Phantom element template.
 *
 * @property {jQuery}
 * @static
 * @inheritable
 */
ve.ce.ProtectedNode.static.$phantomTemplate = $( '<div>' )
	.addClass( 've-ce-protectedNode-phantom' )
	.attr( 'draggable', false );

/* Methods */

/**
 * Handle setup events.
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.onProtectedSetup = function () {
	var $shield,
		node = this,
		$shieldTemplate = this.constructor.static.$shieldTemplate;

	// Exit if already setup or not unattached
	if ( this.isSetup || !this.root ) {
		return;
	}

	// Events
	this.$.on( 'mouseenter.ve-ce-protectedNode', ve.bind( this.onProtectedMouseEnter, this ) );
	this.getRoot().getSurface().getModel()
		.connect( this, { 'change': 'onSurfaceModelChange' } );
	this.getRoot().getSurface().getSurface()
		.connect( this, { 'position': 'positionPhantoms' } );

	// DOM changes
	this.$
		.addClass( 've-ce-protectedNode' )
		.prop( 'contentEditable', 'false' );

	// Shields
	this.$.add( this.$.find( '*' ) ).each( function () {
		var $this = $( this );
		if ( this.nodeType === Node.ELEMENT_NODE ) {
			/**
			 * These elements should not get sheilds:
			 * 1. An element with class 've-no-shield'
			 * 2. A non-floated element that is not the main protectedNode
			 */
			if (
				$this.hasClass( 've-no-shield' ) ||
				(
					( $this.css( 'float' ) === 'none' || $this.css( 'float' ) === '' ) &&
					!$this.hasClass( 've-ce-protectedNode' ) &&
					// Phantoms are built off shields, so make sure $phantomable has a shield
					!$this.is( node.$phantomable )
				)
			) {
				return;
			}
			$shield = $shieldTemplate.clone().appendTo( $this );
			node.$shields = node.$shields.add( $shield );
		}
	} );

	this.isSetup = true;
};

/**
 * Handle teardown events.
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.onProtectedTeardown = function () {
	// Exit if not setup or not attached
	if ( !this.isSetup || !this.root ) {
		return;
	}

	// Events
	this.$.off( '.ve-ce-protectedNode' );
	this.root.getSurface().getModel()
		.disconnect( this, { 'change': 'onSurfaceModelChange' } );
	this.getRoot().getSurface().getSurface()
		.disconnect( this, { 'position': 'positionPhantoms' } );

	// Shields
	this.$shields.remove();
	this.$shields = $( [] );

	// Phantoms
	this.clearPhantoms();

	// DOM changes
	this.$
		.removeClass( 've-ce-protectedNode' )
		.removeProp( 'contentEditable' );

	this.isSetup = false;
};

/**
 * Handle phantom mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ce.ProtectedNode.prototype.onPhantomMouseDown = function ( e ) {
	var surfaceModel = this.getRoot().getSurface().getModel(),
		selectionRange = surfaceModel.getSelection(),
		nodeRange = this.model.getOuterRange();

	surfaceModel.getFragment(
		e.shiftKey ?
			ve.Range.newCoveringRange(
				[ selectionRange, nodeRange ], selectionRange.from > nodeRange.from
			) :
			nodeRange
	).select();

	e.preventDefault();
};

/**
 * Handle mouse enter events.
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.onProtectedMouseEnter = function () {
	if ( !this.root.getSurface().dragging ) {
		this.createPhantoms();
	}
};

/**
 * Handle surface mouse move events.
 *
 * @method
 * @param {jQuery.Event} e Mouse move event
 */
ve.ce.ProtectedNode.prototype.onSurfaceMouseMove = function ( e ) {
	var $target = $( e.target );
	if (
		!$target.hasClass( 've-ce-protectedNode-phantom' ) &&
		$target.closest( '.ve-ce-protectedNode' ).length === 0
	) {
		this.clearPhantoms();
	}
};

/**
 * Handle surface mouse out events.
 *
 * @method
 * @param {jQuery.Event} e
 */
ve.ce.ProtectedNode.prototype.onSurfaceMouseOut = function ( e ) {
	if ( e.toElement === null ) {
		this.clearPhantoms();
	}
};

/**
 * Handle surface model change events
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.onSurfaceModelChange = function () {
	if ( this.$phantoms.length ) {
		this.positionPhantoms();
	}
};

/**
 * Creates phantoms
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.createPhantoms = function () {
	var $phantomTemplate = this.constructor.static.$phantomTemplate,
		surface = this.root.getSurface();

	this.$phantomable.find( '.ve-ce-protectedNode-shield' ).each(
		ve.bind( function () {
			this.$phantoms = this.$phantoms.add(
				$phantomTemplate.clone().on( 'mousedown', ve.bind( this.onPhantomMouseDown, this ) )
			);
		}, this )
	);
	this.positionPhantoms();
	surface.replacePhantoms( this.$phantoms );

	surface.$.on( {
		'mousemove.ve-ce-protectedNode': ve.bind( this.onSurfaceMouseMove, this ),
		'mouseout.ve-ce-protectedNode': ve.bind( this.onSurfaceMouseOut, this )
	} );
};

/**
 * Positions phantoms
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.positionPhantoms = function () {
	this.$phantomable.find( '.ve-ce-protectedNode-shield' ).each(
		ve.bind( function ( i, element ) {
			var $shield = $( element ),
				offset = ve.Element.getRelativePosition(
					$shield, this.getRoot().getSurface().getSurface().$
				);
			this.$phantoms.eq( i ).css( {
				'top': offset.top,
				'left': offset.left,
				'height': $shield.height(),
				'width': $shield.width(),
				'background-position': -offset.left + 'px ' + -offset.top + 'px'
			} );
		}, this )
	);
};

/**
 * Clears all phantoms and unbinds .ve-ce-protectedNode namespace event handlers
 *
 * @method
 */
ve.ce.ProtectedNode.prototype.clearPhantoms = function () {
	var surface = this.root.getSurface();
	surface.replacePhantoms( null );
	surface.$.unbind( '.ve-ce-protectedNode' );
	this.$phantoms = $( [] );
};
