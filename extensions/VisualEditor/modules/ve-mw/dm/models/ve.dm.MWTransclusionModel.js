/*!
 * VisualEditor DataModel MWTransclusionModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

( function () {
var hasOwn = Object.hasOwnProperty,
	specCache = {};

/**
 * MediaWiki transclusion model.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 */
ve.dm.MWTransclusionModel = function VeDmMWTransclusionModel() {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.parts = [];
	this.uid = 0;
	this.requests = [];
	this.queue = [];
};

/* Inheritance */

OO.mixinClass( ve.dm.MWTransclusionModel, OO.EventEmitter );

/* Events */

/**
 * @event replace
 * @param {ve.dm.MWTransclusionPartModel|null} removed Removed part
 * @param {ve.dm.MWTransclusionPartModel|null} added Added part
 */

/**
 * @event change
 */

/* Methods */

/**
 * Insert transclusion at the end of a surface fragment.
 *
 * @param {ve.dm.SurfaceFragment} surfaceModel Surface fragment to insert at
 */
ve.dm.MWTransclusionModel.prototype.insertTransclusionNode = function ( surfaceFragment ) {
	surfaceFragment
		.insertContent( [
			{
				'type': 'mwTransclusionInline',
				'attributes': {
					'mw': this.getPlainObject()
				}
			},
			{ 'type': '/mwTransclusionInline' }
		] );
};

/**
 * Update transclusion node in a document.
 *
 * @param {ve.dm.Surface} surfaceModel Surface model of main document
 * @param {ve.dm.MWTransclusionNode} node Transclusion node to update
 */
ve.dm.MWTransclusionModel.prototype.updateTransclusionNode = function ( surfaceModel, node ) {
	var obj = this.getPlainObject();

	if ( obj !== null ) {
		surfaceModel.getFragment( node.getOuterRange(), true )
			.changeAttributes( { 'mw': obj } );
	} else {
		surfaceModel.getFragment( node.getOuterRange(), true )
			.removeContent();
	}
};

/**
 * Load from transclusion data, and fetch spec from server.
 *
 * @param {Object} data Transclusion data
 * @returns {jQuery.Promise} Promise, resolved when spec is loaded
 */
ve.dm.MWTransclusionModel.prototype.load = function ( data ) {
	var i, len, part, deferred,
		promises = [];

	// Convert single part format to multi-part format
	// Parsoid doesn't use this format any more, but we accept it for backwards compatibility
	if ( data.params && data.target ) {
		data = { 'parts': [ { 'template': data } ] };
	}

	if ( ve.isArray( data.parts ) ) {
		for ( i = 0, len = data.parts.length; i < len; i++ ) {
			part = data.parts[i];
			if ( part.template ) {
				deferred = $.Deferred();
				promises.push( deferred.promise() );
				this.queue.push( {
					'add': ve.dm.MWTemplateModel.newFromData( this, part.template ),
					'deferred': deferred
				} );
			} else if ( typeof part === 'string' ) {
				deferred = $.Deferred();
				promises.push( deferred.promise() );
				this.queue.push( {
					'add': new ve.dm.MWTransclusionContentModel( this, part, 'data' ),
					'deferred': deferred
				} );
			}
		}
		setTimeout( ve.bind( this.fetch, this ) );
	}

	return $.when.apply( $, promises );
};

/**
 * Process one or more queue items.
 *
 * @param {Object[]} queue List of objects containing parts to add and optionally indexes to add
 *  them at, if no index is given parts will be added at the end
 * @fires replace For each item added
 * @fires change
 */
ve.dm.MWTransclusionModel.prototype.process = function ( queue ) {
	var i, len, item, title, index, remove, existing;

	for ( i = 0, len = queue.length; i < len; i++ ) {
		remove = 0;
		item = queue[i];

		if ( item.add instanceof ve.dm.MWTemplateModel ) {
			title = item.add.getTitle();
			if ( hasOwn.call( specCache, title ) && specCache[title] ) {
				item.add.getSpec().extend( specCache[title] );
			}
		}

		// Use specified index
		index = item.index;
		// Auto-remove if already existing, preserving index
		existing = ve.indexOf( item.add, this.parts );
		if ( existing !== -1 ) {
			this.removePart( item.add );
			if ( index && existing + 1 < index ) {
				index--;
			}
		}
		// Derive index from removal if given
		if ( index === undefined && item.remove ) {
			index = ve.indexOf( item.remove, this.parts );
			if ( index !== -1 ) {
				remove = 1;
			}
		}
		// Use last index as a last resort
		if ( index === undefined || index === -1 ) {
			index = this.parts.length;
		}

		this.parts.splice( index, remove, item.add );
		if ( item.add ) {
			item.add.connect( this, { 'change': [ 'emit', 'change' ] } );
		}
		if ( item.remove ) {
			item.remove.disconnect( this );
		}
		this.emit( 'replace', item.remove || null, item.add );

		// Resolve promises
		if ( item.deferred ) {
			item.deferred.resolve();
		}
	}
	this.emit( 'change' );
};

