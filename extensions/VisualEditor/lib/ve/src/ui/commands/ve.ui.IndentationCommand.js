/*!
 * VisualEditor UserInterface IndentationCommand class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface indentation command.
 *
 * @class
 * @extends ve.ui.Command
 *
 * @constructor
 * @param {string} name
 * @param {string} method
 */
ve.ui.IndentationCommand = function VeUiIndentationCommand( name, method ) {
	// Parent constructor
	ve.ui.IndentationCommand.super.call(
		this, name, 'indentation', method,
		{ supportedSelections: ['linear'] }
	);
};

/* Inheritance */

OO.inheritClass( ve.ui.IndentationCommand, ve.ui.Command );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.IndentationCommand.prototype.isExecutable = function ( fragment ) {
	// Parent method
	if ( !ve.ui.IndentationCommand.super.prototype.isExecutable.apply( this, arguments ) ) {
		return false;
	}
	var i, len,
		nodes = fragment.getSelectedLeafNodes(),
		any = false;
	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( nodes[i].hasMatchingAncestor( 'listItem' ) ) {
			any = true;
			break;
		}
	}
	return any;
};

/* Registration */

ve.ui.commandRegistry.register( new ve.ui.IndentationCommand( 'indent', 'increase' ) );

ve.ui.commandRegistry.register( new ve.ui.IndentationCommand( 'outdent', 'decrease' ) );
