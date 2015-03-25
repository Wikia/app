/*!
 * VisualEditor ContentEditable TableNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable table node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.TableNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.TableNode = function VeCeTableNode() {
	// Parent constructor
	ve.ce.TableNode.super.apply( this, arguments );

	this.surface = null;
	this.active = false;
	this.startCell = null;
	this.editingFragment = null;
};

/* Inheritance */

OO.inheritClass( ve.ce.TableNode, ve.ce.BranchNode );

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.TableNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.TableNode.super.prototype.onSetup.call( this );

	// Exit if already setup or not attached
	if ( this.isSetup || !this.root ) {
		return;
	}
	this.surface = this.getRoot().getSurface();

	// DOM changes
	this.$element
		.addClass( 've-ce-tableNode' )
		.prop( 'contentEditable', 'false' );

	// Overlay
	this.$selectionBox = this.$( '<div>' ).addClass( 've-ce-tableNodeOverlay-selection-box' );
	this.$selectionBoxAnchor = this.$( '<div>' ).addClass( 've-ce-tableNodeOverlay-selection-box-anchor' );
	this.colContext = new ve.ui.TableContext( this, 'table-col', {
		$: this.$,
		classes: ['ve-ui-tableContext-colContext'],
		indicator: 'down'
	} );
	this.rowContext = new ve.ui.TableContext( this, 'table-row', {
		$: this.$,
		classes: ['ve-ui-tableContext-rowContext'],
		indicator: 'next'
	} );

	this.$overlay = this.$( '<div>' )
		.hide()
		.addClass( 've-ce-tableNodeOverlay' )
		.append( [
			this.$selectionBox,
			this.$selectionBoxAnchor,
			this.colContext.$element,
			this.rowContext.$element,
			this.$rowBracket,
			this.$colBracket
		] );
	this.surface.surface.$blockers.append( this.$overlay );

	// Events
	this.$element.on( {
		'mousedown.ve-ce-tableNode': this.onTableMouseDown.bind( this ),
		'dblclick.ve-ce-tableNode': this.onTableDblClick.bind( this )
	} );
	this.onTableMouseUpHandler = this.onTableMouseUp.bind( this );
	this.onTableMouseMoveHandler = this.onTableMouseMove.bind( this );
	// Select and position events both fire updateOverlay, so debounce. Also makes
	// sure that this.selectedRectangle is up to date before redrawing.
	this.updateOverlayDebounced = ve.debounce( this.updateOverlay.bind( this ) );
	this.surface.getModel().connect( this, { select: 'onSurfaceModelSelect' } );
	this.surface.connect( this, { position: this.updateOverlayDebounced } );
};

/**
 * @inheritdoc
 */
ve.ce.TableNode.prototype.onTeardown = function () {
	// Parent method
	ve.ce.TableNode.super.prototype.onTeardown.call( this );
	// Events
	this.$element.off( '.ve-ce-tableNode' );
	this.surface.getModel().disconnect( this );
	this.surface.disconnect( this );
	this.$overlay.remove();
};

/**
 * Handle table double click events
 *
 * @param {jQuery.Event} e Double click event
 */
ve.ce.TableNode.prototype.onTableDblClick = function ( e ) {
	if ( !this.getCellNodeFromTarget( e.target ) ) {
		return;
	}
	if ( this.surface.getModel().getSelection() instanceof ve.dm.TableSelection ) {
		this.setEditing( true );
	}
};

/**
 * Handle mouse down or touch start events
 *
 * @param {jQuery.Event} e Mouse down or touch start event
 */
ve.ce.TableNode.prototype.onTableMouseDown = function ( e ) {
	var cellNode, startCell, endCell, selection, newSelection;

	if ( e.type === 'touchstart' && e.originalEvent.touches.length > 1 ) {
		// Ignore multi-touch
		return;
	}

	cellNode = this.getCellNodeFromTarget( e.target );
	if ( !cellNode ) {
		return;
	}

	endCell = this.getModel().getMatrix().lookupCell( cellNode.getModel() );
	if ( !endCell ) {
		e.preventDefault();
		return;
	}
	selection = this.surface.getModel().getSelection();
	startCell = e.shiftKey && this.active ? { col: selection.fromCol, row: selection.fromRow } : endCell;
	newSelection = new ve.dm.TableSelection(
		this.getModel().getDocument(),
		this.getModel().getOuterRange(),
		startCell.col,
		startCell.row,
		endCell.col,
		endCell.row,
		true
	);
	if ( this.editingFragment ) {
		if ( newSelection.equals( this.editingFragment.getSelection() ) ) {
			// Clicking on the editing cell, don't prevent default
			return;
		} else {
			this.setEditing( false, true );
		}
	}
	this.surface.getModel().setSelection( newSelection );
	this.startCell = startCell;
	this.surface.$document.on( {
		'mouseup touchend': this.onTableMouseUpHandler,
		'mousemove touchmove': this.onTableMouseMoveHandler
	} );
	e.preventDefault();
};

