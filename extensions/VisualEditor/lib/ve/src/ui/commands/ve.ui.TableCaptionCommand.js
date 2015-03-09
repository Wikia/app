/*!
 * VisualEditor UserInterface TableCaptionCommand class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface table caption command.
 *
 * @class
 * @extends ve.ui.Command
 *
 * @constructor
 */
ve.ui.TableCaptionCommand = function VeUiTableCaptionCommand() {
	// Parent constructor
	ve.ui.TableCaptionCommand.super.call(
		this, 'tableCaption', 'table', 'caption',
		{ supportedSelections: ['linear', 'table'] }
	);
};

/* Inheritance */

OO.inheritClass( ve.ui.TableCaptionCommand, ve.ui.Command );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.TableCaptionCommand.prototype.isExecutable = function ( fragment ) {
	// Parent method
	if ( !ve.ui.TableCaptionCommand.super.prototype.isExecutable.apply( this, arguments ) ) {
		return false;
	}

	var i, len, nodes, hasCaptionNode,
		selection = fragment.getSelection();

	if ( selection instanceof ve.dm.TableSelection ) {
		return true;
	} else {
		nodes = fragment.getSelectedLeafNodes();
		hasCaptionNode = !!nodes.length;

		for ( i = 0, len = nodes.length; i < len; i++ ) {
			if ( !nodes[i].hasMatchingAncestor( 'tableCaption' ) ) {
				hasCaptionNode = false;
				break;
			}
		}
		return hasCaptionNode;
	}
};

/* Registration */

ve.ui.commandRegistry.register( new ve.ui.TableCaptionCommand() );
