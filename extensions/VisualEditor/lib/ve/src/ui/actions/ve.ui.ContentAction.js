/*!
 * VisualEditor UserInterface ContentAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Content action.
 *
 * @class
 * @extends ve.ui.Action
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.ContentAction = function VeUiContentAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.ContentAction, ve.ui.Action );

/* Static Properties */

ve.ui.ContentAction.static.name = 'content';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.ContentAction.static.methods = [ 'insert', 'remove', 'select', 'pasteSpecial', 'selectAll' ];

/* Methods */

/**
 * Insert content.
 *
 * @method
 * @param {string|Array} content Content to insert, can be either a string or array of data
 * @param {boolean} annotate Content should be automatically annotated to match surrounding content
 * @return {boolean} Action was executed
 */
ve.ui.ContentAction.prototype.insert = function ( content, annotate ) {
	this.surface.getModel().getFragment().insertContent( content, annotate );
	return true;
};

/**
 * Remove content.
 *
 * @method
 * @return {boolean} Action was executed
 */
ve.ui.ContentAction.prototype.remove = function () {
	this.surface.getModel().getFragment().removeContent();
	return true;
};

/**
 * Select content.
 *
 * @method
 * @param {ve.dm.Selection} selection Selection
 * @return {boolean} Action was executed
 */
ve.ui.ContentAction.prototype.select = function ( selection ) {
	this.surface.getModel().setSelection( selection );
	return true;
};

/**
 * Select all content.
 *
 * @method
 * @return {boolean} Action was executed
 */
ve.ui.ContentAction.prototype.selectAll = function () {
	this.surface.getView().selectAll();
	return true;
};

/**
 * Paste special.
 *
 * @method
 * @return {boolean} Action was executed
 */
ve.ui.ContentAction.prototype.pasteSpecial = function () {
	this.surface.getView().pasteSpecial = true;
	// Return false to allow the paste event to occur
	return false;
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.ContentAction );