/**
 * Get the table and cell node from an event target
 *
 * @param {HTMLElement} target Element target to find nearest cell node to
 * @return {ve.ce.TableCellNode|null} Table cell node, or null if none found
 */
ve.ce.TableNode.prototype.getCellNodeFromTarget = function ( target ) {
	var $target = $( target ),
		$table = $target.closest( 'table' );

	// Nested table, ignore
	if ( !this.$element.is( $table ) ) {
		return null;
	}

	return $target.closest( 'td, th' ).data( 'view' );
};

/**
 * Handle mouse/touch move events
 *
 * @param {jQuery.Event} e Mouse/touch move event
 */
ve.ce.TableNode.prototype.onTableMouseMove = function ( e ) {
	var cell, selection, touch, target, cellNode;

	// 'touchmove' doesn't give a correct e.target, so calculate it from coordinates
	if ( e.type === 'touchmove' ) {
		if ( e.originalEvent.touches.length > 1 ) {
			// Ignore multi-touch
			return;
		}
		touch = e.originalEvent.touches[0];
		target = this.surface.getElementDocument().elementFromPoint( touch.clientX, touch.clientY );
	} else {
		target = e.target;
	}

	cellNode = this.getCellNodeFromTarget( target );
	if ( !cellNode ) {
		return;
	}

	cell = this.getModel().matrix.lookupCell( cellNode.getModel() );
	if ( !cell ) {
		return;
	}

	selection = new ve.dm.TableSelection(
		this.getModel().getDocument(),
		this.getModel().getOuterRange(),
		this.startCell.col, this.startCell.row, cell.col, cell.row,
		true
	);
	this.surface.getModel().setSelection( selection );
};

/**
 * Handle mouse up or touch end events
 *
 * @param {jQuery.Event} e Mouse up or touch end event
 */
ve.ce.TableNode.prototype.onTableMouseUp = function () {
	this.startCell = null;
	this.surface.$document.off( {
		'mouseup touchend': this.onTableMouseUpHandler,
		'mousemove touchmove': this.onTableMouseMoveHandler
	} );
};

/**
 * Set the editing state of the table
 *
 * @param {boolean} isEditing The table is being edited
 * @param {boolean} noSelect Don't change the selection
 */
ve.ce.TableNode.prototype.setEditing = function ( isEditing, noSelect ) {
	if ( isEditing ) {
		var cell, selection = this.surface.getModel().getSelection();
		if ( !selection.isSingleCell() ) {
			selection = selection.collapseToFrom();
			this.surface.getModel().setSelection( selection );
		}
		this.editingFragment = this.surface.getModel().getFragment( selection );
		cell = this.getCellNodesFromSelection( selection )[0];
		cell.setEditing( true );
		if ( !noSelect ) {
		// TODO: Find content offset/slug offset within cell
			this.surface.getModel().setLinearSelection( new ve.Range( cell.getModel().getRange().end - 1 ) );
		}
	} else if ( this.editingFragment ) {
		this.getCellNodesFromSelection( this.editingFragment.getSelection() )[0].setEditing( false );
		if ( !noSelect ) {
			this.surface.getModel().setSelection( this.editingFragment.getSelection() );
		}
		this.editingFragment = null;
	}
	this.$element.toggleClass( 've-ce-tableNode-editing', isEditing );
	this.$overlay.toggleClass( 've-ce-tableNodeOverlay-editing', isEditing );
};

/**
 * Get fragment with table selection covering cell being edited
 *
 * @return {ve.dm.SurfaceFragment} Fragment, or null if not cell editing
 */
ve.ce.TableNode.prototype.getEditingFragment = function () {
	return this.editingFragment;
};

/**
 * Get range of cell being edited from editing fragment
 *
 * @return {ve.Range} Range, or null if not cell editing
 */
ve.ce.TableNode.prototype.getEditingRange = function () {
	var fragment = this.getEditingFragment();
	return fragment ? fragment.getSelection().getRanges()[0] : null;
};

/**
 * Handle select events from the surface model.
 *
 * @param {ve.dm.Selection} selection Selection
 */
ve.ce.TableNode.prototype.onSurfaceModelSelect = function ( selection ) {
	// The table is active if it is a linear selection inside a cell being edited
	// or a table selection matching this table.
	var active = (
			this.editingFragment !== null &&
			selection instanceof ve.dm.LinearSelection &&
			this.editingFragment.getSelection().getRanges()[0].containsRange( selection.getRange() )
		) ||
		(
			selection instanceof ve.dm.TableSelection &&
			selection.tableRange.equals( this.getModel().getOuterRange() )
		);

	if ( active ) {
		if ( !this.active ) {
			this.$overlay.show();
			// Only register touchstart event after table has become active to prevent
			// accidental focusing of the table while scrolling
			this.$element.on( 'touchstart.ve-ce-tableNode', this.onTableMouseDown.bind( this ) );
		}
		this.surface.setActiveTableNode( this );
		this.updateOverlayDebounced();
	} else if ( !active && this.active ) {
		this.$overlay.hide();
		if ( this.editingFragment ) {
			this.setEditing( false, true );
		}
		if ( this.surface.getActiveTableNode() === this ) {
			this.surface.setActiveTableNode( null );
		}
		this.$element.off( 'touchstart.ve-ce-tableNode' );
	}
	this.$element.toggleClass( 've-ce-tableNode-active', active );
	this.active = active;
};

