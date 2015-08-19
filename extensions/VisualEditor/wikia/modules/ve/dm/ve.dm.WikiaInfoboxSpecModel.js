/*!
 * VisualEditor DataModel WikiaInfoboxSpecModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki template specification.
 *
 * @class
 *
 * @constructor
 * @param template TemplateModel
 */
ve.dm.WikiaInfoboxSpecModel = function VeDmWikiaInfoboxSpecModel( template ) {
	// Properties
	this.template = template;
	this.params = {
		Title: {
			name: 'Title',
			type: 'data'
		},
		Image: {
			name: 'Image',
			type: 'image'
		},
		Height: {
			name: 'Height',
			parent: 'Size',
			type: 'data'
		},
		Weight: {
			name: 'Weight',
			parent: 'Size',
			type: 'data'
		},
		date_of_birth: {
			name: 'date_of_birth',
			type: 'data'
		},
		param_from_spec: {
			name: 'param_from_spec',
			type: 'data'
		}
	};
	this.paramOrder = [];
	this.groups = [
		{
			label: 'Date',
			params: ['year', 'month', 'day']
		}
	];

	// Initialization
	this.fill();
};

/* Methods */

/**
 * Extend with template spec data.
 *
 * Template spec data is available from the TemplateData extension's API. Extension is passive so
 * any filled in values are not overwritten unless new values are available. This prevents changes
 * in the API or fill methods from causing issues.
 *
 * @param {Object} data Template spec data
 * @param {string} [data.description] Template description
 * @param {string[]} [data.paramOrder] Canonically ordered parameter names
 * @param {Object} [data.params] Template param specs keyed by param name
 * @param {string[][]} [data.groups] Lists of param groups
 */
ve.dm.WikiaInfoboxSpecModel.prototype.extend = function ( data ) {
	var key, param;

	if ( Array.isArray( data.paramOrder ) ) {
		this.paramOrder = data.paramOrder.slice();
	}
	if ( ve.isPlainObject( data.params ) ) {
		for ( key in data.params ) {
			// Pre-fill spec
			if ( !this.params[key] ) {
				this.params[key] = this.getDefaultParameterSpec( key );
			}
			param = this.params[key];
			// Extend existing spec
			ve.extendObject( true, this.params[key], data.params[key] );
		}
	}
	this.groups = data.groups;
};

/**
 * Fill from template.
 *
 * Filling is passive, so existing information is never overwitten. The spec should be re-filled
 * after a parameter is added to ensure it's still complete, and this is safe because existing data
 * is never overwritten.
 */
ve.dm.WikiaInfoboxSpecModel.prototype.fill = function () {
	var key;

	for ( key in this.template.getParameters() ) {
		if ( key && !this.params[key] ) {
			this.params[key] = this.getDefaultParameterSpec( key );
		}
	}
};

/**
 * Get the default spec for a parameter.
 *
 * @param {string} name Parameter name
 * @returns {Object} Parameter spec
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getDefaultParameterSpec = function ( name ) {
	return {
		label: name,
		default: '',
		type: 'data',
		name: name,
		required: false,
		deprecated: false
	};
};

/**
 * Get template label.
 *
 * @returns {string} Template label
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getLabel = function () {
	var titleObj,
		title = this.template.getTitle(),
		target = this.template.getTarget();

	if ( title ) {
		try {
			// Normalize and remove namespace prefix if in the Template: namespace
			titleObj = new mw.Title( title );
			title = titleObj.getRelativeText( 10 );
		} catch ( e ) { }
	}

	return title || target.wt;
};

/**
 * Get parameter order.
 *
 * @method
 * @returns {string[]} Canonically ordered parameter names
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterOrder = function () {
	return this.paramOrder.slice();
};

/**
 * Check if a parameter name is known.
 *
 * @param {string} name Parameter name
 * @returns {boolean} Parameter name is known
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterKnown = function ( name ) {
	return this.params[name] !== undefined;
};

/**
 * There is no such a thing like suggested infobox param.
 *
 * @param {string} name Parameter name
 * @returns {boolean} false
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterSuggested = function () {
	return false;
};

/**
 * Get a parameter label.
 *
 * @param {string} name Parameter name
 * @param {string} [lang] Language to get label in
 * @returns {string} Parameter label
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterLabel = function ( name, lang ) {
	var value = this.params[name].label || name;
	return ve.isPlainObject( value ) ? OO.ui.getLocalValue( value, lang ) : value;
};

/**
 * Get a parameter default value.
 *
 * @param {string} name Parameter name
 * @returns {string} Default parameter value
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterDefaultValue = function ( name ) {
	return this.params[name]['default'] || '';
};

/**
 * Get a parameter type.
 *
 * @param {string} name Parameter name
 * @returns {string} Parameter type
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterType = function ( name ) {
	return this.params[name].type;
};

/**
 * Check if parameter is required.
 *
 * @param {string} name Parameter name
 * @returns {boolean} Parameter is required
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterRequired = function () {
	return false;
};

/**
 * Get parameter groups.
 *
 * @returns {Object[]} Lists of parameter group descriptors
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterGroups = function () {
	return this.groups;
};

/**
 * Check if parameter is deprecated.
 *
 * @param {string} name Parameter name
 * @returns {boolean} Parameter is deprecated
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterDeprecated = function () {
	return false;
};

/**
 * Get a parameter description.
 *
 * @param {string} name Parameter name
 * @param {string} [lang] Language to get description
 * @returns {string|null} Parameter description
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterDescription = function ( name, lang ) {
	var value = this.params[name].description;
	return ve.isPlainObject( value ) ? OO.ui.getLocalValue( value, lang ) : value;
};

/**
 * Get a parameter auto value.
 *
 * @param {string} name Parameter name
 * @returns {string} Auto-value for the parameter
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterAutoValue = function ( name ) {
	return this.params[name].autovalue;
};

/**
 * Get parameter deprecation description.
 *
 * @param {string} name Parameter name
 * @returns {string} Explaining of why parameter is deprecated, empty if parameter is either not
 *   deprecated or no description has been specified
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterDeprecationDescription = function ( name ) {
	return typeof this.params[name].deprecated === 'string' ?
		this.params[name].deprecated : '';
};

/**
 * Get the parameter name, resolving an alias.
 *
 * If a parameter is not an alias of another, the output will be the same as the input.
 *
 * @param {string} name Parameter alias
 * @returns {string} Parameter name
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterName = function ( name ) {
	return this.params[name].name;
};

/**
 * Get all primary parameter names.
 *
 * @returns {string[]} Parameter names
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterNames = function () {
	var name,
		names = [];

	for ( name in this.params ) {
		if ( this.params[name].name === name ) {
			names.push( name );
		}
	}

	return names;
};

/**
 * Infobox params will not have a paramater aliases.
 * Function implemented to be compatibile with call to this.spec.getParameterAliases
 * in ve.dm.MWTemplateModel.hasParameter
 *
 * @param {string} name Parameter name
 * @returns {string[]} Alternate parameter names
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterAliases = function () {
	return [];
};
