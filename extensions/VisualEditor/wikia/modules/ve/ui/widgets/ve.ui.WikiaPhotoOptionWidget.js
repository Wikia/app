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
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaPhotoOptionWidget = function VeUiWikiaPhotoOptionWidget( config ) {
	var $dimensions;

	// Parent constructor
	ve.ui.WikiaPhotoOptionWidget.super.call( this, config );

	// Initialization
	$dimensions = this.$( '<div>' )
		.addClass( 've-ui-wikiaPhotoOptionWidget-dimensions' )
		.text( config.data.width + ' x ' + config.data.height );
	this.$previewIcon.addClass( 'oo-ui-icon-preview-photo' );

	// DOM changes
	this.$metaData.append( $dimensions );
	this.$previewText.text( ve.msg( 'wikia-visualeditor-wikiamediaoptionwidget-preview-photo' ) );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaPhotoOptionWidget, ve.ui.WikiaMediaOptionWidget );
