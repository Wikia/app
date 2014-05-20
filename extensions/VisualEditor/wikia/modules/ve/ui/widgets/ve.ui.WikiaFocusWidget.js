/*!
 * VisualEditor UserInterface WikiaFocusWidget class.
 */

/* global mw */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {ve.ui.Surface} surface UI Surface
 */
ve.ui.WikiaFocusWidget = function VeUiWikiaFocusWidget( surface ) {

	// Parent constructor
	OO.ui.Widget.call( this );

	// Properties
	this.surface = surface;
	this.spacing = 10;
	this.uniqueLayoutId = 0;
	this.$top = this.$( '<div>' ).addClass( 've-ui-wikiaFocusWidget-top' );
	this.$right = this.$( '<div>' ).addClass( 've-ui-wikiaFocusWidget-right' );
	this.$bottom = this.$( '<div>' ).addClass( 've-ui-wikiaFocusWidget-bottom' );
	this.$left = this.$( '<div>' ).addClass( 've-ui-wikiaFocusWidget-left' );
	this.$body = this.$( this.getElementDocument() ).find( 'body:first' );
	this.$window = this.$( this.getElementWindow() );
	this.$surface = surface.$element;
	this.$pageHeader = this.$( '#WikiaPageHeader' );
	this.$pageHeaderElements = this.$pageHeader.children( ':not( h1 )' );
	this.$wikiaBarWrapper = this.$( '#WikiaBarWrapper' );
	this.$wikiaBarCollapseWrapper = this.$( '#WikiaBarCollapseWrapper' );
	this.$wikiaAds = this.$( '.wikia-ad, #WikiaAdInContentPlaceHolder' );
	if ( mw.config.get( 'wgEnableWikiaBarExt' ) && !mw.config.get( 'WikiaBar' ).isWikiaBarHidden() ) {
		this.showWikiaBar = true;
	}

	// Events
	this.surface.getView().getDocument().getDocumentNode()
		.connect( this, {
			'setup': this.onSurfaceSetup,
			'teardown': this.onSurfaceTeardown
		} );
	this.$window
		.on( {
			'resize': ve.bind( this.adjustLayout, this ),
			'scroll': $.throttle( 250, ve.bind( this.adjustLayout, this ) )
		} );
	this.surface.getModel().getDocument()
		.on( 'transact', ve.bind( this.adjustLayout, this ) );

	// Initialization
	this.$element
		.addClass( 've-ui-wikiaFocusWidget' )
		.append( this.$top, this.$right, this.$bottom, this.$left );
};

/* Inheritance */
OO.inheritClass( ve.ui.WikiaFocusWidget, OO.ui.Widget );

/* Methods */
ve.ui.WikiaFocusWidget.prototype.adjustLayout = function() {
	var surfaceOffset, surfaceEdges, documentDimensions,
		uniqueLayoutId = this.$window.width() * this.$body.outerHeight() * this.surface.$element.height();

	if ( uniqueLayoutId !== this.uniqueLayoutId ) {
		this.uniqueLayoutId = uniqueLayoutId;
		surfaceOffset = this.$surface.offset();
		surfaceEdges = {
			right: surfaceOffset.left + this.$surface.width(),
			bottom: surfaceOffset.top + this.$surface.height(),
			left: surfaceOffset.left
		};
		documentDimensions = {
			height: this.$body.outerHeight(),
			width: this.$window.width()
		};

		this.$top
			.css( {
				'height': this.$pageHeader.offset().top - this.spacing,
				'width': documentDimensions.width
			} );
		this.$right
			.css( {
				'height': documentDimensions.height,
				'width': documentDimensions.width - surfaceEdges.right - this.spacing
			} );
		this.$bottom
			.css( {
				'top': surfaceEdges.bottom,
				'height': documentDimensions.height - surfaceEdges.bottom + this.spacing,
				'width': documentDimensions.width
			} );
		this.$left
			.css( {
				'height': documentDimensions.height,
				'width': surfaceEdges.left - this.spacing
			} );
	}
};

ve.ui.WikiaFocusWidget.prototype.onSurfaceSetup = function() {
	var interval, i = 0;

	if ( this.surface.getView().getDir() === 'rtl' ) {
		this.switchDirection();
	}

	this.hideDistractions();
	this.adjustLayout();

	// Run adjustLayout() a few times while images load, etc
	interval = setInterval( ve.bind( function() {
		this.uniqueLayoutId = 0;
		this.adjustLayout();
		if ( i === 2 ) {
			clearInterval( interval );
		}
		i += 1;
	}, this ), 1000 );
};


/**
 * Switch this.$left and this.$right for RTL
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.switchDirection = function() {
	// this.$right is assigned to this.$left inside the array.
	// this.$left is assigned to the first element in the array, this.$right.
	this.$left = [this.$right, this.$right = this.$left][0];
};

ve.ui.WikiaFocusWidget.prototype.onSurfaceTeardown = function() {
	this.showDistractions();
	this.$element.remove();
};

ve.ui.WikiaFocusWidget.prototype.hideDistractions = function() {
	if ( mw.config.get( 'wgEnableWikiaBarExt' ) ) {
		mw.config.get( 'WikiaBar' ).hide();
	}
	// Visibility property - problem with edit button opening when setting display property
	this.$pageHeaderElements.css( 'visibility', 'hidden' );
	this.$wikiaAds
		.each( function() {
			var $ad = $( this );
			$ad.css( {
				'height': $ad.height(),
				'width': $ad.width()
			} );
		} )
		.addClass( 've-hidden-ad' );
};

ve.ui.WikiaFocusWidget.prototype.showDistractions = function() {
	if ( this.showWikiaBar ) {
		mw.config.get( 'WikiaBar' ).show();
	}
	this.$pageHeaderElements.css( 'visibility', 'visible' );
	this.$wikiaAds
		.css( {
			'height': 'auto',
			'width': 'auto'
		} )
		.removeClass( 've-hidden-ad' );
};
