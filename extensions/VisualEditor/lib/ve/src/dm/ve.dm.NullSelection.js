/*!
 * VisualEditor Null Selection class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * @class
 * @extends ve.dm.Selection
 * @constructor
 */
ve.dm.NullSelection = function VeDmNullSelection( doc ) {
	// Parent constructor
	ve.dm.NullSelection.super.call( this, doc );
};

/* Inheritance */

OO.inheritClass( ve.dm.NullSelection, ve.dm.Selection );

/* Static Properties */

ve.dm.NullSelection.static.name = 'null';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.dm.NullSelection.static.newFromHash = function ( doc ) {
	return new ve.dm.NullSelection( doc );
};

/* Methods */

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.toJSON = function () {
	return {
		type: this.constructor.static.name
	};
};

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.getDescription = function () {
	return 'Null';
};

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.clone = function () {
	return new this.constructor( this.getDocument() );
};

ve.dm.NullSelection.prototype.collapseToStart = ve.dm.NullSelection.prototype.clone;

ve.dm.NullSelection.prototype.collapseToEnd = ve.dm.NullSelection.prototype.clone;

ve.dm.NullSelection.prototype.collapseToFrom = ve.dm.NullSelection.prototype.clone;

ve.dm.NullSelection.prototype.collapseToTo = ve.dm.NullSelection.prototype.clone;

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.isCollapsed = function () {
	return true;
};

ve.dm.NullSelection.prototype.translateByTransaction = ve.dm.NullSelection.prototype.clone;

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.getRanges = function () {
	return [];
};

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.equals = function ( other ) {
	return other instanceof ve.dm.NullSelection &&
		this.getDocument() === other.getDocument();
};

/**
 * @inheritdoc
 */
ve.dm.NullSelection.prototype.isNull = function () {
	return true;
};

/* Registration */

ve.dm.selectionFactory.register( ve.dm.NullSelection );
