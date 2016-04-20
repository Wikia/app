/*!
 * VisualEditor DataModel WikiaInfoboxSpecModel class.
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
	this.params = {};
	this.paramOrder = [];
	this.groups = [];

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
	var key;

	if ( Array.isArray( data.paramOrder ) ) {
		this.paramOrder = data.paramOrder.slice();
	}
	if ( ve.isPlainObject( data.params ) ) {
		for ( key in data.params ) {
			// Pre-fill spec
			if ( !this.params[key] ) {
				this.params[key] = this.getDefaultParameterSpec( key );
			}
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
		target = this.template.getTarget(),
		templateNamespace = 10;

	if ( title ) {
		try {
			// Normalize and remove namespace prefix if in the Template: namespace
			titleObj = new mw.Title( title );
			title = titleObj.getRelativeText( templateNamespace );
		} catch ( e ) {
			ve.track( 'wikia', {
				action: ve.track.actions.ERROR,
				label: 'infobox-spec-invalid-title'
			} );
		}
	}

	return title || target.wt;
};

/**
 * Get parameter order.
 *
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
 * @returns {boolean} false
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterSuggested = function () {
	return false;
};

/**
 * Get a parameter label. For now - the same as name.
 *
 * @param {string} name Parameter name
 * @returns {string} Parameter label
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterLabel = function ( name ) {
	return this.params[name].label || name;
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
 * None of infobox parameters is required.
 *
 * @returns {boolean} false- parameter is not required
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterRequired = function () {
	return false;
};

/**
 * Check if parameter is deprecated.
 *
 * @returns {boolean} Parameter is deprecated
 */
ve.dm.WikiaInfoboxSpecModel.prototype.isParameterDeprecated = function () {
	return false;
};

/**
 * Infobox parameter description are not used so far.
 *
 * @returns {null} Empty parameter description
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterDescription = function () {
	return null;
};

/**
 * Infobox parameter auto values are not used so far.
 *
 * @returns {string} ''
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterAutoValue = function () {
	return '';
};

/**
 * Infobox parameter deprecation description for now is always empty.
 *
 * @returns {string} ''
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterDeprecationDescription = function () {
	return '';
};

/**
 * Get the parameter name.
 *
 * Infobox parameter cannot be an alias of another, so the output will be the same as the input.
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
 * @returns {string[]} Infobox parameter names dont't have aliases
 */
ve.dm.WikiaInfoboxSpecModel.prototype.getParameterAliases = function () {
	return [];
};
