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
			'structure/bullet',
			'structure/outdent',
			'structure/indent'
		]
	},
	{ 'include': [ 'object' ] }
];

ve.init.Target.static.surfaceCommands = [
	'history/undo',
	'history/redo',
	'textStyle/bold',
	'textStyle/italic',
	'meta/link',
	'utility/clear',
	'structure/indent',
	'structure/outdent'
];
