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
	this.node = null;
	this.spacing = this.constructor.static.getSpacing();
	this.layout = null;
	this.layoutHash = null;
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
	this.$pageHeaderElements = this.$( '#WikiaPageHeader' ).children( ':not( .header-container  )' ).add( '.header-tally' );

	this.$navBackground = this.$( '.WikiNav .navbackground' );
	this.$localNavigation = this.$( '#localNavigation' );
	this.$wikiaBarWrapper = this.$( '#WikiaBarWrapper' );
	this.$wikiaBarCollapseWrapper = this.$( '#WikiaBarCollapseWrapper' );
	this.$wikiaAds = this.$( '.hide-to-edit, .hide-for-edit, .wikia-ad, #WikiaAdInContentPlaceHolder' );
	if ( mw.config.get( 'WikiaBar' ) && !mw.config.get( 'WikiaBar' ).isWikiaBarHidden() ) {
		this.showWikiaBar = true;
	}
	this.$njordHeroModule = this.$('header.MainPageHeroHeader');
	this.$njordPageEditButton = this.$('#WikiaArticle nav.wikia-menu-button');

	// Events
	this.surface.getView().getDocument().getDocumentNode()
		.connect( this, {
			setup: this.onDocumentSetup,
			teardown: this.onDocumentTeardown
		} );
	this.$window
		.on( {
			resize: this.adjustLayout.bind( this ),
			scroll: $.throttle( 250, this.adjustLayout.bind( this ) )
		} );
	this.surface.getModel().getDocument()
		.on( 'transact', this.adjustLayout.bind( this ) );

	// Initialization
	this.$element
		.addClass( 've-ui-wikiaFocusWidget' )
		.append( this.$top, this.$right, this.$bottom, this.$left );
};

/* Inheritance */
OO.inheritClass( ve.ui.WikiaFocusWidget, OO.ui.Widget );

/* Static Methods */

/*
 * How far the focus widget should be spaced from the edges of the surface
 * This is highly dependent on the UI of the skin. The edge of the surface may not be the visual edge of the docuemnt.
 *
 * @method
 * @returns {int} Spacing value
 */
ve.ui.WikiaFocusWidget.static.getSpacing = function () {
	return mw.config.get( 'skin' ) === 'oasis' ? 10 : 0;
};

/* Methods */

/**
 * Set which node should be focused
 *
 * @method
 * @param {ve.ce.Node} node Node to focus on
 */
ve.ui.WikiaFocusWidget.prototype.setNode = function ( node ) {
	this.node = node;
	this.adjustLayout();
	this.$element.addClass( 've-ui-wikiaFocusWidget-node' );
	//this.toolbar.disableFloatable();
};

/**
 * Unset node focus and return to article focus
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.unsetNode = function () {
	var focusWidget = this;

	this.node = null;
	this.adjustLayout();

	//this.toolbar.enableFloatable();
	// The page may already be scrolled, so trigger the scroll handler
	this.toolbar.onWindowScroll();

	// Delay for animation
	setTimeout( function () {
		focusWidget.$element.removeClass( 've-ui-wikiaFocusWidget-node' );
	}, 250 );
};

/**
 * Sets the dimensions of the focus widget shields
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.adjustLayout = function () {
	var shield,
		surfaceOffset = this.$surface.offset(),
		surfaceEdges = {
			right: surfaceOffset.left + this.$surface.width(),
			bottom: surfaceOffset.top + this.$surface.height(),
			left: surfaceOffset.left,
			top: surfaceOffset.top
		},
		documentDimensions = {
			height: this.$body.outerHeight(),
			width: this.$window.width()
		},
		layout = ( this.node ) ?
			this.getLayoutForNode( surfaceOffset, surfaceEdges, documentDimensions ) :
			this.getLayoutForArticle( surfaceOffset, surfaceEdges, documentDimensions );

	if ( OO.getHash( layout ) !== this.layoutHash ) {
		for ( shield in layout ) {
			this['$' + shield].css( layout[shield] );
		}
		this.layout = layout;
		this.layoutHash = OO.getHash( this.layout );
	}
};

/**
 * Gets the layout information for focusing on an article
 *
 * @method
 * @param {object} surfaceOffset jQuery offset() object for this.$surface
 * @param {object} surfaceEdges Location of the edges of the surface
 * @param {object} documentDimensions Size of the document
 */
