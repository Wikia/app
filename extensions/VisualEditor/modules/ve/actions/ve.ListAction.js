/**
 * VisualEditor ListAction class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * List action.
 *
 * @class
 * @constructor
 * @extends {ve.Action}
 * @param {ve.Surface} surface Surface to act on
 */
ve.ListAction = function VeListAction( surface ) {
	// Parent constructor
	ve.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.ListAction, ve.Action );

/* Static Members */

/**
 * List of allowed methods for this action.
 *
 * @static
 * @member
 */
ve.ListAction.static.methods = ['wrap', 'unwrap'];

/* Methods */

/**
 * Wraps content in a list.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @param {String} style List style, e.g. 'number' or 'bullet'
 */
ve.ListAction.prototype.wrap = function ( style ) {
	var tx, i, previousList, groupRange, group,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		groups = documentModel.getCoveredSiblingGroups( selection );

	surfaceModel.breakpoint();
	for ( i = 0; i < groups.length; i++ ) {
		group = groups[i];
		if ( group.grandparent && group.grandparent.getType() === 'list' ) {
			if ( group.grandparent !== previousList ) {
				// Change the list style
				surfaceModel.change(
					ve.dm.Transaction.newFromAttributeChange(
						documentModel, group.grandparent.getOffset(), 'style', style
					),
					selection
				);
				// Skip this one next time
				previousList = group.grandparent;
			}
		} else {
			// Get a range that covers the whole group
			groupRange = new ve.Range(
				group.nodes[0].getOuterRange().start,
				group.nodes[group.nodes.length - 1].getOuterRange().end
			);
			// Convert everything to paragraphs first
			surfaceModel.change(
				ve.dm.Transaction.newFromContentBranchConversion(
					documentModel, groupRange, 'paragraph'
				),
				selection
			);
			// Wrap everything in a list and each content branch in a listItem
			tx = ve.dm.Transaction.newFromWrap(
				documentModel,
				groupRange,
				[],
				[{ 'type': 'list', 'attributes': { 'style': style } }],
				[],
				[{ 'type': 'listItem' }]
			);
			surfaceModel.change( tx, tx.translateRange( selection ) );
		}
	}
	surfaceModel.breakpoint();
};

/**
 * Removes list wrapping.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 */
ve.ListAction.prototype.unwrap = function () {
	var tx, i, j,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		unlistRangesObj = this.getUnlistRanges( selection ),
		unlistRangesArr = [];

	surfaceModel.breakpoint();
	for ( i in unlistRangesObj ) {
		unlistRangesArr.push( unlistRangesObj[i] );
	}
	for ( i = 0; i < unlistRangesArr.length; i++ ) {
		// Unwrap the range given by unlistRanges[i]
		tx = ve.dm.Transaction.newFromWrap(
			documentModel,
			unlistRangesArr[i],
			[ { 'type': 'list' } ],
			[],
			[ { 'type': 'listItem' } ],
			[]
		);
		selection = tx.translateRange( selection );
		surfaceModel.change( tx );
		// Translate all the remaining ranges for this transaction
		// TODO ideally we'd have a way to merge all these transactions into one and execute that instead
		for ( j = i + 1; j < unlistRangesArr.length; j++ ) {
			unlistRangesArr[j] = tx.translateRange( unlistRangesArr[j] );
		}
	}
	// Update the selection
	surfaceModel.change( null, selection );
	surfaceModel.breakpoint();
};

/**
 * Recursively prepare to unwrap all lists in a given range.
 *
 * This function will find all lists covered wholly or partially by the given range, as well
 * as all lists inside these lists, and return their inner ranges. This means that all sublists
 * will be found even if range doesn't cover them.
 *
 * To actually unwrap the list, feed the returned ranges to ve.dm.Transaction.newFromWrap(),
 * in order.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @param {ve.dm.Document} documentModel
 * @param {ve.Range} range
 * @returns {ve.Range[]} Array of inner ranges of lists
 */
ve.ListAction.prototype.getUnlistRanges = function( range ) {
	var i, j, k, group, previousList, list, listItem, subList,
		unlistRanges = {},
		endOffset = 0,
		documentModel = this.surface.getModel().getDocument(),
		groups = documentModel.getCoveredSiblingGroups( range );

	for ( i = 0; i < groups.length; i++ ) {
		group = groups[i];
		list = group.grandparent;
		if ( list && list.getType() === 'list' && list !== previousList ) {
			// Unwrap the parent list
			range = list.getRange();
			if ( range.end > endOffset ) {
				unlistRanges[range.start + '-' + range.end] = range;
				endOffset = range.end;
			}
			// Skip this list next time
			previousList = list;
			// Recursively unwrap any sublists of the list
			for ( j = 0; j < list.children.length; j++ ) {
				listItem = list.children[j];
				if ( listItem.getType() === 'listItem' ) {
					for ( k = 0; k < listItem.children.length; k++ ) {
						subList = listItem.children[k];
						if ( subList.getType() === 'list' ) {
							// Recurse
							unlistRanges = ve.extendObject( unlistRanges, this.getUnlistRanges(
								subList.getRange()
							) );
						}
					}
				}
			}
		}
	}
	return unlistRanges;
};

/* Registration */

ve.actionFactory.register( 'list', ve.ListAction );
