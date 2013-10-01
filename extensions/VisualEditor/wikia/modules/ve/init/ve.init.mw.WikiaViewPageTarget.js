/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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
	{
		'include': '*',
		'exclude': [ 'wikiaMediaInsert', 'mediaInsert' ]
	}
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

ve.init.mw.WikiaViewPageTarget.prototype.setupSkinTabs = function () {
	// Intentionally left empty
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
