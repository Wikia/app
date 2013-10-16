/*!
 * VisualEditor UserInterface HistoryAction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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

ve.inheritClass( ve.ui.HistoryAction, ve.ui.Action );

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
	var range = this.surface.getModel().undo();
	if ( range ) {
		this.surface.getModel().change( null, range );
	}
};

/**
 * Step forwards in time.
 *
 * @method
 */
ve.ui.HistoryAction.prototype.redo = function () {
	var range = this.surface.getModel().redo();
	if ( range ) {
		this.surface.getModel().change( null, range );
	}
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.HistoryAction );
