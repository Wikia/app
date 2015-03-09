/*!
 * VisualEditor UserInterface MWGalleryInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for editing MediaWiki galleries.
 *
 * @class
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWGalleryInspector = function VeUiMWGalleryInspector( config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, config );

	this.$element.addClass( 've-ui-mwGalleryInspector' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWGalleryInspector, ve.ui.MWExtensionInspector );

/* Static properties */

ve.ui.MWGalleryInspector.static.name = 'gallery';

ve.ui.MWGalleryInspector.static.icon = 'gallery';

ve.ui.MWGalleryInspector.static.size = 'large';

ve.ui.MWGalleryInspector.static.title =
	OO.ui.deferMsg( 'visualeditor-mwgalleryinspector-title' );

ve.ui.MWGalleryInspector.static.nodeModel = ve.dm.MWGalleryNode;

/* Methods */

/** */
ve.ui.MWGalleryInspector.prototype.getInputPlaceholder = function () {
	// 'File:' is always in content language
	return mw.config.get( 'wgFormattedNamespaces' )['6'] + ':' +
		ve.msg( 'visualeditor-mwgalleryinspector-placeholder' );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWGalleryInspector );
