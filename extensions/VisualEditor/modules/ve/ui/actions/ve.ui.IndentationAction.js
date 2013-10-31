/*!
 * VisualEditor UserInterface IndentationAction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Indentation action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.IndentationAction = function VeUiIndentationAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.ui.IndentationAction, ve.ui.Action );

/* Static Properties */

ve.ui.IndentationAction.static.name = 'indentation';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.IndentationAction.static.methods = [ 'increase', 'decrease' ];

/* Methods */

/**
 * Indent content.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @returns {boolean} Indentation increase occured
 */
ve.ui.IndentationAction.prototype.increase = function () {
	var i, group,
		fragments = [],
		increased = false,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selected = surfaceModel.getFragment(),
		groups = documentModel.getCoveredSiblingGroups( selected.getRange() );

	// Build fragments from groups (we need their ranges since the nodes will be rebuilt on change)
	for ( i = 0; i < groups.length; i++ ) {
		group = groups[i];
		if ( group.grandparent && group.grandparent.getType() === 'list' ) {
			fragments.push( surfaceModel.getFragment( group.parent.getRange(), true ) );
			increased = true;
		}
	}

	// Process each fragment (their ranges are automatically adjusted on change)
	for ( i = 0; i < fragments.length; i++ ) {
		this.indentListItem(
			documentModel.getNodeFromOffset( fragments[i].getRange().start )
		);
	}

	selected.select();

	return increased;
};

/**
 * Unindent content.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @returns {boolean} Indentation decrease occured
 */
ve.ui.IndentationAction.prototype.decrease = function () {
	var i, group,
		fragments = [],
		decreased = false,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selected = surfaceModel.getFragment(),
		groups = documentModel.getCoveredSiblingGroups( selected.getRange() );

	// Build fragments from groups (we need their ranges since the nodes will be rebuilt on change)
	for ( i = 0; i < groups.length; i++ ) {
		group = groups[i];
		if ( group.grandparent && group.grandparent.getType() === 'list' ) {
			fragments.push( surfaceModel.getFragment( group.parent.getRange(), true ) );
			decreased = true;
		}
	}

	// Process each fragment (their ranges are automatically adjusted on change)
	for ( i = 0; i < fragments.length; i++ ) {
		this.unindentListItem(
			documentModel.getNodeFromOffset( fragments[i].getRange().start )
		);
	}

	selected.select();

	return decreased;
};

/**
 * Indent a list item.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @param {ve.dm.ListItemNode} listItem List item to indent
 * @throws {Error} listItem must be a ve.dm.ListItemNode
 */
ve.ui.IndentationAction.prototype.indentListItem = function ( listItem ) {
	if ( !( listItem instanceof ve.dm.ListItemNode ) ) {
		throw new Error( 'listItem must be a ve.dm.ListItemNode' );
	}
	/*
	 * Indenting a list item is done as follows:
	 *
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
		documentModel.data.getData( listItemRange.start ).type === 'listItem' &&
		documentModel.data.getData( listItemRange.start - 1 ).type === '/listItem'
	) {
		mergeStart = listItemRange.start - 1;
		mergeEnd = listItemRange.start + 1;
		// (3) If this results in adjacent lists, merge those too
		if (
			documentModel.data.getData( mergeEnd ).type === 'list' &&
			documentModel.data.getData( mergeStart - 1 ).type === '/list'
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
 * Unindent a list item.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @param {ve.dm.ListItemNode} listItem List item to unindent
 * @throws {Error} listItem must be a ve.dm.ListItemNode
 */
ve.ui.IndentationAction.prototype.unindentListItem = function ( listItem ) {
	if ( !( listItem instanceof ve.dm.ListItemNode ) ) {
		throw new Error( 'listItem must be a ve.dm.ListItemNode' );
	}
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
	var tx, i, length, children, child, splitListRange,
		surfaceModel = this.surface.getModel(),
		fragment = surfaceModel.getFragment( listItem.getOuterRange(), true ),
		documentModel = surfaceModel.getDocument(),
		list = listItem.getParent(),
		listElement = list.getClonedElement(),
		grandParentType = list.getParent().getType(),
		listItemRange = listItem.getOuterRange();

	// CAREFUL: after initializing the variables above, we cannot use the model tree!
	// The first transaction will cause rebuilds so the nodes we have references to now
	// will be detached and useless after the first transaction. Instead, inspect
	// documentModel.data to find out things about the current structure.

	// (1) Split the listItem into a separate list
	if ( documentModel.data.getData( listItemRange.start - 1 ).type !== 'list' ) {
		// (1a) listItem is not the first child, split the list before listItem
		tx = ve.dm.Transaction.newFromInsertion( documentModel, listItemRange.start,
			[ { 'type': '/list' }, listElement ]
		);
		surfaceModel.change( tx );
		// tx.translateRange( listItemRange ) doesn't do what we want
		listItemRange = ve.Range.newFromTranslatedRange( listItemRange, 2 );
	}
	if ( documentModel.data.getData( listItemRange.end ).type !== '/list' ) {
		// (1b) listItem is not the last child, split the list after listItem
		tx = ve.dm.Transaction.newFromInsertion( documentModel, listItemRange.end,
			[ { 'type': '/list' }, listElement ]
		);
		surfaceModel.change( tx );
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

		// ensure paragraphs are not wrapper paragraphs now
		// that they are not in a list
		children = fragment.getSiblingNodes();
		for ( i = 0, length = children.length; i < length; i++ ) {
			child = children[i].node;
			if (
				child.type === 'paragraph' &&
				child.element.internal &&
				child.element.internal.generated === 'wrapper'
			) {
				delete child.element.internal.generated;
				if ( ve.isEmptyObject( child.element.internal ) ) {
					delete child.element.internal;
				}
			}
		}
	} else {
		// (3) Split the list away from parentListItem into its own listItem
		// TODO factor common split logic somehow?
		if ( documentModel.data.getData( splitListRange.start - 1 ).type !== 'listItem' ) {
			// (3a) Split parentListItem before list
			tx = ve.dm.Transaction.newFromInsertion( documentModel, splitListRange.start,
				[ { 'type': '/listItem' }, { 'type': 'listItem' } ]
			);
			surfaceModel.change( tx );
			// tx.translateRange( splitListRange ) doesn't do what we want
			splitListRange = ve.Range.newFromTranslatedRange( splitListRange, 2 );
		}
		if ( documentModel.data.getData( splitListRange.end ).type !== '/listItem' ) {
			// (3b) Split parentListItem after list
			tx = ve.dm.Transaction.newFromInsertion( documentModel, splitListRange.end,
				[ { 'type': '/listItem' }, { 'type': 'listItem' } ]
			);
			surfaceModel.change( tx );
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
	}
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.IndentationAction );
