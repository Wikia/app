/*!
 * VisualEditor DataTransferHandlerFactory class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Drop handler Factory.
 *
 * @class
 * @extends OO.Factory
 * @constructor
 */
ve.ui.DataTransferHandlerFactory = function VeUiDataTransferHandlerFactory() {
	// Parent constructor
	ve.ui.DataTransferHandlerFactory.super.apply( this, arguments );

	// Handlers which match all kinds and a specific type
	this.handlerNamesByType = {};
	// Handlers which match a specific kind and type
	this.handlerNamesByKindAndType = {};
	// Handlers which match a specific file extension as a fallback
	this.handlerNamesByExtension = {};
};

/* Inheritance */

OO.inheritClass( ve.ui.DataTransferHandlerFactory, OO.Factory );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.DataTransferHandlerFactory.prototype.register = function ( constructor ) {
	var i, j, ilen, jlen, kinds, types, extensions;

	// Parent method
	ve.ui.DataTransferHandlerFactory.super.prototype.register.call( this, constructor );

	kinds = constructor.static.kinds;
	types = constructor.static.types;
	extensions = constructor.static.extensions;

	function ensureArray( obj, prop ) {
		if ( obj[ prop ] === undefined ) {
			obj[ prop ] = [];
		}
		return obj[ prop ];
	}

	function ensureMap( obj, prop ) {
		if ( obj[ prop ] === undefined ) {
			obj[ prop ] = {};
		}
		return obj[ prop ];
	}

	if ( !kinds ) {
		for ( j = 0, jlen = types.length; j < jlen; j++ ) {
			ensureArray( this.handlerNamesByType, types[ j ] ).unshift( constructor.static.name );
		}
	} else {
		for ( i = 0, ilen = kinds.length; i < ilen; i++ ) {
			for ( j = 0, jlen = types.length; j < jlen; j++ ) {
				ensureArray(
					ensureMap( this.handlerNamesByKindAndType, kinds[ i ] ),
					types[ j ]
				).unshift( constructor.static.name );
			}
		}
	}
	if ( constructor.prototype instanceof ve.ui.FileTransferHandler ) {
		for ( i = 0, ilen = extensions.length; i < ilen; i++ ) {
			ensureArray( this.handlerNamesByExtension, extensions[ i ] ).unshift( constructor.static.name );
		}
	}
};

/**
 * Returns the primary command for for node.
 *
 * @param {ve.ui.DataTransferItem} item Data transfer item
 * @param {boolean} isPaste Handler being used for paste
 * @param {boolean} isPasteSpecial Handler being used for "paste special"
 * @return {string|undefined} Handler name, or undefined if not found
 */
ve.ui.DataTransferHandlerFactory.prototype.getHandlerNameForItem = function ( item, isPaste, isPasteSpecial ) {
	var i,
		name,
		constructor,
		names;

	// Fetch a given nested property, returning a zero-length array if
	// any component of the path is not present.
	// This is similar to ve.getProp, except with a `hasOwnProperty`
	// test to ensure we aren't fooled by __proto__ and friends.
	function fetch( obj /*, args...*/ ) {
		var i;
		for ( i = 1; i < arguments.length; i++ ) {
			if (
				typeof arguments[ i ] !== 'string' ||
				!Object.prototype.hasOwnProperty.call( obj, arguments[ i ] )
			) {
				return [];
			}
			obj = obj[ arguments[ i ] ];
		}
		return obj;
	}

	names = [].concat(
		// 1. Match by kind + type (e.g. 'file' + 'text/html')
		fetch( this.handlerNamesByKindAndType, item.kind, item.type ),
		// 2. Match by just type (e.g. 'image/jpeg')
		fetch( this.handlerNamesByType, item.type ),
		// 3. Match by file extension (e.g. 'csv')
		fetch( this.handlerNamesByExtension, item.getExtension() )
	);

	for ( i = 0; i < names.length; i++ ) {
		name = names[ i ];
		constructor = this.registry[ name ];

		if ( isPasteSpecial && !constructor.static.handlesPasteSpecial ) {
			continue;
		}

		if ( isPaste && !constructor.static.handlesPaste ) {
			continue;
		}

		if ( constructor.static.matchFunction && !constructor.static.matchFunction( item ) ) {
			continue;
		}

		return name;
	}

	// No matching handler
	return;
};

/* Initialization */

ve.ui.dataTransferHandlerFactory = new ve.ui.DataTransferHandlerFactory();