/** */
ve.dm.MWTransclusionModel.prototype.fetch = function () {
	if ( !this.queue.length ) {
		return;
	}

	var i, len, item, title, request,
		titles = [],
		specs = {},
		queue = this.queue.slice();

	// Clear shared queue for future calls
	this.queue.length = 0;

	// Get unique list of template titles that aren't already loaded
	for ( i = 0, len = queue.length; i < len; i++ ) {
		item = queue[i];
		if ( item.add instanceof ve.dm.MWTemplateModel ) {
			title = item.add.getTitle();
			if (
				// Skip titles that don't have a resolvable href
				title &&
				// Skip titles outside the template namespace
				title.charAt( 0 ) !== ':' &&
				// Skip already cached data
				!hasOwn.call( specCache, title ) &&
				// Skip duplicate titles in the same batch
				ve.indexOf( title, titles ) === -1
			) {
				titles.push( title );
			}
		}
	}

	// Bypass server for empty lists
	if ( !titles.length ) {
		setTimeout( ve.bind( this.process, this, queue ) );
		return;
	}

	// Request template specs from server
	// TODO: Wikia (ve-sprint-25): Re-implement without modifying core class
	request = ve.init.target.constructor.static.apiRequest( {
		'action': 'templateparameters',
		'titles': titles.join( '|' )
	} )
		.done( function ( data ) {
			var page, i, id;
			if ( data && data.pages ) {
				for ( id in data.pages ) {
					page = data.pages[id];
					specs[page.title] = {
						'title': data.pages[id].title,
						'description': '',
						'params': {},
						'paramOrder': page.params
					};
					// Map parameters from flat array to collection where parameter name is the key and value is empty
					// because later it's extended with ve.dm.MWTemplateSpecModel.prototype.getDefaultParameterSpec
					for ( i = 0; i < page.params.length; i++ ) {
						specs[page.title].params[page.params[i]] = {};
					}
				}
				ve.extendObject( specCache, specs );
			}
		} )
		.always( ve.bind( function () {
			// Prune completed request
			var index = ve.indexOf( request, this.requests );
			if ( index !== -1 ) {
				this.requests.splice( index, 1 );
			}
			// Actually add queued items
			this.process( queue );
		}, this ) );

	this.requests.push( request );
};

/**
 * Abort any pending requests.
 */
ve.dm.MWTransclusionModel.prototype.abortRequests = function () {
	var i, len;

	for ( i = 0, len = this.requests.length; i < len; i++ ) {
		this.requests[i].abort();
	}
	this.requests.length = 0;
};

/**
 * Get plain object representation of template transclusion.
 *
 * @returns {Object|null} Plain object representation, or null if empty
 */
ve.dm.MWTransclusionModel.prototype.getPlainObject = function () {
	var i, len, part, serialization,
		obj = { 'parts': [] };

	for ( i = 0, len = this.parts.length; i < len; i++ ) {
		part = this.parts[i];
		serialization = part.serialize();
		if ( serialization !== undefined ) {
			obj.parts.push( serialization );
		}
	}

	if ( obj.parts.length === 0 ) {
		return null;
	}

	return obj;
};

/**
 * Get the wikitext for this transclusion.
 *
 * @returns {string} Wikitext like `{{foo|1=bar|baz=quux}}`
 */
ve.dm.MWTransclusionModel.prototype.getWikitext = function () {
	var i, len,
		wikitext = '';

	for ( i = 0, len = this.parts.length; i < len; i++ ) {
		wikitext += this.parts[i].getWikitext();
	}

	return wikitext;
};

/**
 * Get a unique ID for a part in the transclusion.
 *
 * This is used to give parts unique IDs, and returns a different value each time it's called.
 *
 * @returns {number} Unique ID
 */
