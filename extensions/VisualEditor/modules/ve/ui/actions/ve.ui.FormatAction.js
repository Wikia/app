/*!
 * VisualEditor UserInterface FormatAction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Format action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.FormatAction = function VeUiFormatAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.ui.FormatAction, ve.ui.Action );

/* Static Properties */

ve.ui.FormatAction.static.name = 'format';

/**
 * List of allowed methods for this action.
 *
 * @static
 * @property
 */
ve.ui.FormatAction.static.methods = [ 'convert' ];

/* Methods */

/**
 * Convert the format of content.
 *
 * Conversion splits and unwraps all lists and replaces content branch nodes.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @param {string} type
 * @param {Object} attributes
 */
ve.ui.FormatAction.prototype.convert = function ( type, attributes ) {
	var selected, i, length, contentBranch, txs,
		surfaceModel = this.surface.getModel(),
		selection = surfaceModel.getSelection(),
		fragmentForSelection = surfaceModel.getFragment( selection, true ),
		doc = surfaceModel.getDocument(),
		fragments = [];

	// We can't have headings or pre's in a list, so if we're trying to convert
	// things that are in lists to a heading or a pre, split the list
	selected = doc.selectNodes( selection, 'leaves' );
	for ( i = 0, length = selected.length; i < length; i++ ) {
		contentBranch = selected[i].node.isContent() ?
			selected[i].node.getParent() :
			selected[i].node;

		fragments.push( surfaceModel.getFragment( contentBranch.getOuterRange(), true ) );
	}

	for ( i = 0, length = fragments.length; i < length; i++ ) {
		fragments[i].isolateAndUnwrap( type );
	}
	selection = fragmentForSelection.getRange();

	txs = ve.dm.Transaction.newFromContentBranchConversion( doc, selection, type, attributes );
	surfaceModel.change( txs, selection );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.FormatAction );
