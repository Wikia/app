/**
 * VisualEditor IndentationAction class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Indentation action.
 *
 * @class
 * @constructor
 * @extends {ve.Action}
 * @param {ve.Surface} surface Surface to act on
 */
ve.IndentationAction = function VeIndentationAction( surface ) {
	// Parent constructor
	ve.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.IndentationAction, ve.Action );

/* Static Members */

/**
 * List of allowed methods for this action.
 *
 * @static
 * @member
 */
ve.IndentationAction.static.methods = ['increase', 'decrease'];

/* Methods */

/**
 * Increases indentation level.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @returns {Boolean} Indentation increase occured
 */
ve.IndentationAction.prototype.increase = function () {
	var i, group,
		increased = false,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		groups = documentModel.getCoveredSiblingGroups( selection );

	for ( i = 0; i < groups.length; i++ ) {
		group = groups[i];
		if ( group.grandparent && group.grandparent.getType() === 'list' ) {
			// FIXME this doesn't work when trying to work with multiple list items
			this.indentListItem( group.parent );
			increased = true;
		}
	}
	return increased;
};

/**
 * Decreses indentation level.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @returns {Boolean} Indentation decrease occured
 */
ve.IndentationAction.prototype.decrease = function () {
	var i, group,
		decreased = false,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		groups = documentModel.getCoveredSiblingGroups( selection );

	for ( i = 0; i < groups.length; i++ ) {
		group = groups[i];
		if ( group.grandparent && group.grandparent.getType() === 'list' ) {
			// FIXME this doesn't work when trying to work with multiple list items
			this.outdentListItem( group.parent );
			decreased = true;
		}
	}
	return decreased;
};

/**
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 */
ve.IndentationAction.prototype.indentListItem = function ( listItem ) {
	/*
	 * Indenting a list item is done as follows:
	 * 1. Wrap the listItem in a list and a listItem (<li> --> <li><ul><li>)
	 * 2. Merge this wrapped listItem into the previous listItem if present
	 *    (<li>Previous</li><li><ul><li>This --> <li>Previous<ul><li>This)
	 * 3. If this results in the wrapped list being preceded by another list,
	 *    merge those lists.
	 */
	var tx,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		listType = listItem.getParent().getAttribute( 'style' ),
		listItemRange = listItem.getOuterRange(),
		innerListItemRange,
		outerListItemRange,
		mergeStart,
		mergeEnd;

	// CAREFUL: after initializing the variables above, we cannot use the model tree!
	// The first transaction will cause rebuilds so the nodes we have references to now
	// will be detached and useless after the first transaction. Instead, inspect
	// documentModel.data to find out things about the current structure.

	// (1) Wrap the listItem in a list and a listItem
	tx = ve.dm.Transaction.newFromWrap( documentModel,
		listItemRange,
		[],
		[ { 'type': 'listItem' }, { 'type': 'list', 'attributes': { 'style': listType } } ],
		[],
		[]
	);
	surfaceModel.change( tx );
	selection = tx.translateRange( selection );
	// tx.translateRange( innerListItemRange ) doesn't do what we want
	innerListItemRange = ve.Range.newFromTranslatedRange( listItemRange, 2 );
	outerListItemRange = new ve.Range( listItemRange.start, listItemRange.end + 2 );

	// (2) Merge the listItem into the previous listItem (if there is one)
	if (
		documentModel.data[listItemRange.start].type === 'listItem' &&
		documentModel.data[listItemRange.start - 1].type === '/listItem'
	) {
		mergeStart = listItemRange.start - 1;
		mergeEnd = listItemRange.start + 1;
		// (3) If this results in adjacent lists, merge those too
		if (
			documentModel.data[mergeEnd].type === 'list' &&
			documentModel.data[mergeStart - 1].type === '/list'
		) {
			mergeStart--;
			mergeEnd++;
		}
		tx = ve.dm.Transaction.newFromRemoval( documentModel, new ve.Range( mergeStart, mergeEnd ) );
		surfaceModel.change( tx );
		selection = tx.translateRange( selection );
		innerListItemRange = tx.translateRange( innerListItemRange );
		outerListItemRange = tx.translateRange( outerListItemRange );
	}

	// TODO If this listItem has a child list, split&unwrap it

	surfaceModel.change( null, selection );
};

