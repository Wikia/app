/*!
 * VisualEditor DataModel WikiaTemplateModel class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

ve.dm.WikiaTemplateModel = function VeDmWikiaTemplateModel( transclusion, target ) {
	// Parent constructor
	ve.dm.WikiaTemplateModel.super.call( this, transclusion, target );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaTemplateModel, ve.dm.MWTemplateModel );

/* Methods */

/**
 * Add all unused parameters, if any.
 *
 * @method
 */
ve.dm.WikiaTemplateModel.prototype.addUnusedParameters = function () {
	var i, len,
		spec = this.getSpec(),
		names = spec.getParameterNames();

	for ( i = 0, len = names.length; i < len; i++ ) {
		if ( !this.hasParameter( names[i] ) ) {
			this.addParameter( new ve.dm.MWParameterModel( this, names[i] ) );
		}
	}
};

/**
 * @inheritdoc
 */
ve.dm.WikiaTemplateModel.prototype.serialize = function () {
	var name,
		template = ve.extendObject(
			{}, this.originalData, { target: this.getTarget(), params: {} }
		),
		params = this.getParameters();

	if ( !template.originalParams ) {
		template.originalParams = this.originalData ? Object.keys( this.originalData.params ) : [];
	}

	for ( name in params ) {
		if ( name === '' ) {
			continue;
		}
		if ( params[name].getValue() === '' && template.originalParams.indexOf( name ) === -1 ) {
			continue;
		}
		template.params[params[name].getOriginalName()] = { wt: params[name].getValue() };
	}

	return { template: template };
};

/**
 * @inheritdoc
 */
ve.dm.WikiaTemplateModel.prototype.getWikitext = function () {
	var param,
		wikitext = this.getTarget().wt,
		params = this.getParameters(),
		originalParams = this.originalData ? Object.keys( this.originalData.params ) : [];

	for ( param in params ) {
		if ( param === '' ) {
			continue;
		}
		if ( params[param].getValue() === '' && originalParams.indexOf( param ) === -1 ) {
			continue;
		}
		wikitext += '|' + param + '=' +
			ve.dm.MWTransclusionNode.static.escapeParameter( params[param].getValue() );
	}

	return '{{' + wikitext + '}}';
};
