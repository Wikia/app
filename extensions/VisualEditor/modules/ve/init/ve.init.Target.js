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
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {jQuery} $container Conainter to render target into
 */
ve.init.Target = function VeInitTarget( $container ) {
	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.$ = $container;
};

/* Inheritance */

ve.mixinClass( ve.init.Target, ve.EventEmitter );

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
