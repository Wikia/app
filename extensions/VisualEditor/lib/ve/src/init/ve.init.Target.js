/*!
 * VisualEditor Initialization Target class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Generic Initialization target.
 *
 * @class
 * @abstract
 * @extends OO.ui.Element
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {Object} toolbarConfig Configuration options for the toolbar
 */
ve.init.Target = function VeInitTarget( toolbarConfig ) {
	// Parent constructor
	OO.ui.Element.call( this );

	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.surfaces = [];
	this.surface = null;
	this.toolbar = null;
	this.toolbarConfig = toolbarConfig;
	this.documentTriggerListener = new ve.TriggerListener( this.constructor.static.documentCommands );
	this.targetTriggerListener = new ve.TriggerListener( this.constructor.static.targetCommands );

	// Initialization
	this.$element.addClass( 've-init-target' );

	if ( ve.init.platform.constructor.static.isInternetExplorer() ) {
		this.$element.addClass( 've-init-target-ie' );
	}

	// Events
	this.onDocumentKeyDownHandler = this.onDocumentKeyDown.bind( this );
	this.onTargetKeyDownHandler = this.onTargetKeyDown.bind( this );
	this.bindHandlers();

	// Register
	ve.init.target = this;
};

/* Inheritance */

OO.inheritClass( ve.init.Target, OO.ui.Element );

OO.mixinClass( ve.init.Target, OO.EventEmitter );

/* Static Properties */

ve.init.Target.static.toolbarGroups = [
	// History
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-history' ),
		include: [ 'undo', 'redo' ]
	},
	// Format
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-paragraph-format' ),
		type: 'menu',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		include: [ { group: 'format' } ],
		promote: [ 'paragraph' ],
		demote: [ 'preformatted', 'blockquote' ]
	},
	// Basic style
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-text-style' ),
		title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		include: [ 'bold', 'italic' ]
	},
	// Style
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-text-style' ),
		type: 'list',
		indicator: 'down',
		icon: 'text-style',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		include: [ { group: 'textStyle' }, 'language', 'clear' ],
		demote: [ 'strikethrough', 'code', 'underline', 'language', 'clear' ]
	},
	// Link
	{
		header: OO.ui.deferMsg( 'visualeditor-linkinspector-title' ),
		include: [ 'link' ]
	},
	// Structure
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-structure' ),
		type: 'list',
		icon: 'bullet-list',
		indicator: 'down',
		include: [ { group: 'structure' } ],
		demote: [ 'outdent', 'indent' ]
	},
	// Insert
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		type: 'list',
		icon: 'insert',
		label: '',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		indicator: 'down',
		include: '*',
		demote: [ 'specialcharacter' ]
	},
	// Table
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-table' ),
		type: 'list',
		icon: 'table-insert',
		indicator: 'down',
		include: [ { group: 'table' } ],
		demote: [ 'deleteTable' ]
	}
];

/**
 * List of commands which can be triggered anywhere from within the document
 *
 * @type {string[]} List of command names
 */
ve.init.Target.static.documentCommands = ['commandHelp'];

/**
 * List of commands which can be triggered from within the target element
 *
 * @type {string[]} List of command names
 */
ve.init.Target.static.targetCommands = ['findAndReplace'];

/**
 * List of commands to exclude from the target entirely
 *
 * @type {string[]} List of command names
 */
ve.init.Target.static.excludeCommands = [];

/**
 * Surface import rules
 *
 * One set for external (non-VE) paste sources and one for all paste sources.
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @type {Object}
 */
ve.init.Target.static.importRules = {
	external: {
		blacklist: [
			// Annotations
			// TODO: allow spans
			'textStyle/span',
			// Nodes
			'alienInline', 'alienBlock', 'comment'
		]
	},
	all: null
};

/* Methods */

/**
 * Bind event handlers to target and document
 */
ve.init.Target.prototype.bindHandlers = function () {
	$( this.getElementDocument() ).on( 'keydown', this.onDocumentKeyDownHandler );
	this.$element.on( 'keydown', this.onTargetKeyDownHandler );
};

/**
 * Unbind event handlers on target and document
 */
