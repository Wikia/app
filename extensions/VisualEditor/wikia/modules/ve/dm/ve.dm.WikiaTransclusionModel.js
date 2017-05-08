/*!
 * VisualEditor DataModel WikiaTransclusionModel class.
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function ( ve ) {

	ve.dm.WikiaTransclusionModel = function VeDmWikiaTransclusionModel() {
		// Parent constructor
		ve.dm.WikiaTransclusionModel.super.call( this );
	};

	/* Inheritance */

	OO.inheritClass( ve.dm.WikiaTransclusionModel, ve.dm.MWTransclusionModel );

	/* Methods */

	ve.dm.WikiaTransclusionModel.prototype.pushFetchRequests = function ( titles, specs, queue ) {
		var templateParamsRequest = this.fetchTemplateParamsRequest( titles, specs, queue ),
			infoboxParamsRequest = this.fetchInfoboxParamsRequest( titles, specs, queue );

		$.when( templateParamsRequest, infoboxParamsRequest )
			.then( function ( templateParamsResponse, infoboxParamsResponse ) {
				if ( templateParamsResponse[1] === 'success' ) {
					this.templateParamsRequestDone( specs, templateParamsResponse[0] );
				}
				if ( infoboxParamsResponse[1] === 'success' ) {
					this.infoboxParamsRequestDone( specs, infoboxParamsResponse[0] );
				}
			}.bind( this ) )
			.always( function ( queue ) {
				this.process( queue );
			}.bind( this, queue ) );

		this.requests.push( templateParamsRequest );
		this.requests.push( infoboxParamsRequest );
	};

	/**
	 * @inheritdoc
	 */
	ve.dm.WikiaTransclusionModel.prototype.fetchTemplateParamsRequest = function ( titles ) {
		return ve.init.target.constructor.static.apiRequest( {
			action: 'templateparameters',
			titles: titles.join( '|' )
		} );
	};

	ve.dm.WikiaTransclusionModel.prototype.fetchInfoboxParamsRequest = function ( titles ) {
		return ve.init.target.constructor.static.apiRequest( {
			action: 'query',
			prop: 'infobox',
			titles: titles.join( '|' )
		} );
	};

	/**
	 * @inheritdoc
	 */
	ve.dm.WikiaTransclusionModel.prototype.templateParamsRequestDone = function ( originalSpecs, data ) {
		var page, i, id, specs = ve.extendObject( {}, originalSpecs );
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
	ve.dm.WikiaTransclusionModel.prototype.infoboxParamsRequestDone = function ( originalSpecs, data ) {
		var id, page, denormalizedData, specs = ve.extendObject( {}, originalSpecs );

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

				/* jshint -W083 */
				page.infoboxes.forEach( function ( infobox ) {
					infobox.metadata.forEach( function ( node ) {
						parseInfoboxMetadata( node, specs[page.title] );
					} );
				} );
				/* jshint +W083 */
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
