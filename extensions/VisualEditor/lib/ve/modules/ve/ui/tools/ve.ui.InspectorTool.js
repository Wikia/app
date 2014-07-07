/*!
 * VisualEditor UserInterface InspectorTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface inspector tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.InspectorTool = function VeUiInspectorTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.InspectorTool, ve.ui.Tool );

/* Static Properties */

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #isCompatibleWith.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.InspectorTool.static.modelClasses = [];

ve.ui.InspectorTool.static.requiresRange = true;

ve.ui.InspectorTool.static.deactivateOnSelect = false;

/**
 * @inheritdoc
 */
ve.ui.InspectorTool.static.isCompatibleWith = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.InspectorTool.prototype.onSelect = function () {
	ve.track( 'tool.inspector.select', {
		name: this.constructor.static.name,
		// HACK: which toolbar is this coming from?
		// TODO: this should probably be passed into the config or something
		toolbar: ( this.toolbar.constructor === ve.ui.Toolbar ? 'surface' : 'target' )
	} );
	ve.ui.Tool.prototype.onSelect.apply( this, arguments );
};

/**
 * @inheritdoc
 */
ve.ui.InspectorTool.prototype.onUpdateState = function ( fragment ) {
	var i, len, models,
		active = false;

	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

	models = fragment.getSelectedModels();
	for ( i = 0, len = models.length; i < len; i++ ) {
		if ( this.constructor.static.isCompatibleWith( models[i] ) ) {
			active = true;
			break;
		}
	}
	this.setActive( active );
};

/**
 * UserInterface link tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkInspectorTool = function VeUiLinkInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.LinkInspectorTool, ve.ui.InspectorTool );
ve.ui.LinkInspectorTool.static.name = 'link';
ve.ui.LinkInspectorTool.static.group = 'meta';
ve.ui.LinkInspectorTool.static.icon = 'link';
ve.ui.LinkInspectorTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-link-tooltip' );
ve.ui.LinkInspectorTool.static.modelClasses = [ ve.dm.LinkAnnotation ];
ve.ui.LinkInspectorTool.static.commandName = 'link';
ve.ui.toolFactory.register( ve.ui.LinkInspectorTool );

/**
 * Insert characters tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.InsertCharacterInspectorTool = function VeUiInsertCharacterInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.InsertCharacterInspectorTool, ve.ui.InspectorTool );
ve.ui.InsertCharacterInspectorTool.static.name = 'specialcharacter';
ve.ui.InsertCharacterInspectorTool.static.group = 'insert';
ve.ui.InsertCharacterInspectorTool.static.icon = 'special-character';
ve.ui.InsertCharacterInspectorTool.static.title =
	OO.ui.deferMsg( 'visualeditor-specialcharacter-button-tooltip' );
ve.ui.InsertCharacterInspectorTool.static.commandName = 'specialcharacter';
ve.ui.InsertCharacterInspectorTool.static.deactivateOnSelect = true;
ve.ui.toolFactory.register( ve.ui.InsertCharacterInspectorTool );
