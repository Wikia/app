/*!
 * VisualEditor MediaWiki Initialization MobileViewTarget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw*/

/**
 *
 * @class
 * @extends ve.init.mw.Target
 *
 * @constructor
 * @param {jQuery} $container Container to render target into
 * @param {Object} [config] Configuration options
 * @cfg {number} [section] Number of the section target should scroll to
 */
ve.init.mw.MobileViewTarget = function VeInitMwMobileViewTarget( $container, config ) {
	var currentUri = new mw.Uri();
	config = config || {};

	// Parent constructor
	ve.init.mw.Target.call(
		this, $container, mw.config.get( 'wgRelevantPageName' ), currentUri.query.oldid
	);

	this.section = config.section;

	// Events
	this.connect( this, {
		'surfaceReady': 'onSurfaceReady'
	} );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.MobileViewTarget, ve.init.mw.Target );

/* Static Properties */
ve.init.mw.MobileViewTarget.static.toolbarGroups = [
	// Style
	{ 'include': [ 'bold', 'italic' ] },
	// Link
	{ 'include': [ 'link' ] },
	// Cite
	{
		'header': OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		'indicator': 'down',
		'type': 'list',
		'icon': 'reference',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		'include': [ { 'group': 'cite' }, 'reference/existing' ]
	}
];

ve.init.mw.MobileViewTarget.static.surfaceCommands = [
	'bold',
	'italic',
	'link'
];

ve.init.mw.MobileViewTarget.static.name = 'mobile';

/* Methods */

/**
 * Once surface is ready ready, init UI.
 */
ve.init.mw.MobileViewTarget.prototype.onSurfaceReady = function () {
	this.surface.getView().focus();
	this.restoreEditSection();
};

/**
 * Create a surface.
 *
 * @method
 * @param {ve.dm.Document} dmDoc Document model
 * @param {Object} [config] Configuration options
 * @returns {ve.ui.MobileSurface}
 */
ve.init.mw.MobileViewTarget.prototype.createSurface = function ( dmDoc, config ) {
	return new ve.ui.MobileSurface( dmDoc, config );
};

/**
 * @inheritdoc
 */
ve.init.mw.MobileViewTarget.prototype.setupToolbar = function () {
	// Parent method
	ve.init.mw.Target.prototype.setupToolbar.call( this );

	this.toolbar.$element
		// FIXME shouldn't be using viewPageTarget styles
		.addClass( 've-init-mw-viewPageTarget-toolbar' )
		// Move the toolbar to the overlay header
		.appendTo( '.overlay-header > .toolbar' );
};
