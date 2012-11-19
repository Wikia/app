/**
 * VisualEditor HistoryAction class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * History action.
 *
 * @class
 * @constructor
 * @extends {ve.Action}
 * @param {ve.Surface} surface Surface to act on
 */
ve.HistoryAction = function VeHistoryAction( surface ) {
	// Parent constructor
	ve.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.HistoryAction, ve.Action );

/* Static Members */

/**
 * List of allowed methods for this action.
 *
 * @static
 * @member
 */
ve.HistoryAction.static.methods = ['undo', 'redo'];

/* Methods */

/**
 * Steps backwards in time.
 *
 * @method
 */
ve.HistoryAction.prototype.undo = function () {
	this.surface.getModel().undo();
};

/**
 * Steps forwards in time.
 *
 * @method
 */
ve.HistoryAction.prototype.redo = function () {
	this.surface.getModel().redo();
};

/* Registration */

ve.actionFactory.register( 'history', ve.HistoryAction );
