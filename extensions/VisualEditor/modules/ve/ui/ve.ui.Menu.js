/**
 * VisualEditor user interface Menu class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.Menu object.
 *
 * @class
 * @constructor
 * @param {Object[]} items List of items to append initially
 * @param {Function} callback Function to call if an item doesn't have its own callback
 * @param {jQuery} [$container] Container to render menu into
 * @param {jQuery} [$overlay=$( 'body' )] Element to append menu to
 */
ve.ui.Menu = function VeUiMenu( items, callback, $container, $overlay ) {
	// Properties
	this.items = [];
	this.autoNamedBreaks = 0;
	this.callback = callback;
	this.$ = $container || $( '<div class="ve-ui-menu"></div>' );

	// Events
	this.$.on( {
		'mousedown': ve.bind( this.onMouseDown, this ),
		'mouseup': ve.bind( this.onMouseUp, this )
	} );

	// Initialization
	this.$.appendTo( $overlay || $( 'body' ) );
	this.addItems( items );
};

/* Methods */

ve.ui.Menu.prototype.onMouseDown = function ( e ) {
	if ( e.which === 1 ) {
		e.preventDefault();
		return false;
	}
};

ve.ui.Menu.prototype.onMouseUp = function ( e ) {
	var name, i, len, $item;
	if ( e.which === 1 ) {
		$item = $( e.target ).closest( '.ve-ui-menu-item' );
		if ( $item.length ) {
			name = $item.attr( 'rel' );
			for ( i = 0, len = this.items.length; i < len; i++ ) {
				if ( this.items[i].name === name ) {
					this.onSelect( this.items[i], e );
					return true;
				}
			}
		}
	}
};

ve.ui.Menu.prototype.addItems = function ( items, before ) {
	var i, len;
	if ( !ve.isArray( items ) ) {
		throw new Error( 'Invalid items, must be array of objects.' );
	}
	for ( i = 0, len = items.length; i < len; i++ ) {
		this.addItem( items[i], before );
	}
};

ve.ui.Menu.prototype.addItem = function ( item, before ) {
	if ( item === '-' ) {
		item = {
			'name': 'break-' + this.autoNamedBreaks++
		};
	}
	// Items that don't have custom DOM elements will be auto-created
	if ( !item.$ ) {
		if ( !item.name ) {
			throw new Error( 'Invalid menu item error. Items must have a name property.' );
		}
		if ( item.label ) {
			item.$ = $( '<div class="ve-ui-menu-item"></div>' )
				.attr( 'rel', item.name )
				// TODO: this should take a labelmsg instead and call ve.msg()
				.append( $( '<span>' ).text( item.label ) );
		} else {
			// No label, must be a break
			item.$ = $( '<div class="ve-ui-menu-break"></div>' )
				.attr( 'rel', item.name );
		}
		// TODO: Keyboard shortcut (and icons for them), support for keyboard accelerators, etc.
	}
	if ( before ) {
		for ( var i = 0; i < this.items.length; i++ ) {
			if ( this.items[i].name === before ) {
				this.items.splice( i, 0, item );
				this.items[i].$.before( item.$ );
				return;
			}
		}
	}
	this.items.push( item );
	this.$.append( item.$ );
};

ve.ui.Menu.prototype.removeItem = function ( name ) {
	for ( var i = 0; i < this.items.length; i++ ) {
		if ( this.items[i].name === name ) {
			this.items.splice( i, 1 );
			i--;
		}
	}
};

ve.ui.Menu.prototype.getItems = function () {
	return this.items;
};

ve.ui.Menu.prototype.setPosition = function ( position ) {
	return this.$.css( {
		'top': position.top,
		'left': position.left
	} );
};

ve.ui.Menu.prototype.open = function () {
	this.$.show();
};

ve.ui.Menu.prototype.close = function () {
	this.$.hide();
};

ve.ui.Menu.prototype.isOpen = function () {
	return this.$.is( ':visible' );
};

ve.ui.Menu.prototype.onSelect = function ( item ) {
	if ( typeof item.callback === 'function' ) {
		item.callback( item );
	} else if ( typeof this.callback === 'function' ) {
		this.callback( item );
	}
	this.close();
};