/**
 * Update the overlay positions
 */
ve.ce.TableNode.prototype.updateOverlay = function () {
	if ( !this.active ) {
		return;
	}

	var i, l, nodes, cellOffset, anchorNode, anchorOffset, selectionOffset,
		top, left, bottom, right,
		selection = this.editingFragment ?
			this.editingFragment.getSelection() :
			this.surface.getModel().getSelection(),
		// getBoundingClientRect is more accurate but must be used consistently
		// due to the iOS7 bug where it is relative to the document.
		tableOffset = this.getFirstSectionNode().$element[0].getBoundingClientRect(),
		surfaceOffset = this.surface.getSurface().$element[0].getBoundingClientRect();

	if ( !tableOffset ) {
		return;
	}

	nodes = this.getCellNodesFromSelection( selection );
	anchorNode = this.getCellNodesFromSelection( selection.collapseToFrom() )[0];
	anchorOffset = ve.translateRect( anchorNode.$element[0].getBoundingClientRect(), -tableOffset.left, -tableOffset.top );

	top = Infinity;
	bottom = -Infinity;
	left = Infinity;
	right = -Infinity;

	// Compute a bounding box for the given cell elements
	for ( i = 0, l = nodes.length; i < l; i++) {
		cellOffset = nodes[i].$element[0].getBoundingClientRect();

		top = Math.min( top, cellOffset.top );
		bottom = Math.max( bottom, cellOffset.bottom );
		left = Math.min( left, cellOffset.left );
		right = Math.max( right, cellOffset.right );
	}

	selectionOffset = ve.translateRect(
		{ top: top, bottom: bottom, left: left, right: right, width: right - left, height: bottom - top },
		-tableOffset.left, -tableOffset.top
	);

	// Resize controls
	this.$selectionBox.css( {
		top: selectionOffset.top,
		left: selectionOffset.left,
		width: selectionOffset.width,
		height: selectionOffset.height
	} );
	this.$selectionBoxAnchor.css( {
		top: anchorOffset.top,
		left: anchorOffset.left,
		width: anchorOffset.width,
		height: anchorOffset.height
	} );

	// Position controls
	this.$overlay.css( {
		top: tableOffset.top - surfaceOffset.top,
		left: tableOffset.left - surfaceOffset.left,
		width: tableOffset.width
	} );
	this.colContext.$element.css( {
		left: selectionOffset.left
	} );
	this.colContext.indicator.$element.css( {
		width: selectionOffset.width
	} );
	this.colContext.popup.$element.css( {
		'margin-left': selectionOffset.width / 2
	} );
	this.rowContext.$element.css( {
		top: selectionOffset.top
	} );
	this.rowContext.indicator.$element.css( {
		height: selectionOffset.height
	} );
	this.rowContext.popup.$element.css( {
		'margin-top': selectionOffset.height / 2
	} );

	// Classes
	this.$selectionBox
		.toggleClass( 've-ce-tableNodeOverlay-selection-box-fullRow', selection.isFullRow() )
		.toggleClass( 've-ce-tableNodeOverlay-selection-box-fullCol', selection.isFullCol() );
};

/**
 * Get the first section node of the table, skipping over any caption nodes
 *
 * @return {ve.ce.TableSectionNode} First table section node
 */
ve.ce.TableNode.prototype.getFirstSectionNode = function () {
	var i = 0;
	while ( !( this.children[i] instanceof ve.ce.TableSectionNode ) ) {
		i++;
	}
	return this.children[i];
};

/**
 * Get a cell node from a single cell selection
 *
 * @param {ve.dm.TableSelection} selection Single cell table selection
 * @return {ve.ce.TableCellNode[]} Cell nodes
 */
ve.ce.TableNode.prototype.getCellNodesFromSelection = function ( selection ) {
	var i, l, cellModel, cellView,
		cells = selection.getMatrixCells(),
		nodes = [];

	for ( i = 0, l = cells.length; i < l; i++ ) {
		cellModel = cells[i].node;
		cellView = this.getNodeFromOffset( cellModel.getOffset() - this.model.getOffset() );
		nodes.push( cellView );
	}
	return nodes;
};

/* Static Properties */

ve.ce.TableNode.static.name = 'table';

ve.ce.TableNode.static.tagName = 'table';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.TableNode );
