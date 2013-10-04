/*!
 * VisualEditor UserInterface ContentAction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Content action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.ContentAction = function VeUiContentAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

ve.inheritClass( ve.ui.ContentAction, ve.ui.Action );

/* Static Properties */

ve.ui.ContentAction.static.name = 'content';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.ContentAction.static.methods = [ 'insert', 'remove', 'select' ];

/* Methods */

/**
 * Insert content.
 *
 * @method
 * @param {string|Array} content Content to insert, can be either a string or array of data
 * @param {boolean} annotate Content should be automatically annotated to match surrounding content
 */
ve.ui.ContentAction.prototype.insert = function ( content, annotate ) {
	this.surface.getModel().getFragment().insertContent( content, annotate );
};

/**
 * Remove content.
 *
 * @method
 */
ve.ui.ContentAction.prototype.remove = function () {
	this.surface.getModel().getFragment().removeContent();
};

/**
 * Select content.
 *
 * @method
 * @param {ve.Range} range Range to select
 */
ve.ui.ContentAction.prototype.select = function ( range ) {
	this.surface.getModel().change( null, range );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.ContentAction );
