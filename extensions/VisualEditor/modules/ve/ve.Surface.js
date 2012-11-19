/**
 * VisualEditor Surface class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.Surface object.
 *
 * A surface is a top-level object which contains both a surface model and a surface view.
 *
 * @class
 * @constructor
 * @param {String} parent Selector of element to attach to
 * @param {HTMLElement} dom HTML element of document to edit
 * @param {Object} options Configuration options
 */
ve.Surface = function VeSurface( parent, dom, options ) {
	// Properties
	this.$ = $( '<div class="ve-surface"></div>' );
	this.documentModel = new ve.dm.Document( ve.dm.converter.getDataFromDom( dom ) );
	this.options = ve.extendObject( true, ve.Surface.defaultOptions, options );
	this.model = new ve.dm.Surface( this.documentModel );
	this.view = new ve.ce.Surface( this.$, this.model, this );
	this.context = new ve.ui.Context( this );
	this.toolbars = {};
	this.commands = {};

	// DOM Changes
	$( parent ).append( this.$ );
	this.$.append(
		// Contain floating content
		$( '<div style="clear: both;"></div>' ),
		// Temporary paste buffer
		// TODO: make 'paste' in surface stateful and remove this attrib
		// TODO: Use a less generic id than "paste", or get rid of the ID alltogether
		$( '<div id="paste" class="paste" contenteditable="true"></div>' )
	);

	// Initialization
	// Propagate to each node information that it is live (attached to the live DOM)
	this.view.getDocument().getDocumentNode().setLive( true ); 
	this.setupToolbars();
	this.setupCommands();
	ve.instances.push( this );
	this.model.startHistoryTracking();

	// Turn off native object editing. This must be tried after the surface has been added to DOM.
	try {
		document.execCommand( 'enableObjectResizing', false, false );
		document.execCommand( 'enableInlineTableEditing', false, false );
	} catch ( e ) { /* Silently ignore */ }
};

/* Static Members */

ve.Surface.defaultOptions = {
	'toolbars': {
		'top': {
			'float': true,
			'tools': [
				{ 'name': 'history', 'items' : ['undo', 'redo'] },
				{ 'name': 'textStyle', 'items' : ['format'] },
				{ 'name': 'textStyle', 'items' : ['bold', 'italic', 'link', 'clear'] },
				{ 'name': 'list', 'items' : ['number', 'bullet', 'outdent', 'indent'] }
			]
		}
	},
	// Items can either be symbolic names or objects with trigger and action properties
	'commands': ['bold', 'italic', 'link', 'undo', 'redo', 'indent', 'unindent']
};

/* Methods */

/**
 * Gets a reference to the surface model.
 *
 * @method
 * @returns {ve.dm.Surface} Surface model
 */
ve.Surface.prototype.getModel = function () {
	return this.model;
};

/**
 * Gets a reference to the document model.
 *
 * @method
 * @returns {ve.dm.Document} Document model
 */
ve.Surface.prototype.getDocumentModel = function () {
	return this.documentModel;
};

/**
 * Gets a reference to the surface view.
 *
 * @method
 * @returns {ve.ce.Surface} Surface view
 */
ve.Surface.prototype.getView = function () {
	return this.view;
};

/**
 * Gets a reference to the context user interface.
 *
 * @method
 * @returns {ve.ui.Context} Context user interface
 */
ve.Surface.prototype.getContext = function () {
	return this.context;
};

/**
 * Executes an action or command.
 *
 * @method
 * @param {String|Command} action Name of action or command object
 * @param {String} [method] Name of method
 * @param {Mixed} [...] Additional arguments for action
 * @returns {Boolean} Action or command was executed
 */
ve.Surface.prototype.execute = function ( action, method ) {
	var trigger, obj, ret;
	if ( action instanceof ve.Command ) {
		trigger = action.toString();
		if ( trigger in this.commands ) {
			return this.execute.apply( this, this.commands[trigger] );
		}
	} else if ( typeof action === 'string' && typeof method === 'string' ) {
		// Validate method
		if ( ve.actionFactory.doesActionSupportMethod( action, method ) ) {
			// Create an action object and execute the method on it
			obj = ve.actionFactory.create( action, this );
			ret = obj[method].apply( obj, Array.prototype.slice.call( arguments, 2 ) );
			return ret === undefined || !!ret;
		}
	}
	return false;
};

/**
 * Adds all commands from initialization options.
 *
 * Commands must be registered through {ve.commandRegsitry} prior to constructing the surface.
 *
 * @method
 * @param {String[]} commands Array of symbolic names of registered commands
 */
