/*!
 * VisualEditor UserInterface HistoryAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * History action.
 *
 * @class
 * @extends ve.ui.Action
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
 */
ve.ui.HistoryAction.prototype.undo = function () {
	this.surface.getModel().undo();
	this.surface.getView().focus();
};

/**
 * Step forwards in time.
 *
 * @method
 */
ve.ui.HistoryAction.prototype.redo = function () {
	this.surface.getModel().redo();
	this.surface.getView().focus();
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.HistoryAction );