ve.dm.MWTransclusionModel.prototype.getUniquePartId = function () {
	return this.uid++;
};

/**
 * Replace part.
 *
 * Replace asynchonously.
 *
 * @param {ve.dm.MWTransclusionPartModel} remove Part to remove
 * @param {ve.dm.MWTransclusionPartModel} add Part to add
 * @throws {Error} If part to remove is not valid
 * @throws {Error} If part to add is not valid
 * @returns {jQuery.Promise} Promise, resolved when part is added
 */
ve.dm.MWTransclusionModel.prototype.replacePart = function ( remove, add ) {
	var deferred = $.Deferred();
	if (
		!( remove instanceof ve.dm.MWTransclusionPartModel ) ||
		!( add instanceof ve.dm.MWTransclusionPartModel )
	) {
		throw new Error( 'Invalid transclusion part' );
	}
	this.queue.push( { 'remove': remove, 'add': add, 'deferred': deferred } );

	// Fetch on next yield to process items in the queue together, subsequent calls to fetch will
	// have no effect because the queue will be clear
	setTimeout( ve.bind( this.fetch, this ) );

	return deferred.promise();
};

/**
 * Add part.
 *
 * Added asynchronously, but order is preserved.
 *
 * @param {ve.dm.MWTransclusionPartModel} part Part to add
 * @param {number} [index] Specific index to add content at, defaults to the end
 * @throws {Error} If part is not valid
 * @returns {jQuery.Promise} Promise, resolved when part is added
 */
ve.dm.MWTransclusionModel.prototype.addPart = function ( part, index ) {
	var deferred = $.Deferred();
	if ( !( part instanceof ve.dm.MWTransclusionPartModel ) ) {
		throw new Error( 'Invalid transclusion part' );
	}
	this.queue.push( { 'add': part, 'index': index, 'deferred': deferred } );

	// Fetch on next yield to process items in the queue together, subsequent calls to fetch will
	// have no effect because the queue will be clear
	setTimeout( ve.bind( this.fetch, this ) );

	return deferred.promise();
};

/**
 * Remove a part.
 *
 * @param {ve.dm.MWTransclusionPartModel} part Part to remove
 * @fires replace
 */
ve.dm.MWTransclusionModel.prototype.removePart = function ( part ) {
	var index = ve.indexOf( part, this.parts );
	if ( index !== -1 ) {
		this.parts.splice( index, 1 );
		part.disconnect( this );
		this.emit( 'replace', part, null );
	}
};

/**
 * Get all parts.
 *
 * @returns {ve.dm.MWTransclusionPartModel[]} Parts in transclusion
 */
ve.dm.MWTransclusionModel.prototype.getParts = function () {
	return this.parts;
};

/**
 * Get part by its ID.
 *
 * Matching is performed against the first section of the `id`, delimited by a '/'.
 *
 * @param {string} id Part ID
 * @returns {ve.dm.MWTransclusionPartModel|null} Part with matching ID, if found
 */
ve.dm.MWTransclusionModel.prototype.getPartFromId = function ( id ) {
	var i, len,
		// For ids from ve.dm.MWParameterModel, compare against the part id
		// of the parameter instead of the entire model id (e.g. "part_1" instead of "part_1/foo").
		partId = id.split( '/' )[0];

	for ( i = 0, len = this.parts.length; i < len; i++ ) {
		if ( this.parts[i].getId() === partId ) {
			return this.parts[i];
		}
	}
	return null;
};

/**
 * Get the index of a part or parameter.
 *
 * Indexes are linear depth-first addresses in the transclusion tree.
 *
 * @param {ve.dm.MWTransclusionPartModel|ve.dm.MWParameterModel} model Part or parameter
 * @returns {number} Page index of model
 */
ve.dm.MWTransclusionModel.prototype.getIndex = function ( model ) {
	var i, iLen, j, jLen, part, names,
		parts = this.parts,
		index = 0;

	for ( i = 0, iLen = parts.length; i < iLen; i++ ) {
		part = parts[i];
		if ( part === model ) {
			return index;
		}
		index++;
		if ( part instanceof ve.dm.MWTemplateModel ) {
			names = part.getParameterNames();
			for ( j = 0, jLen = names.length; j < jLen; j++ ) {
				if ( part.getParameter( names[j] ) === model ) {
					return index;
				}
				index++;
			}
		}
	}
	return -1;
};

}() );
