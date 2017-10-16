/*!
 * VisualEditor UserInterface MediaWiki MobileSurface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * @class
 * @extends ve.ui.MobileSurface
 *
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData|ve.dm.Document} dataOrDoc Document data to edit
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMobileSurface = function VeUiMWMobileSurface() {
	// Parent constructor
	ve.ui.MWMobileSurface.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMobileSurface, ve.ui.MobileSurface );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMobileSurface.prototype.createContext = function () {
	return new ve.ui.MWMobileContext( this, { $: this.$ } );
};
