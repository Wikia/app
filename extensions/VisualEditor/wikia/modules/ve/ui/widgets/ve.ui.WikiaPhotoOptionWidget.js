/*!
 * VisualEditor UserInterface WikiaPhotoOptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @extends ve.ui.WikiaMediaOptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaPhotoOptionWidget = function VeUiWikiaPhotoOptionWidget( data, config ) {
	// Parent constructor
	ve.ui.WikiaPhotoOptionWidget.super.call( this, data, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaPhotoOptionWidget, ve.ui.WikiaMediaOptionWidget );
