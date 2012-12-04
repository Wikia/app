/**
 * VisualEditor FormatAction class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Format action.
 *
 * @class
 * @constructor
 * @extends {ve.Action}
 * @param {ve.Surface} surface Surface to act on
 */
ve.FormatAction = function VeFormatAction( surface ) {
	// Parent constructor
	ve.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.FormatAction, ve.Action );

/* Static Members */

/**
 * List of allowed methods for this action.
 *
 * @static
 * @member
 */
ve.FormatAction.static.methods = ['convert'];

/* Methods */

/**
 * Converts content to a given format.
 *
 * Conversion splits and unwraps all lists and replaces content branch nodes.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @param {String} type
 * @param {Object} attributes
 */
ve.FormatAction.prototype.convert = function ( type, attributes ) {
	var selected, prevList, firstInList, lastInList, i, contentBranch, listItem, txs,
		surfaceView = this.surface.getView(),
		surfaceModel = this.surface.getModel(),
		selection = surfaceModel.getSelection(),
		doc = surfaceModel.getDocument();
	if ( type !== 'paragraph' ) {
		// We can't have headings or pre's in a list, so if we're trying to convert
		// things that are in lists to a heading or a pre, split the list
		selected = doc.selectNodes( selection, 'leaves' );
		for ( i = 0; i < selected.length; i++ ) {
			contentBranch = selected[i].node.isContent() ?
				selected[i].node.getParent() :
				selected[i].node;
			// Check if it's in a list
			listItem = contentBranch;
			// TODO: Add getMatchingAncestor to ve.dm.Node and use it here
			while ( listItem && listItem.getType() !== 'listItem' ) {
				listItem = listItem.getParent();
			}
			if ( !listItem || listItem.getParent() !== prevList ) {
				// Not in a list or in a different list
				if ( prevList ) {
					// Split and unwrap prevList
					selection = ve.FormatAction.splitAndUnwrap(
						surfaceModel, prevList, firstInList, lastInList, selection
					);
					// Reset
					prevList = firstInList = lastInList = undefined;
				}
				if ( listItem ) {
					prevList = listItem.getParent();
					firstInList = listItem;
					lastInList = firstInList;
				}
			} else {
				// This node is in the current list
				lastInList = listItem;
			}
		}
		if ( prevList ) {
			// Split and unwrap prevList
			selection = ve.FormatAction.splitAndUnwrap(
				surfaceModel, prevList, firstInList, lastInList, selection
			);
		}
	}
	txs = ve.dm.Transaction.newFromContentBranchConversion( doc, selection, type, attributes );
	surfaceModel.change( txs, selection );
	surfaceView.showSelection( selection );
};

/**
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 */
ve.FormatAction.splitAndUnwrap = function ( model, list, firstItem, lastItem, selection ) {
	var doc = model.getDocument(),
		start = firstItem.getOuterRange().start,
		end = lastItem.getOuterRange().end,
		tx;
	// First split the list before, if needed
	if ( list.indexOf( firstItem ) > 0 ) {
		tx = ve.dm.Transaction.newFromInsertion(
			doc, start, [{ 'type': '/list' }, list.getClonedElement()]
		);
		start += 2;
		end += 2;
		selection = tx.translateRange( selection );
		model.change( tx, selection );
	}
	// Split the list after, if needed
	if ( list.indexOf( lastItem ) < list.getChildren().length - 1 ) {
		tx = ve.dm.Transaction.newFromInsertion(
			doc, end, [{ 'type': '/list' }, list.getClonedElement()]
		);
		selection = tx.translateRange( selection );
		model.change( tx, selection );
	}
	// Unwrap the list
	tx = ve.dm.Transaction.newFromWrap( doc, new ve.Range( start, end ),
		[{ 'type': 'list' }], [], [{ 'type': 'listItem' }], []
	);
	selection = tx.translateRange( selection );
	model.change( tx, selection );
	return selection;
};

/* Registration */

ve.actionFactory.register( 'format', ve.FormatAction );
