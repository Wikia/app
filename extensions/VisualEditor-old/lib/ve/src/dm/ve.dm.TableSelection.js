/*!
 * VisualEditor Table Selection class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * @class
 * @extends ve.dm.Selection
 * @constructor
 * @param {ve.dm.Document} doc Document model
 * @param {ve.Range} tableRange Table range
 * @param {number} fromCol Starting column
 * @param {number} fromRow Starting row
 * @param {number} [toCol] End column
 * @param {number} [toRow] End row
 * @param {boolean} [expand] Expand the selection to include merged cells
 */
ve.dm.TableSelection = function VeDmTableSelection( doc, tableRange, fromCol, fromRow, toCol, toRow, expand ) {
	// Parent constructor
	ve.dm.TableSelection.super.call( this, doc );

	this.tableRange = tableRange;
	this.tableNode = null;

	this.fromCol = fromCol;
	this.fromRow = fromRow;
	this.toCol = toCol === undefined ? this.fromCol : toCol;
	this.toRow = toRow === undefined ? this.fromRow : toRow;
	this.startCol = fromCol < toCol ? fromCol : toCol;
	this.startRow = fromRow < toRow ? fromRow : toRow;
	this.endCol = fromCol < toCol ? toCol : fromCol;
	this.endRow = fromRow < toRow ? toRow : fromRow;
	this.intendedFromCol = this.fromCol;
	this.intendedFromRow = this.fromRow;
	this.intendedToCol = this.toCol;
	this.intendedToRow = this.toRow;

	if ( expand ) {
		this.expand();
	}
};

/* Inheritance */

OO.inheritClass( ve.dm.TableSelection, ve.dm.Selection );

/* Static Properties */

ve.dm.TableSelection.static.name = 'table';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.dm.TableSelection.static.newFromHash = function ( doc, hash ) {
	return new ve.dm.TableSelection(
		doc,
		ve.Range.static.newFromHash( hash.tableRange ),
		hash.fromCol,
		hash.fromRow,
		hash.toCol,
		hash.toRow
	);
};

/* Methods */

/**
 * Expand the selection to cover all merged cells
 *
 * @private
 */
