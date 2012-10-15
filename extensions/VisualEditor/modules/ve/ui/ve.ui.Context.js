/**
 * Creates an ve.ui.Context object.
 * 
 * @class
 * @constructor
 * @param {jQuery} $overlay DOM selection to add nodes to
 */
ve.ui.Context = function( surfaceView, $overlay ) {
	// Inheritance
	if ( !surfaceView ) {
		return;
	}

	// Properties
	this.surfaceView = surfaceView;
	this.surfaceView.attachContextView( this );
	this.inspectors = {};
	this.inspector = null;
	this.position = null;
	this.$ = $( '<div class="es-contextView"></div>' ).appendTo( $overlay || $( 'body' ) );
	this.$toolbar = $( '<div class="es-contextView-toolbar"></div>' );
	this.$inspectors = $( '<div class="es-contextView-inspectors"></div>' ).appendTo( this.$ );
	this.$icon = $( '<div class="es-contextView-icon"></div>' ).appendTo( this.$ );
	this.toolbarView = new ve.ui.Toolbar(
		this.$toolbar,
		this.surfaceView,
		[{ 'name': 'textStyle', 'items' : [ 'bold', 'italic', 'link', 'clear' ] }]
	);
	this.menuView = new ve.ui.Menu( [
			// Example menu items
			{ 'name': 'tools', '$': this.$toolbar }
		],
		null,
		this.$
	);
	
	// Events
	var _this = this;
	this.$icon.bind( {
		'mousedown': function( e ) {
			if ( e.which === 1 ) {
				e.preventDefault();
				return false;
			}
		},
		'mouseup': function( e ) {
			if ( e.which === 1 ) {
				if ( _this.inspector ) {
					_this.closeInspector();
				} else {
					if ( _this.isMenuOpen() ) {
						_this.closeMenu();
					} else {
						_this.openMenu();
					}
				}
			}
		}
	} );

	// Intitialization
	this.addInspector( 'link', new ve.ui.LinkInspector( this.toolbarView, this ) );
};

/* Methods */

ve.ui.Context.prototype.getSurfaceView = function() {
	return this.surfaceView;
};

ve.ui.Context.prototype.openMenu = function() {
	this.menuView.open();
};

ve.ui.Context.prototype.closeMenu = function() {
	this.menuView.close();
};

ve.ui.Context.prototype.isMenuOpen = function() {
	return this.menuView.isOpen();
};

ve.ui.Context.prototype.set = function() {
	this.positionIcon();
	if ( this.position ) {
		this.positionOverlay( this.menuView.$ );
		if ( this.inspector ) {
			this.positionOverlay( this.inspectors[this.inspector].$ );
		}
	}
};

ve.ui.Context.prototype.positionIcon = function() {
	this.$.removeClass( 'es-contextView-position-start es-contextView-position-end' );
	var selection = this.surfaceView.getModel().getSelection(),
		offset;
	this.position = null;
	if ( selection.from < selection.to ) {
		var $lastRange = this.surfaceView.$.find( '.es-contentView-range:visible:last' );
		if ( $lastRange.length ) {
			offset = $lastRange.offset();
			this.position = new ve.Position(
				offset.left + $lastRange.width(), offset.top + $lastRange.height()
			);
			this.$.addClass( 'es-contextView-position-end' );
		}
	} else if ( selection.from > selection.to ) {
		var $firstRange = this.surfaceView.$.find( '.es-contentView-range:visible:first' );
		if ( $firstRange.length ) {
			offset = $firstRange.offset();
			this.position = new ve.Position( offset.left, offset.top );
			this.$.addClass( 'es-contextView-position-start' );
		}
	}
	if ( this.position ) {
		this.$.css( { 'left': this.position.left, 'top': this.position.top } );
		this.$icon.fadeIn( 'fast' );
	} else {
		this.$icon.hide();
	}
};

ve.ui.Context.prototype.positionOverlay = function( $overlay ) {
	this.$.removeClass( 'es-contextView-position-below es-contextView-position-above' );
	var overlayMargin = 5,
		overlayWidth = $overlay.outerWidth(),
		overlayHeight = $overlay.outerHeight(),
		$window = $( window ),
		windowWidth = $window.width(),
		windowHeight = $window.height(),
		windowScrollTop = $window.scrollTop();
	// Center align overlay
	var overlayLeft = -Math.round( overlayWidth / 2 );
	// Adjust overlay left or right depending on viewport
	if ( ( this.position.left - overlayMargin ) + overlayLeft < 0 ) {
		// Move right a bit past center
		overlayLeft -= this.position.left + overlayLeft - overlayMargin;
	} else if ( ( overlayMargin + this.position.left ) - overlayLeft > windowWidth ) {
		// Move left a bit past center
		overlayLeft += windowWidth - overlayMargin - ( this.position.left - overlayLeft );
	}
	$overlay.css( 'left', overlayLeft );
	// Position overlay on top or bottom depending on viewport
	if ( this.position.top + overlayHeight + ( overlayMargin * 2 ) < windowHeight + windowScrollTop ) {
		this.$.addClass( 'es-contextView-position-below' );
	} else {
		this.$.addClass( 'es-contextView-position-above' );
	}
};

ve.ui.Context.prototype.clear = function() {
	if ( this.inspector ) {
		this.closeInspector();
	}
	this.$icon.hide();
	this.menuView.close();
};

ve.ui.Context.prototype.openInspector = function( name ) {
	if ( !( name in this.inspectors ) ) {
		throw 'Missing inspector error. Can not open nonexistent inspector: ' + name;
	}
	this.inspectors[name].open();
	this.$inspectors.show();
	this.positionOverlay( this.inspectors[name].$ );
	this.inspector = name;
};

ve.ui.Context.prototype.closeInspector = function( accept ) {
	if ( this.inspector ) {
		this.inspectors[this.inspector].close( accept );
		this.$inspectors.hide();
		this.inspector = null;
	}
};

ve.ui.Context.prototype.getInspector = function( name ) {
	if ( name in this.inspectors ) {
		return this.inspectors[name];
	}
	return null;
};

ve.ui.Context.prototype.addInspector = function( name, inspector ) {
	if ( name in this.inspectors ) {
		throw 'Duplicate inspector error. Previous registration with the same name: ' + name;
	}
	this.inspectors[name] = inspector;
	this.$inspectors.append( inspector.$ );
};

ve.ui.Context.prototype.removeInspector = function( name ) {
	if ( name in this.inspectors ) {
		throw 'Missing inspector error. Can not remove nonexistent inspector: ' + name;
	}
	this.inspectors[name].detach();
	delete this.inspectors[name];
	this.inspector = null;
};
