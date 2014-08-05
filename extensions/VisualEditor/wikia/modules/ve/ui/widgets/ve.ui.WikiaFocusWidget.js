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
	ve.ui.WikiaFocusWidget.super.call( this );

	// Properties
	this.surface = surface;
	this.spacing = 10;
	this.uniqueLayoutId = 0;
	this.$top = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-shield ve-ui-wikiaFocusWidget-topShield' );
	this.$right = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-shield ve-ui-wikiaFocusWidget-rightShield' );
	this.$bottom = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-shield ve-ui-wikiaFocusWidget-bottomShield' );
	this.$left = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-shield ve-ui-wikiaFocusWidget-leftShield' );
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

	// A/B Test Elements, may be added onDocumentSetup.
	this.$topStroke = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-stroke ve-ui-wikiaFocusWidget-topStroke' );
	this.$rightStroke = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-stroke ve-ui-wikiaFocusWidget-rightStroke' );
	this.$bottomStroke = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-stroke ve-ui-wikiaFocusWidget-bottomStroke' );
	this.$leftStroke = this.$( '<div>' )
		.addClass( 've-ui-wikiaFocusWidget-stroke ve-ui-wikiaFocusWidget-leftStroke' );

	// Events
	this.surface.getView().getDocument().getDocumentNode()
		.connect( this, {
			'setup': this.onDocumentSetup,
			'teardown': this.onDocumentTeardown
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
ve.ui.WikiaFocusWidget.prototype.adjustLayout = function () {
	var surfaceOffset, surfaceEdges, documentDimensions, topEdge,
		uniqueLayoutId = this.$window.width() * this.$body.outerHeight() * this.surface.$element.height();

	if ( uniqueLayoutId !== this.uniqueLayoutId ) {
		this.uniqueLayoutId = uniqueLayoutId;
		surfaceOffset = this.$surface.offset();
		surfaceEdges = {
			right: surfaceOffset.left + this.$surface.width(),
			bottom: surfaceOffset.top + this.$surface.height(),
			left: surfaceOffset.left,
			top: surfaceOffset.top
		};
		documentDimensions = {
			height: this.$body.outerHeight(),
			width: this.$window.width()
		};
		// Handle NS_USER
		topEdge = mw.config.get( 'wgNamespaceNumber' ) === 2 ? surfaceEdges.top : this.$pageHeader.offset().top;

		this.$top
			.css( {
				'height': topEdge - this.spacing,
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

		if ( window.veFocusMode === 'opaque' ) {
			this.$topStroke
				.css( {
					'top': topEdge - this.spacing,
					'left': surfaceEdges.left - this.spacing,
					'width': surfaceEdges.right - surfaceEdges.left + ( this.spacing * 2 )
				} );
			this.$rightStroke
				.css( {
					'top': topEdge - this.spacing,
					'left': surfaceEdges.right + this.spacing,
					'height': surfaceEdges.bottom - topEdge + this.spacing
				} );
			this.$bottomStroke
				.css( {
					'top': surfaceEdges.bottom,
					'left': surfaceEdges.left - this.spacing,
					'width': surfaceEdges.right - surfaceEdges.left + ( this.spacing * 2 )
				} );
			this.$leftStroke
				.css( {
					'top': topEdge - this.spacing,
					'left': surfaceEdges.left - this.spacing - 1,
					'height': surfaceEdges.bottom - topEdge + this.spacing
				} );
		}

	}
};

ve.ui.WikiaFocusWidget.prototype.onDocumentSetup = function () {
	var interval, i = 0;

	if ( this.surface.getDir() === 'rtl' ) {
		this.switchDirection();
	}

	/* Optimizely */
	if ( window.veFocusMode !== undefined ) {
		this.$element.addClass( 'optimizely-' + window.veFocusMode );

		if ( window.veFocusMode === 'opaque' ) {
			this.$element.append( this.$topStroke, this.$rightStroke, this.$bottomStroke, this.$leftStroke );
		}
	}

	this.hideDistractions();
	this.adjustLayout();

	// Run adjustLayout() a few times while images load, etc
	interval = setInterval( ve.bind( function () {
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
ve.ui.WikiaFocusWidget.prototype.switchDirection = function () {
	// this.$right is assigned to this.$left inside the array.
	// this.$left is assigned to the first element in the array, this.$right.
	this.$left = [this.$right, this.$right = this.$left][0];
};

ve.ui.WikiaFocusWidget.prototype.onDocumentTeardown = function () {
	this.showDistractions();
	this.$element.remove();
};

ve.ui.WikiaFocusWidget.prototype.hideDistractions = function () {
	if ( mw.config.get( 'wgEnableWikiaBarExt' ) ) {
		mw.config.get( 'WikiaBar' ).hide();
	}
	// Visibility property - problem with edit button opening when setting display property
	this.$pageHeaderElements.css( 'visibility', 'hidden' );
	this.$wikiaAds
		.each( function () {
			var $ad = $( this );
			$ad.css( {
				'height': $ad.height(),
				'width': $ad.width()
			} );
		} )
		.addClass( 've-hidden-ad' );
};

ve.ui.WikiaFocusWidget.prototype.showDistractions = function () {
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
