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

ve.dm.WikiaTransclusionModel.prototype.fetchInfoboxParamsRequestDone = function ( specs, data ) {
	var id, page, i, j;

	if ( data && data.query && data.query.pages ) {
		for ( id in data.query.pages ) {
			page = data.query.pages[id];

			if ( !page.infoboxes ) {
				return;
			}

			page.title = this.denormalizeInfoboxTemplateTitle( page.title, data );

			if ( !specs[page.title] ) {
				specs[page.title] = {
					title: page.title,
					description: '',
					params: {},
					paramOrder: []
				};
			}

			for ( i = 0; i < page.infoboxes.length; i++ ) {
				for ( j = 0; j < page.infoboxes[i].sources.length; j++ ) {
					specs[page.title].params[ page.infoboxes[i].sources[j] ] = {};
					specs[page.title].paramOrder.push( page.infoboxes[i].sources[j] );
				}
			}
		}

		ve.extendObject( this.specCache, specs );
	}
};

ve.dm.WikiaTransclusionModel.prototype.setIsInfobox = function ( isInfobox ) {
	this.isInfobox = isInfobox;
};

/**
 * @desc The template names which contain _ are normalized in infobox API and the title from response contain spaces.
 * It's inconsistent with the template API. However, the response from infobox API contains field 'normalized'
 * where we can take the requested title from.
 */
ve.dm.WikiaTransclusionModel.prototype.denormalizeInfoboxTemplateTitle = function ( title, data ) {
	var k;

	if ( data.query.normalized ) {
		for ( k = 0; k < data.query.normalized.length; k++ ) {
			if (data.query.normalized[k].to === title ) {
				title = data.query.normalized[k].from;
			}
		}
	}

	return title;
};