/**
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 */
ve.IndentationAction.prototype.outdentListItem = function ( listItem ) {
	/*
	 * Outdenting a list item is done as follows:
	 * 1. Split the parent list to isolate the listItem in its own list
	 * 1a. Split the list before the listItem if it's not the first child
	 * 1b. Split the list after the listItem if it's not the last child
	 * 2. If this isolated list's parent is not a listItem, unwrap the listItem and the isolated list, and stop.
	 * 3. Split the parent listItem to isolate the list in its own listItem
	 * 3a. Split the listItem before the list if it's not the first child
	 * 3b. Split the listItem after the list if it's not the last child
	 * 4. Unwrap the now-isolated listItem and the isolated list
	 */
	// TODO: Child list handling, gotta figure that out.
	var tx,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		list = listItem.getParent(),
		listElement = list.getClonedElement(),
		grandParentType = list.getParent().getType(),
		listItemRange = listItem.getOuterRange(),
		splitListRange;

	// CAREFUL: after initializing the variables above, we cannot use the model tree!
	// The first transaction will cause rebuilds so the nodes we have references to now
	// will be detached and useless after the first transaction. Instead, inspect
	// documentModel.data to find out things about the current structure.

	// (1) Split the listItem into a separate list
	if ( documentModel.data[listItemRange.start - 1].type !== 'list' ) {
		// (1a) listItem is not the first child, split the list before listItem
		tx = ve.dm.Transaction.newFromInsertion( documentModel, listItemRange.start,
			[ { 'type': '/list' }, listElement ]
		);
		surfaceModel.change( tx );
		selection = tx.translateRange( selection );
		// tx.translateRange( listItemRange ) doesn't do what we want
		listItemRange = ve.Range.newFromTranslatedRange( listItemRange, 2 );
	}
	if ( documentModel.data[listItemRange.end].type !== '/list' ) {
		// (1b) listItem is not the last child, split the list after listItem
		tx = ve.dm.Transaction.newFromInsertion( documentModel, listItemRange.end,
			[ { 'type': '/list' }, listElement ]
		);
		surfaceModel.change( tx );
		selection = tx.translateRange( selection );
		// listItemRange is not affected by this transaction
	}
	splitListRange = new ve.Range( listItemRange.start - 1, listItemRange.end + 1 );

	if ( grandParentType !== 'listItem' ) {
		// The user is trying to unindent a list item that's not nested
		// (2) Unwrap both the list and the listItem, dumping the listItem's contents
		// into the list's parent
		tx = ve.dm.Transaction.newFromWrap( documentModel,
			new ve.Range( listItemRange.start + 1, listItemRange.end - 1 ),
			[ { 'type': 'list' }, { 'type': 'listItem' } ],
			[],
			[],
			[]
		);
		surfaceModel.change( tx );
		selection = tx.translateRange( selection );
	} else {
		// (3) Split the list away from parentListItem into its own listItem
		// TODO factor common split logic somehow?
		if ( documentModel.data[splitListRange.start - 1].type !== 'listItem' ) {
			// (3a) Split parentListItem before list
			tx = ve.dm.Transaction.newFromInsertion( documentModel, splitListRange.start,
				[ { 'type': '/listItem' }, { 'type': 'listItem' } ]
			);
			surfaceModel.change( tx );
			selection = tx.translateRange( selection );
			// tx.translateRange( splitListRange ) doesn't do what we want
			splitListRange = ve.Range.newFromTranslatedRange( splitListRange, 2 );
		}
		if ( documentModel.data[splitListRange.end].type !== '/listItem' ) {
			// (3b) Split parentListItem after list
			tx = ve.dm.Transaction.newFromInsertion( documentModel, splitListRange.end,
				[ { 'type': '/listItem' }, { 'type': 'listItem' } ]
			);
			surfaceModel.change( tx );
			selection = tx.translateRange( selection );
			// splitListRange is not affected by this transaction
		}

		// (4) Unwrap the list and its containing listItem
		tx = ve.dm.Transaction.newFromWrap( documentModel,
			new ve.Range( splitListRange.start + 1, splitListRange.end - 1 ),
			[ { 'type': 'listItem' }, { 'type': 'list' } ],
			[],
			[],
			[]
		);
		surfaceModel.change( tx );
		selection = tx.translateRange( selection );
	}

	surfaceModel.change( null, selection );
};

/* Registration */

ve.actionFactory.register( 'indentation', ve.IndentationAction );
