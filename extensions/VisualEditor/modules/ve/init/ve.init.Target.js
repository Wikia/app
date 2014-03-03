/*!
 * VisualEditor Initialization Target class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic Initialization target.
 *
 * @class
 * @abstract
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {jQuery} $container Conainter to render target into
 */
ve.init.Target = function VeInitTarget( $container ) {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.$element = $container;
};

/* Inheritance */

OO.mixinClass( ve.init.Target, OO.EventEmitter );

/* Static Properties */

ve.init.Target.static.toolbarGroups = [

	{ 'include': [ 'undo', 'redo' ] },
	{
		'type': 'menu',
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted', 'heading1' ]
	},
	{ 'include': [ 'bold', 'italic', 'link', 'clear' ] },
	{ 'include': [ 'number', 'bullet', 'outdent', 'indent' ] },
	{ 'include': '*' }
];

ve.init.Target.static.surfaceCommands = [
	'undo',
	'redo',
	'bold',
	'italic',
	'link',
	'clear',
	'underline',
	'subscript',
	'superscript',
	'indent',
	'outdent',
	'paragraph',
	'heading1',
	'heading2',
	'heading3',
	'heading4',
	'heading5',
	'heading6',
	'preformatted'
];
