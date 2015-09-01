/*!
 * VisualEditor MWInternalLinkContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context item for a MWInternalLink.
 *
 * @class
 * @extends ve.ui.LinkContextItem
 *
 * @constructor
 * @param {ve.ui.Context} context Context item is in
 * @param {ve.dm.Model} model Model item is related to
 * @param {Object} config Configuration options
 */
ve.ui.MWInternalLinkContextItem = function VeUiMWInternalLinkContextItem() {
	// Parent constructor
	ve.ui.MWInternalLinkContextItem.super.apply( this, arguments );

	// Initialization
	this.$element.addClass( 've-ui-mwInternalLinkContextItem' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWInternalLinkContextItem, ve.ui.LinkContextItem );

/* Static Properties */

ve.ui.MWInternalLinkContextItem.static.name = 'link/internal';

ve.ui.MWInternalLinkContextItem.static.modelClasses = [ ve.dm.MWInternalLinkAnnotation ];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWInternalLinkContextItem.prototype.getDescription = function () {
	return this.model.getAttribute( 'normalizedTitle' );
};

/**
 * @inheritdoc
 */
ve.ui.MWInternalLinkContextItem.prototype.renderBody = function () {
	var icon, $description,
		usePageImages = mw.config.get( 'wgVisualEditor' ).usePageImages,
		usePageDescriptions = mw.config.get( 'wgVisualEditor' ).usePageDescriptions,
		title = this.model.getAttribute( 'lookupTitle' ),
		htmlDoc = this.context.getSurface().getModel().getDocument().getHtmlDocument(),
		$wrapper = $( '<div>' ),
		$link = $( '<a>' )
			.addClass( 've-ui-mwInternalLinkContextItem-link' )
			.text( this.getDescription() )
			.attr( {
				href: ve.resolveUrl( this.model.getHref(), htmlDoc ),
				target: '_blank'
			} );

	// Style based on link cache information
	ve.init.platform.linkCache.styleElement( title, $link );

	if ( usePageImages ) {
		icon = new OO.ui.IconWidget( { icon: 'page-existing' } );
		$wrapper
			.addClass( 've-ui-mwInternalLinkContextItem-withImage' )
			.append( icon.$element );
	}

	$wrapper.append( $link );

	if ( usePageDescriptions ) {
		$wrapper.addClass( 've-ui-mwInternalLinkContextItem-withDescription' );
	}

	this.$body.empty().append( $wrapper );

	if ( usePageImages || usePageDescriptions ) {
		ve.init.platform.linkCache.get( title ).then( function ( linkData ) {
			if ( usePageImages ) {
				if ( linkData.imageUrl ) {
					icon.$element
						.addClass( 've-ui-mwInternalLinkContextItem-hasImage' )
						.css( 'background-image', 'url(' + linkData.imageUrl + ')' );
				} else {
					icon.setIcon( ve.init.platform.linkCache.constructor.static.getIconForLink( linkData ) );
				}
			}
			if ( usePageDescriptions && linkData.description ) {
				$description = $( '<span>' )
					.addClass( 've-ui-mwInternalLinkContextItem-description' )
					.text( linkData.description );
				$wrapper.append( $description );
			}
		} );
	}
};

/* Registration */

ve.ui.contextItemFactory.register( ve.ui.MWInternalLinkContextItem );
