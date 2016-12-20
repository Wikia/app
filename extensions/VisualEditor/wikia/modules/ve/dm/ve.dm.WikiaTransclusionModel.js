/*!
 * VisualEditor DataModel WikiaTransclusionModel class.
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function ( ve ) {

	ve.dm.WikiaTransclusionModel = function VeDmWikiaTransclusionModel() {
		// Parent constructor
		ve.dm.WikiaTransclusionModel.super.call( this );
		this.parallelRequests = [];
	};

	/* Inheritance */

	OO.inheritClass( ve.dm.WikiaTransclusionModel, ve.dm.MWTransclusionModel );

	/* Methods */

	/**
	 * This is called at the end of ve.dm.MWTransclusionModel.prototype.fetch() and added to its list of requests.
	 * The parent's logic is to have a list of independent requests which don't depend on each other.
	 * Here are two parallel requests and we need to know when they both are finished to combine the results.
	 * Therefore, fetchRequest() method and the callbacks it uses are overriden to have a separate list of requests.
	 * The list itself is needed for abortRequests() method.
	 */
	ve.dm.WikiaTransclusionModel.prototype.fetchRequest = function ( titles, specs, queue ) {
		var templateParamsRequest = ve.init.target.constructor.static.apiRequest( {
				action: 'templateparameters',
				titles: titles.join( '|' )
			} )
				.done( this.templateParamsRequestDone.bind( this, specs ) )
				.always( this.parallelRequestAlways.bind( this ) ),
			infoboxParamsRequest = ve.init.target.constructor.static.apiRequest( {
				action: 'query',
				prop: 'infobox',
				titles: titles.join( '|' )
			} )
				.done( this.infoboxParamsRequestDone.bind( this, specs ) )
				.always( this.parallelRequestAlways.bind( this ) );

		this.parallelRequests.push( templateParamsRequest );
		this.parallelRequests.push( infoboxParamsRequest );

		return $.when( templateParamsRequest, infoboxParamsRequest )
			.always( function () {
				this.process( queue );
			}.bind( this, queue ) );
	};

	/**
	 * @param {Object} data
	 * @param {string} textStatus
	 * @param { jQuery.jqXHR } jqXHR
	 */
	ve.dm.WikiaTransclusionModel.prototype.parallelRequestAlways = function ( data, textStatus, jqXHR ) {
		// Prune completed request
		var index = ve.indexOf( jqXHR, this.parallelRequests );
		if ( index !== -1 ) {
			this.parallelRequests.splice( index, 1 );
		}
	};

	/**
	 * Abort any pending requests.
	 */
	ve.dm.WikiaTransclusionModel.prototype.abortRequests = function () {
		var i, len;

		for ( i = 0, len = this.parallelRequests.length; i < len; i++ ) {
			this.parallelRequests[i].abort();
		}
		this.parallelRequests.length = 0;
	};

	/**
	 * @inheritdoc
	 */
	ve.dm.WikiaTransclusionModel.prototype.templateParamsRequestDone = function ( specs, data ) {
		var page, i, id;
		if ( data && data.pages ) {
			for ( id in data.pages ) {
				page = data.pages[id];
				if ( !specs[page.title] ) {
					specs[page.title] = {
						title: data.pages[id].title,
						description: '',
						params: {},
						paramOrder: page.params
					};
				}
				// Map parameters from flat array to collection where parameter name is the key and value is empty
				// because later it's extended with ve.dm.MWTemplateSpecModel.prototype.getDefaultParameterSpec
				for ( i = 0; i < page.params.length; i++ ) {
					specs[page.title].params[page.params[i]] = {};
				}
			}
			ve.extendObject( this.specCache, specs );
		}
	};

	/**
	 * @param {Object} specs
	 * @param {Object} node
	 * @param {string} sourceName
	 * @param {Object} sourceMetadata
	 */
	function addInfoboxSourceParam( specs, node, sourceName, sourceMetadata ) {
		// Single source can be used in multiple nodes.
		// We override its spec with every usage, so only the last one stays.
		// `data` node is the most generic one and doesn't give us any value.
		// Let's ignore it if the source has already a meaningful type.
		if ( specs.params[sourceName] && specs.params[sourceName].type !== 'data' ) {
			return;
		}

		specs.params[sourceName] = {
			label: sourceMetadata.label
		};

		if ( sourceMetadata.primary === true ) {
			specs.params[sourceName].type = node.type;
		}

		specs.paramOrder.push( sourceName );
	}

	/**
	 * @param {Object} node
	 * @param {Object} specs
	 */
	function parseInfoboxMetadata( node, specs ) {
		if ( node.type === 'group' ) {
			node.metadata.forEach( function ( childNode ) {
				parseInfoboxMetadata( childNode, specs );
			} );
		} else {
			Object.keys( node.sources ).map( function ( sourceName ) {
				var sourceMetadata = node.sources[sourceName];
				addInfoboxSourceParam( specs, node, sourceName, sourceMetadata );
			} );
		}
	}

	/**
	 * @desc process the infobox params received from API. For all requested pages, if they contain infoboxes,
	 * extend their param array with received infobox params.
	 */
	ve.dm.WikiaTransclusionModel.prototype.infoboxParamsRequestDone = function ( specs, data ) {
		var id, page, denormalizedData;

		if ( data && Object.keys( data.query ).length && Object.keys( data.query.pages ).length ) {
			denormalizedData = this.denormalizeInfoboxTemplateTitles( data );

			for ( id in denormalizedData ) {
				page = denormalizedData[id];

				if ( !page.infoboxes ) {
					return;
				}

				if ( !specs[page.title] ) {
					specs[page.title] = {
						title: page.title,
						description: '',
						params: {},
						paramOrder: []
					};
				}

				page.infoboxes.forEach( function ( infobox ) {
					infobox.metadata.forEach( function ( node ) {
						parseInfoboxMetadata( node, specs[page.title] );
					} );
				} );
			}

			ve.extendObject( this.specCache, specs );
		}
	};

	/**
	 * @desc The template names which contain _ are normalized in infobox API and the title from response contain spaces.
	 * It's inconsistent with the template API. However, the response from infobox API contains field 'normalized'
	 * where we can take the requested title from.
	 *
	 * @param data from infobox params API
	 */
	ve.dm.WikiaTransclusionModel.prototype.denormalizeInfoboxTemplateTitles = function ( data ) {
		var i, id, title, pages = data.query.pages;

		if ( data.query.normalized ) {
			for ( i = 0; i < data.query.normalized.length; i++ ) {
				title = data.query.normalized[i];

				for ( id in pages ) {
					if ( title.to === pages[id].title ) {
						pages[id].title = title.from;
						break;
					}
				}
			}
		}

		return pages;
	};

	/**
	 * @desc set on this model that element it takes care about is an infobox
	 * @param isInfobox boolean
	 */
	ve.dm.WikiaTransclusionModel.prototype.setIsInfobox = function ( isInfobox ) {
		this.isInfobox = isInfobox;
	};

	/**
	 * @desc get info if this transclusion model is responsible for an infobox
	 */
	ve.dm.WikiaTransclusionModel.prototype.getIsInfobox = function () {
		return this.isInfobox;
	};
} )( ve );