ve.ui.WikiaFocusWidget.prototype.getLayoutForArticle = function ( surfaceOffset, surfaceEdges, documentDimensions ) {
	var topEdge;

	// Handle NS_USER
	topEdge = mw.config.get( 'wgNamespaceNumber' ) === 2 ?
		surfaceEdges.top :
		(
			this.$navBackground.length ?
				(this.$navBackground.offset().top + this.$navBackground.height()) :
				(this.$localNavigation.offset().top + this.$localNavigation.height())
		);

	if ( this.$njordHeroModule.length ) {
		topEdge = this.$njordPageEditButton.offset().top + this.$njordPageEditButton.outerHeight(true);
	}

	return {
		top: {
			height: topEdge,
			width: documentDimensions.width
		},
		right: {
			height: documentDimensions.height,
			width: documentDimensions.width - surfaceEdges.right - this.spacing
		},
		bottom: {
			top: surfaceEdges.bottom,
			height: documentDimensions.height - surfaceEdges.bottom + this.spacing,
			width: documentDimensions.width
		},
		left: {
			height: documentDimensions.height,
			width: surfaceEdges.left - this.spacing
		}
	};
};

/**
 * Gets the layout information for focusing on a node
 *
 * @method
 * @param {object} surfaceOffset jQuery offset() object for this.$surface
 * @param {object} surfaceEdges Location of the edges of the surface
 * @param {object} documentDimensions Size of the document
 */
ve.ui.WikiaFocusWidget.prototype.getLayoutForNode = function ( surfaceOffset, surfaceEdges, documentDimensions ) {
	var bounds = this.node.getBoundingRect();

	return {
		top: {
			height: surfaceOffset.top + bounds.top,
			width: documentDimensions.width
		},
		right: {
			height: documentDimensions.height,
			width: documentDimensions.width - surfaceEdges.left - bounds.right
		},
		bottom: {
			top: surfaceEdges.top + bounds.bottom,
			height: documentDimensions.height - bounds.bottom - surfaceEdges.top,
			width: documentDimensions.width
		},
		left: {
			height: documentDimensions.height,
			width: surfaceEdges.left + bounds.left
		}
	};
};

/**
 * Setup for focus widget
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.onDocumentSetup = function () {
	var interval,
		i = 0,
		focusWidget = this;

	this.toolbar = this.surface.getTarget().getToolbar();

	if ( this.surface.getDir() === 'rtl' ) {
		this.switchDirection();
	}

	this.hideDistractions();
	this.adjustLayout();

	// Run adjustLayout() a few times while images load, etc
	interval = setInterval( function () {
		focusWidget.adjustLayout();
		if ( i === 2 ) {
			clearInterval( interval );
		}
		i += 1;
	}, 1000 );
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

/**
 * Teardown focus widget
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.onDocumentTeardown = function () {
	this.showDistractions();
	this.$element.remove();
};

/**
 * Hide all of the elements that we want hidden
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.hideDistractions = function () {
	if ( mw.config.get( 'WikiaBar' ) ) {
		mw.config.get( 'WikiaBar' ).hide();
	}
	// Visibility property - problem with edit button opening when setting display property
	//this.$pageHeaderElements.css( 'visibility', 'hidden' );
	this.$pageHeaderElements.hide();
	this.$wikiaAds
		.each( function () {
			var $ad = $( this );
			$ad.css( {
				height: $ad.height(),
				width: $ad.width()
			} );
		} )
		.addClass( 've-hidden-ad' );
};

/**
 * Show all of the previously hidden elements
 *
 * @method
 */
ve.ui.WikiaFocusWidget.prototype.showDistractions = function () {
	if ( this.showWikiaBar ) {
		mw.config.get( 'WikiaBar' ).show();
	}
	//this.$pageHeaderElements.css( 'visibility', 'visible' );
	this.$pageHeaderElements.show();
	this.$wikiaAds
		.css( {
			height: 'auto',
			width: 'auto'
		} )
		.removeClass( 've-hidden-ad' );
};