ve.dm.TableSelection.prototype.expand = function () {
	var cell, i,
		lastCellCount = 0,
		startCol = Infinity,
		startRow = Infinity,
		endCol = -Infinity,
		endRow = -Infinity,
		colBackwards = this.fromCol > this.toCol,
		rowBackwards = this.fromRow > this.toRow,
		cells = this.getMatrixCells();

	while ( cells.length > lastCellCount ) {
		for ( i = 0; i < cells.length; i++ ) {
			cell = cells[i];
			startCol = Math.min( startCol, cell.col );
			startRow = Math.min( startRow, cell.row );
			endCol = Math.max( endCol, cell.col + cell.node.getColspan() - 1 );
			endRow = Math.max( endRow, cell.row + cell.node.getRowspan() - 1 );
		}
		this.startCol = startCol;
		this.startRow = startRow;
		this.endCol = endCol;
		this.endRow = endRow;
		this.fromCol = colBackwards ? endCol : startCol;
		this.fromRow = rowBackwards ? endRow : startRow;
		this.toCol = colBackwards ? startCol : endCol;
		this.toRow = rowBackwards ? startRow : endRow;

		lastCellCount = cells.length;
		cells = this.getMatrixCells();
	}
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.clone = function () {
	return new this.constructor( this.getDocument(), this.tableRange, this.fromCol, this.fromRow, this.toCol, this.toRow );
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.toJSON = function () {
	return {
		type: this.constructor.static.name,
		tableRange: this.tableRange,
		fromCol: this.fromCol,
		fromRow: this.fromRow,
		toCol: this.toCol,
		toRow: this.toRow
	};
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.getDescription = function () {
	return (
		'Table: ' +
		this.tableRange.from + ' - ' + this.tableRange.to +
		', ' +
		'c' + this.fromCol + ' r' + this.fromRow +
		' - ' +
		'c' + this.toCol + ' r' + this.toRow
	);
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.collapseToStart = function () {
	return new this.constructor( this.getDocument(), this.tableRange, this.startCol, this.startRow, this.startCol, this.startRow );
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.collapseToEnd = function () {
	return new this.constructor( this.getDocument(), this.tableRange, this.endCol, this.endRow, this.endCol, this.endRow );
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.collapseToFrom = function () {
	return new this.constructor( this.getDocument(), this.tableRange, this.fromCol, this.fromRow, this.fromCol, this.fromRow );
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.collapseToTo = function () {
	return new this.constructor( this.getDocument(), this.tableRange, this.toCol, this.toRow, this.toCol, this.toRow );
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.getRanges = function () {
	var i, l, ranges = [],
		cells = this.getMatrixCells();
	for ( i = 0, l = cells.length; i < l; i++ ) {
		ranges.push( cells[i].node.getRange() );
	}
	return ranges;
};

/**
 * Get outer ranges of the selected cells
 *
 * @return {ve.Range[]} Outer ranges
 */
ve.dm.TableSelection.prototype.getOuterRanges = function () {
	var i, l, ranges = [],
		cells = this.getMatrixCells();
	for ( i = 0, l = cells.length; i < l; i++ ) {
		ranges.push( cells[i].node.getOuterRange() );
	}
	return ranges;
};

/**
 * Retrieves all cells (no placeholders) within a given selection.
 *
 * @param {boolean} [includePlaceholders] Include placeholders in result
 * @returns {ve.dm.TableMatrixCell[]} List of table cells
 */
ve.dm.TableSelection.prototype.getMatrixCells = function ( includePlaceholders ) {
	var row, col, cell,
		matrix = this.getTableNode().getMatrix(),
		cells = [],
		visited = {};

	for ( row = this.startRow; row <= this.endRow; row++ ) {
		for ( col = this.startCol; col <= this.endCol; col++ ) {
			cell = matrix.getCell( row, col );
			if ( !cell ) {
				continue;
			}
			if ( !includePlaceholders && cell.isPlaceholder() ) {
				cell = cell.owner;
			}
			if ( !visited[cell.key] ) {
				cells.push( cell );
				visited[cell.key] = true;
			}
		}
	}
	return cells;
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.isCollapsed = function () {
	return false;
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.translateByTransaction = function ( tx, excludeInsertion ) {
	var newRange = tx.translateRange( this.tableRange, excludeInsertion );

	if ( newRange.isCollapsed() ) {
		return new ve.dm.NullSelection( this.getDocument() );
	}
	return new this.constructor(
		this.getDocument(), newRange,
		this.fromCol, this.fromRow, this.toCol, this.toRow
	);
};

/**
 * Check if the selection spans a single cell
 * @return {boolean} The selection spans a single cell
 */
ve.dm.TableSelection.prototype.isSingleCell = function () {
	if (
		// Quick check for single non-merged cell
		( this.fromRow === this.toRow && this.fromCol === this.toCol ) ||
		// Check for a merged single cell by ignoring placeholders
		this.getMatrixCells().length === 1
	) {
		return true;
	}
};

/**
 * Get the selection's table node
 *
 * @return {ve.dm.TableNode} Table node
 */
ve.dm.TableSelection.prototype.getTableNode = function () {
	if ( !this.tableNode ) {
		this.tableNode = this.getDocument().getBranchNodeFromOffset( this.tableRange.start + 1 );
	}
	return this.tableNode;
};

/**
 * Clone this selection with adjusted row and column positions
 *
 * Placeholder cells are skipped over so this method can be used for cursoring.
 *
 * @param {number} fromColOffset Starting column offset
 * @param {number} fromRowOffset Starting row offset
 * @param {number} [toColOffset] End column offset
 * @param {number} [toRowOffset] End row offset
 * @return {ve.dm.TableSelection} Adjusted selection
 */
ve.dm.TableSelection.prototype.newFromAdjustment = function ( fromColOffset, fromRowOffset, toColOffset, toRowOffset ) {
	var fromCell, toCell,
		matrix = this.getTableNode().getMatrix();

	if ( toColOffset === undefined ) {
		toColOffset = fromColOffset;
	}

	if ( toRowOffset === undefined ) {
		toRowOffset = fromRowOffset;
	}

	function adjust( mode, cell, offset ) {
		var nextCell,
			col = cell.col,
			row = cell.row,
			dir = offset > 0 ? 1 : -1;

		while ( offset !== 0 ) {
			if ( mode === 'col' ) {
				col += dir;
				if ( col >= matrix.getColCount( row ) || col < 0 ) {
					// Out of bounds
					break;
				}
			} else {
				row += dir;
				if ( row >= matrix.getRowCount() || row < 0 ) {
					// Out of bounds
					break;
				}
			}
			nextCell = matrix.getCell( row, col );
			// Skip if same as current cell (i.e. merged cells), or null
			if ( !nextCell || nextCell.equals( cell ) ) {
				continue;
			}
			offset -= dir;
			cell = nextCell;
		}
		return cell;
	}

	fromCell = matrix.getCell( this.intendedFromRow, this.intendedFromCol );
	if ( fromColOffset ) {
		fromCell = adjust( 'col', fromCell, fromColOffset );
	}
	if ( fromRowOffset ) {
		fromCell = adjust( 'row', fromCell, fromRowOffset );
	}

	toCell = matrix.getCell( this.intendedToRow, this.intendedToCol );
	if ( toColOffset ) {
		toCell = adjust( 'col', toCell, toColOffset );
	}
	if ( toRowOffset ) {
		toCell = adjust( 'row', toCell, toRowOffset );
	}

	return new this.constructor(
		this.getDocument(),
		this.tableRange,
		fromCell.col,
		fromCell.row,
		toCell.col,
		toCell.row,
		true
	);
};

/**
 * @inheritdoc
 */
ve.dm.TableSelection.prototype.equals = function ( other ) {
	return other instanceof ve.dm.TableSelection &&
		this.getDocument() === other.getDocument() &&
		this.tableRange.equals( other.tableRange ) &&
		this.fromCol === other.fromCol &&
		this.fromRow === other.fromRow &&
		this.toCol === other.toCol &&
		this.toRow === other.toRow;
};

/**
 * Check if the table selection covers one or more full rows
 *
 * @return {boolean} The table selection covers one or more full rows
 */
ve.dm.TableSelection.prototype.isFullRow = function () {
	var matrix = this.getTableNode().getMatrix();
	return this.endCol - this.startCol === matrix.getColCount() - 1;
};

/**
 * Check if the table selection covers one or more full columns
 *
 * @return {boolean} The table selection covers one or more full columns
 */
ve.dm.TableSelection.prototype.isFullCol = function () {
	var matrix = this.getTableNode().getMatrix();
	return this.endRow - this.startRow === matrix.getRowCount() - 1;
};

/* Registration */

ve.dm.selectionFactory.register( ve.dm.TableSelection );
