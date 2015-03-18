/*!
 * VisualEditor FileDropHandlerFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Drop handler Factory.
 *
 * @class
 * @extends OO.Factory
 * @constructor
 */
ve.ui.FileDropHandlerFactory = function VeUiFileDropHandlerFactory() {
	// Parent constructor
	ve.ui.FileDropHandlerFactory.super.apply( this, arguments );

	this.handlerNamesByType = {};
};

/* Inheritance */

OO.inheritClass( ve.ui.FileDropHandlerFactory, OO.Factory );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.FileDropHandlerFactory.prototype.register = function ( constructor ) {
	// Parent method
	ve.ui.FileDropHandlerFactory.super.prototype.register.call( this, constructor );

	var i, l, types = constructor.static.types;
	for ( i = 0, l = types.length; i < l; i++ ) {
		this.handlerNamesByType[types[i]] = constructor.static.name;
	}
};

/**
 * Returns the primary command for for node.
 *
 * @param {string} type File type
 * @returns {string|undefined} Handler name, or undefined if not found
 */
ve.ui.FileDropHandlerFactory.prototype.getHandlerNameForType = function ( type ) {
	return this.handlerNamesByType[type];
};

/* Initialization */

ve.ui.fileDropHandlerFactory = new ve.ui.FileDropHandlerFactory();