ve.init.Target.prototype.unbindHandlers = function () {
	$( this.getElementDocument() ).off( 'keydown', this.onDocumentKeyDownHandler );
	this.$element.off( 'keydown', this.onTargetKeyDownHandler );
};

/**
 * Destroy the target
 */
ve.init.Target.prototype.destroy = function () {
	this.clearSurfaces();
	if ( this.toolbar ) {
		this.toolbar.destroy();
		this.toolbar = null;
	}
	if ( this.$element ) {
		this.$element.remove();
		this.$element = null;
	}
	this.unbindHandlers();
	ve.init.target = null;
};

/**
 * Handle key down events on the document
 *
 * @param {jQuery.Event} e Key down event
 */
ve.init.Target.prototype.onDocumentKeyDown = function ( e ) {
	var command, trigger = new ve.ui.Trigger( e );
	if ( trigger.isComplete() ) {
		command = this.documentTriggerListener.getCommandByTrigger( trigger.toString() );
		if ( command && command.execute( this.getSurface() ) ) {
			e.preventDefault();
		}
	}
};

/**
 * Handle key down events on the target
 *
 * @param {jQuery.Event} e Key down event
 */
ve.init.Target.prototype.onTargetKeyDown = function ( e ) {
	var command, trigger = new ve.ui.Trigger( e );
	if ( trigger.isComplete() ) {
		command = this.targetTriggerListener.getCommandByTrigger( trigger.toString() );
		if ( command && command.execute( this.getSurface() ) ) {
			e.preventDefault();
		}
	}
};

/**
 * Create a surface.
 *
 * @method
 * @param {ve.dm.Document} dmDoc Document model
 * @param {Object} [config] Configuration options
 * @returns {ve.ui.Surface}
 */
ve.init.Target.prototype.createSurface = function ( dmDoc, config ) {
	config = ve.extendObject( {
		excludeCommands: OO.simpleArrayUnion(
			this.constructor.static.excludeCommands,
			this.constructor.static.documentCommands,
			this.constructor.static.targetCommands
		),
		importRules: this.constructor.static.importRules
	}, config );
	return new ve.ui.DesktopSurface( dmDoc, config, this );
};

/**
 * Add a surface to the target
 *
 * @param {ve.dm.Document} dmDoc Document model
 * @param {Object} [config] Configuration options
 * @returns {ve.ui.Surface}
 */
ve.init.Target.prototype.addSurface = function ( dmDoc, config ) {
	var surface = this.createSurface( dmDoc, config );
	this.surfaces.push( surface );
	surface.getView().connect( this, { focus: this.onSurfaceViewFocus.bind( this, surface ) } );
	return surface;
};

/**
 * Destroy and remove all surfaces from the target
 */
ve.init.Target.prototype.clearSurfaces = function () {
	while ( this.surfaces.length ) {
		this.surfaces.pop().destroy();
	}
};

/**
 * Handle focus events from a surface's view
 *
 * @param {ve.ui.Surface} surface Surface firing the event
 */
ve.init.Target.prototype.onSurfaceViewFocus = function ( surface ) {
	this.setSurface( surface );
};

/**
 * Set the target's active surface
 *
 * @param {ve.ui.Surface} surface Surface
 */
ve.init.Target.prototype.setSurface = function ( surface ) {
	if ( surface !== this.surface ) {
		this.surface = surface;
		this.setupToolbar( surface );
	}
};

/**
 * Get the target's active surface
 *
 * @return {ve.ui.Surface} Surface
 */
ve.init.Target.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get the target's toolbar
 *
 * @return {ve.ui.TargetToolbar} Toolbar
 */
ve.init.Target.prototype.getToolbar = function () {
	if ( !this.toolbar ) {
		this.toolbar = new ve.ui.TargetToolbar( this, this.toolbarConfig );
	}
	return this.toolbar;
};

/**
 * Set up the toolbar, attaching it to a surface.
 *
 * @param {ve.ui.Surface} surface Surface
 */
ve.init.Target.prototype.setupToolbar = function ( surface ) {
	this.getToolbar().setup( this.constructor.static.toolbarGroups, surface );
	this.getToolbar().$element.insertBefore( surface.$element );
	this.getToolbar().$bar.append( surface.toolbarDialogs.$element );
};
