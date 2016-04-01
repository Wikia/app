/*!
 * VisualEditor DataModel WikiaTransclusionModel class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

ve.dm.WikiaTransclusionModel = function VeDmWikiaTransclusionModel() {
	// Parent constructor
	ve.dm.WikiaTransclusionModel.super.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaTransclusionModel, ve.dm.MWTransclusionModel );

/* Methods */

/**
 * @inheritdoc
 */
ve.dm.WikiaTransclusionModel.prototype.fetchRequest = function ( titles, specs, queue ) {
	//if we want to make another request, we should update the requests array as well
	this.requests.push( this.fetchInfoboxParamsRequest( titles, specs, queue ) );

	return ve.init.target.constructor.static.apiRequest( {
		action: 'templateparameters',
		titles: titles.join( '|' )
	} )
	.done( this.fetchRequestDone.bind( this, specs ) )
	.always( this.fetchRequestAlways.bind( this, queue ) );
};

ve.dm.WikiaTransclusionModel.prototype.fetchInfoboxParamsRequest = function ( titles, specs, queue ) {
	return ve.init.target.constructor.static.apiRequest( {
		action: 'query',
		prop: 'infobox',
		titles: titles.join( '|' )
	} )
	.done( this.fetchInfoboxParamsRequestDone.bind( this, specs ) )
	.always( this.fetchRequestAlways.bind( this, queue ) );
};

/**
 * @inheritdoc
 */
ve.dm.WikiaTransclusionModel.prototype.fetchRequestDone = function ( specs, data ) {
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
 * @desc process the infobox params received from API. For all requested pages, if they contain infoboxes,
 * extend their param array with received infobox params.
 */
ve.dm.WikiaTransclusionModel.prototype.fetchInfoboxParamsRequestDone = function ( specs, data ) {
	var id, page, i, j, denormalizedData, source;

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

			for ( i = 0; i < page.infoboxes.length; i++ ) {
				page.infoboxes[i].sources = Object.keys( page.infoboxes[i].sourcelabels );

				for ( j = 0; j < page.infoboxes[i].sources.length; j++ ) {
					source = page.infoboxes[i].sources[j];

					specs[page.title].params[ source ] = { label: page.infoboxes[i].sourcelabels[source] };
					specs[page.title].paramOrder.push( page.infoboxes[i].sources[j] );
				}
			}
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
