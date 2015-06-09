/*!
 * VisualEditor UserInterface HistoryAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * History action.
 *
 * @class
 * @extends ve.ui.Action
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.HistoryAction = function VeUiHistoryAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.HistoryAction, ve.ui.Action );

/* Static Properties */

ve.ui.HistoryAction.static.name = 'history';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.HistoryAction.static.methods = [ 'undo', 'redo' ];

/* Methods */

/**
 * Step backwards in time.
 *
 * @method
 * @return {boolean} Action was executed
 */
ve.ui.HistoryAction.prototype.undo = function () {
	this.surface.getModel().undo();
	return true;
};

/**
 * Step forwards in time.
 *
 * @method
 * @return {boolean} Action was executed
 */
ve.ui.HistoryAction.prototype.redo = function () {
	this.surface.getModel().redo();
	return true;
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.HistoryAction );
