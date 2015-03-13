/*!
 * VisualEditor UserInterface MWInternalLinkMenuOptionWidget class
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates a ve.ui.MWInternalLinkMenuOptionWidget object.
 *
 * @class
 * @extends ve.ui.MWLinkMenuOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [pagename] Pagename to return the names of internal pages
 */
ve.ui.MWInternalLinkMenuOptionWidget = function VeUiMWInternalLinkMenuOptionWidget( config ) {
	// Config initialization
	config = config || {};

	// Properties
	this.pagename = config.pagename;

	// Parent constructor
	ve.ui.MWLinkMenuOptionWidget.call( this, $.extend( { label: this.pagename, href: mw.util.getUrl( this.pagename ) }, config ) );

	// Style based on link cache information
	ve.init.platform.linkCache.styleElement( this.pagename, this.$link );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWInternalLinkMenuOptionWidget, ve.ui.MWLinkMenuOptionWidget );