ve.Surface.prototype.setupCommands = function () {
	var i, iLen, j, jLen, triggers, trigger, command,
		commands = this.options.commands;
	for ( i = 0, iLen = commands.length; i < iLen; i++ ) {
		command = ve.commandRegistry.lookup( commands[i] );
		if ( !command ) {
			throw new Error( 'No command registered by that name: ' + commands[i] );
		}
		triggers = command.trigger;
		if ( !ve.isArray( triggers ) ) {
			triggers = [triggers];
		}
		for ( j = 0, jLen = triggers.length; j < jLen; j++ ) {
			// Normalize
			trigger = ( new ve.Command( triggers[j] ) ).toString();
			// Validate
			if ( trigger.length === 0 ) {
				throw new Error( 'Incomplete command: ' + triggers[j] );
			}
			this.commands[trigger] = command.action;
		}
	}
};

/**
 * Initializes the toolbar.
 *
 * This method uses {this.options} for it's configuration.
 *
 * @method
 */
ve.Surface.prototype.setupToolbars = function () {
	var name, config, toolbar,
		toolbars = this.options.toolbars;
	for ( name in toolbars ) {
		config = toolbars[name];
		if ( ve.isPlainObject( config ) ) {
			this.toolbars[name] = toolbar = { '$': $( '<div class="ve-ui-toolbar"></div>' ) };
			if ( name === 'top' ) {
				// Add extra sections to the toolbar
				toolbar.$.append(
					'<div class="ve-ui-actions"></div>' +
					'<div style="clear:both"></div>' +
					'<div class="ve-ui-toolbar-shadow"></div>'
				);
				// Wrap toolbar for floating
				toolbar.$wrapper = $( '<div class="ve-ui-toolbar-wrapper"></div>' )
					.append( this.toolbars[name].$ );
				// Add toolbar to surface
				this.$.before( toolbar.$wrapper );
				if ( 'float' in config && config.float === true ) {
					// Float top toolbar
					this.floatTopToolbar();
				}
			}
			toolbar.instance = new ve.ui.Toolbar( toolbar.$, this, config.tools );
		}
	}
};

/*
 * Overlays the toolbar to the top of the screen when it would normally be out of view.
 *
 * TODO: Determine if this would be better in ui.toolbar vs here.
 * TODO: This needs to be refactored so that it only works on the main editor top tool bar.
 *
 * @method
 */
ve.Surface.prototype.floatTopToolbar = function () {
	if ( !this.toolbars.top ) {
		return;
	}
	var $wrapper = this.toolbars.top.$wrapper,
		$toolbar = this.toolbars.top.$,
		$window = $( window );

	$window.on( {
		'resize': function () {
			if ( $wrapper.hasClass( 've-ui-toolbar-wrapper-floating' ) ) {
				var toolbarsOffset = $wrapper.offset(),
					left = toolbarsOffset.left,
					right = $window.width() - $wrapper.outerWidth() - left;
				$toolbar.css( {
					'left': left,
					'right': right
				} );
			}
		},
		'scroll': function () {
			var left, right,
				toolbarsOffset = $wrapper.offset(),
				$editorDocument = $wrapper.parent().find('.ve-surface .ve-ce-documentNode'),
				$lastBranch = $editorDocument.children( '.ve-ce-branchNode:last' );

			if ( $window.scrollTop() > toolbarsOffset.top ) {
				left = toolbarsOffset.left;
				right = $window.width() - $wrapper.outerWidth() - left;
				// If not floating, set float
				if ( !$wrapper.hasClass( 've-ui-toolbar-wrapper-floating' ) ) {
					$wrapper
						.css( 'height', $wrapper.height() )
						.addClass( 've-ui-toolbar-wrapper-floating' );
					$toolbar.css( {
						'left': left,
						'right': right
					} );
				} else {
					// Toolbar is floated
					if (
						// There's at least one branch
						$lastBranch.length &&
						// Toolbar is at or below the top of last node in the document
						$window.scrollTop() + $toolbar.height() >= $lastBranch.offset().top
					) {
						if ( !$wrapper.hasClass( 've-ui-toolbar-wrapper-bottom' ) ) {
							$wrapper
								.removeClass( 've-ui-toolbar-wrapper-floating' )
								.addClass( 've-ui-toolbar-wrapper-bottom' );
							$toolbar.css({
								'top': $window.scrollTop() + 'px',
								'left': left,
								'right': right
							});
						}
					} else { // Unattach toolbar
						if ( $wrapper.hasClass( 've-ui-toolbar-wrapper-bottom' ) ) {
							$wrapper
								.removeClass( 've-ui-toolbar-wrapper-bottom' )
								.addClass( 've-ui-toolbar-wrapper-floating' );
							$toolbar.css( {
								'top': 0,
								'left': left,
								'right': right
							} );
						}
					}
				}
			} else { // Return toolbar to top position
				if (
					$wrapper.hasClass( 've-ui-toolbar-wrapper-floating' ) ||
					$wrapper.hasClass( 've-ui-toolbar-wrapper-bottom' )
				) {
					$wrapper.css( 'height', 'auto' )
						.removeClass( 've-ui-toolbar-wrapper-floating' )
						.removeClass( 've-ui-toolbar-wrapper-bottom' );
					$toolbar.css( {
						'top': 0,
						'left': 0,
						'right': 0
					} );
				}
			}
		}
	} );
};
