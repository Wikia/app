/**
 * Creates an ve.ui.DropdownTool object.
 * 
 * @class
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {String} name
 * @param {Object[]} items
 */
ve.ui.DropdownTool = function( toolbar, name, title, items ) {
	// Inheritance
	ve.ui.Tool.call( this, toolbar, name, title );
	if ( !name ) {
		return;
	}

	// Properties
	var _this = this;
	this.menuView = new ve.ui.Menu( items, function( item ) {
		_this.onSelect( item );
		_this.$label.text( item.label );
	}, this.$ );
	this.$label = $( '<div class="es-toolbarDropdownTool-label"></div>' ).appendTo( this.$ );

	// Events
	$( document )
		.add( this.toolbar.surfaceView.$ )
			.mousedown( function( e ) {
				if ( e.which === 1 ) {
					_this.menuView.close();
				}
			} );
	this.$.bind( {
		'mousedown': function( e ) {
			if ( e.which === 1 ) {
				e.preventDefault();
				return false;
			}
		},
		'mouseup': function( e ) {
			// Don't respond to menu clicks
			var $item = $( e.target ).closest( '.es-menuView' );
			if ( e.which === 1 && $item.length === 0 ) {
				_this.menuView.open();
			} else {
				_this.menuView.close();
			}
		}
	} );

	// DOM Changes
	this.$.addClass( 'es-toolbarDropdownTool' ).addClass( 'es-toolbarDropdownTool-' + name );
};

/* Methods */

ve.ui.DropdownTool.prototype.onSelect = function( item ) {
	throw 'DropdownTool.onSelect not implemented in this subclass:' + this.constructor;
};

/* Inheritance */

ve.extendClass( ve.ui.DropdownTool, ve.ui.Tool );
