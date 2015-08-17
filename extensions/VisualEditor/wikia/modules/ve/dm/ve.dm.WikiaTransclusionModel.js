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
	return ve.init.target.constructor.static.apiRequest( {
		action: 'templateparameters',
		titles: titles.join( '|' )
	} )
		.done( this.fetchRequestDone.bind( this, specs ) )
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
			specs[page.title] = {
				title: data.pages[id].title,
				description: '',
				params: {},
				paramOrder: page.params
			};
			// Map parameters from flat array to collection where parameter name is the key and value is empty
			// because later it's extended with ve.dm.MWTemplateSpecModel.prototype.getDefaultParameterSpec
			for ( i = 0; i < page.params.length; i++ ) {
				specs[page.title].params[page.params[i]] = {};
			}
		}
		ve.extendObject( this.specCache, specs );
	}
};
