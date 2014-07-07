/*!
 * VisualEditor Initialization Target class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * @param {jQuery} $container Conainter to render target into, must be attached to the DOM
 * @throws {Error} Container must be attached to the DOM
 */
ve.init.Target = function VeInitTarget( $container ) {
	// Mixin constructors
	OO.EventEmitter.call( this );

	if ( !$.contains( $container[0].ownerDocument, $container[0] ) ) {
		throw new Error( 'Container must be attached to the DOM' );
	}

	// Properties
	this.$element = $container;

	/**
	 * @property {ve.ui.Surface}
	 */
	this.surface = null;

	/**
	 * The ve-ce-documentNode of #surface
	 * @property {jQuery}
	 */
	this.$document = null;

	/**
	 * @property {ve.ui.TargetToolbar}
	 */
	this.toolbar = null;
};

/**
 * Destroy the target
 */
ve.init.Target.prototype.destroy = function () {
	this.$document = null;
	if ( this.surface ) {
		this.surface.destroy();
	}
	if ( this.toolbar ) {
		this.toolbar.destroy();
	}
	if ( this.$element ) {
		this.$element.remove();
	}
};

/* Events */

/**
 * Fired when the #surface is ready.
 *
 * By default the surface document is not focused. If the target wants
 * the browsers' focus to be in the surface (ready for typing and cursoring)
 * call `this.$document[0].focus();` in a handler for this event.
 *
 * @event surfaceReady
 */

/* Inheritance */

OO.mixinClass( ve.init.Target, OO.EventEmitter );

/* Static Properties */

ve.init.Target.static.toolbarGroups = [
	// History
	{ 'include': [ 'undo', 'redo' ] },
	// Format
	{
		'type': 'menu',
		'indicator': 'down',
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted' ]
	},
	// Style
	{
		'type': 'list',
		'indicator': 'down',
		'icon': 'text-style',
		'include': [ { 'group': 'textStyle' }, 'clear' ],
		'promote': [ 'bold', 'italic' ],
		'demote': [ 'strikethrough', 'code',  'underline', 'clear' ]
	},
	// Link
	{ 'include': [ 'link' ] },
	// Structure
	{
		'type': 'bar',
		'include': [ 'number', 'bullet', 'outdent', 'indent' ]
	},
	// Insert
	{
		'include': '*',
		'indicator': 'down',
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		'demote': [ 'specialcharacter' ]
	}

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
	'commandHelp',
	'paragraph',
	'heading1',
	'heading2',
	'heading3',
	'heading4',
	'heading5',
	'heading6',
	'preformatted',
	'pasteSpecial'
];

/**
 * Surface paste rules
 *
 * One set for external (non-VE) paste sources and one for all paste sources.
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @type {Object}
 */
ve.init.Target.static.pasteRules = {
	'external': {
		'blacklist': [
			// Annotations
			// TODO: allow spans
			'textStyle/span',
			// Nodes
			'alienInline', 'alienBlock'
		]
	},
	'all': null
};
