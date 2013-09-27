/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw */
/* global Wikia */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.ViewPageTarget
 *
 * @constructor
 */
ve.init.mw.WikiaViewPageTarget = function VeInitMwWikiaViewPageTarget() {
	// Parent constructor
	ve.init.mw.ViewPageTarget.call( this );
};

/* Inheritance */

ve.inheritClass( ve.init.mw.WikiaViewPageTarget, ve.init.mw.ViewPageTarget );

/* Static Properties */
ve.init.mw.WikiaViewPageTarget.static.toolbarGroups = [
	{ 'include': [ 'undo', 'redo' ] },
	{
		'type': 'menu',
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted', 'heading1' ]
	},
	{ 'include': [ 'bold', 'italic', 'link', 'clear' ] },
	{ 'include': [ 'number', 'bullet' ] },
	{ 'include': mw.config.get('debug') ? [ 'wikiaMediaInsert' ] : [] },
	{ 'include': '*' }
	/*
	{
		'include': [ 'history' ],
		'promote': [
			'history/undo',
			'history/redo'
		]
	},
	{
		'include': [ 'format' ],
		'promote': [ 'format/convert' ]
	},
	{
		'include': [ 'textStyle', 'meta', 'utility/clear' ],
		'promote': [
			'textStyle/bold',
			'textStyle/italic',
			'meta/link'
		],
		'demote': [ 'utility/clear' ]
	},
	{
		'include': [ 'structure' ],
		'promote': [
			'structure/number',
			'structure/bullet'
		],
		'exclude': [
			'structure/indent',
			'structure/outdent'
		]
	},
	{
		'include': [ 'insertMedia' ]
	},
	{
		'include': [ 'object' ],
		'exclude': [ 'object/mediaInsert' ]
	}
	*/
];

ve.init.mw.WikiaViewPageTarget.prototype.activate = function () {
	ve.init.mw.ViewPageTarget.prototype.activate.call( this );

	this.setupTracking();

};

ve.init.mw.WikiaViewPageTarget.prototype.setupSkinTabs = function () {
	// Intentionally left empty
};

ve.init.mw.WikiaViewPageTarget.prototype.setupTracking = function () {
	var actions = Wikia.Tracker.ACTIONS;

	ve.trackRegisterHandler( function ( name, data ) {
		var params = {
			category: 'editor-ve',
			trackingMethod: 'ga'
		};

		// Handle MW tracking calls
		if ( typeof name === 'string' ) {
			switch( data.action ) {
				case 'edit-link-click':
					params.action = actions.CLICK;
					params.category = 'article';
					params.label = 've-edit';
					break;
				case 'page-edit-impression':
					params.action = actions.IMPRESSION;
					params.label = 'edit';
					break;
				case 'page-save-attempt':
					params.action = actions.CLICK;
					params.label = 'button-publish';
					break;
				case 'page-save-success':
					params.action = actions.SUCCESS;
					params.label = 'save';
					break;
				case 'section-edit-link-click':
					params.action = actions.CLICK;
					params.category = 'article';
					params.label = 've-section-edit';
					break;
				default:
					// Don't track
					return;
			}
		} else {
			ve.extendObject( params, name );
		}

		Wikia.Tracker.track( params );
	} );
};

ve.init.mw.WikiaViewPageTarget.prototype.mutePageContent = function () {
	$( '#mw-content-text, .WikiaArticleCategories' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
};

ve.init.mw.WikiaViewPageTarget.prototype.hidePageContent = function () {
	$( '#mw-content-text, .WikiaArticleCategories' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();
};

ve.init.mw.WikiaViewPageTarget.prototype.showPageContent = function () {
	$( '.ve-init-mw-viewPageTarget-content' )
		.removeClass( 've-init-mw-viewPageTarget-content' )
		.show()
		.fadeTo( 0, 1 );
};
