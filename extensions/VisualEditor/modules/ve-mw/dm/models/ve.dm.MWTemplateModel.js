/*!
 * VisualEditor DataModel MWTemplateModel class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw*/

/**
 * MediaWiki template model.
 *
 * @class
 * @extends ve.dm.MWTransclusionPartModel
 *
 * @constructor
 * @param {ve.dm.MWTransclusionModel} transclusion Transclusion
 * @param {Object} target Template target
 * @param {string} target.wt Original wikitext of target
 * @param {string} [target.href] Hypertext reference to target
 * @param {string} [origin] Origin of part, e.g. 'data' or 'user'
 */
ve.dm.MWTemplateModel = function VeDmMWTemplateModel( transclusion, target, origin ) {
	// Parent constructor
	ve.dm.MWTransclusionPartModel.call( this, transclusion );

	// Properties
	this.target = target;
	this.origin = origin;
	this.title = ( target.href && target.href.replace( /^(\.\.?\/)*/, '' ) ) || null;
	this.sequence = null;
	this.params = {};
	this.spec = new ve.dm.MWTemplateSpecModel( this );
	this.originalData = null;
};

/* Inheritance */

ve.inheritClass( ve.dm.MWTemplateModel, ve.dm.MWTransclusionPartModel );

/* Events */

/**
 * @event add
 * @param {ve.dm.MWTemplateParameterModel} param Added param
 */

/**
 * @event remove
 * @param {ve.dm.MWTemplateParameterModel} param Removed param
 */

/* Static Methods */

/**
 * Create from data.
 *
 * Data is in the format provided by Parsoid.
 *
 * @param {ve.dm.MWTransclusionModel} transclusion Transclusion template is in
 * @param {Object} data Template data
 * @returns {ve.dm.MWTemplateModel} New template model
 */
ve.dm.MWTemplateModel.newFromData = function ( transclusion, data ) {
	var key,
		template = new ve.dm.MWTemplateModel( transclusion, data.target, 'data' );

	for ( key in data.params ) {
		template.addParameter(
			new ve.dm.MWTemplateParameterModel( template, key, data.params[key].wt, 'data' )
		);
	}

	template.setOriginalData( data );

	return template;
};

/**
 * Create from name.
 *
 * Name is equivalent to what would be entered between double brackets, defaulting to the Template
 * namespace, using a leading colon to access other namespaces.
 *
 * @param {ve.dm.MWTransclusionModel} transclusion Transclusion template is in
 * @param {string} name Template name
 * @returns {ve.dm.MWTemplateModel} New template model
 */
ve.dm.MWTemplateModel.newFromName = function ( transclusion, name ) {
	var href = name;

	if ( href.charAt( 0 ) !== ':' ) {
		href = mw.config.get( 'wgFormattedNamespaces' )[10] + ':' + href;
	}
	href = new mw.Title( href ).getPrefixedText();

	return new ve.dm.MWTemplateModel( transclusion, { 'href': href, 'wt': name }, 'user' );
};

/* Methods */

/**
 * Get template target.
 *
 * @method
 * @returns {Object} Template target
 */
ve.dm.MWTemplateModel.prototype.getTarget = function () {
	return this.target;
};

/**
 * Get template origin, e.g. 'user' or 'data'.
 *
 * @returns {string} Origin
 */
ve.dm.MWTemplateModel.prototype.getOrigin = function () {
	return this.origin;
};

/**
 * Get template title.
 *
 * @method
 * @returns {string|null} Template title, if available
 */
ve.dm.MWTemplateModel.prototype.getTitle = function () {
	return this.title;
};

/**
 * Get template specification.
 *
 * @method
 * @returns {ve.dm.MWTemplateSpecModel} Template specification
 */
ve.dm.MWTemplateModel.prototype.getSpec = function () {
	return this.spec;
};

/**
 * Get all params.
 *
 * @method
 * @returns {Object.<string,ve.dm.MWTemplateParameterModel>} Parameters keyed by name
 */
ve.dm.MWTemplateModel.prototype.getParameters = function () {
	return this.params;
};

/**
 * Get a parameter.
 *
 * @method
 * @param {string} name Parameter name
 * @returns {ve.dm.MWTemplateParameterModel} Parameter
 */
ve.dm.MWTemplateModel.prototype.getParameter = function ( name ) {
	return this.params[name];
};

/**
 * Check if a parameter exists.
 *
 * @method
 * @param {string} name Parameter name
 * @returns {boolean} Parameter exists
 */
ve.dm.MWTemplateModel.prototype.hasParameter = function ( name ) {
	var i, len, primaryName, names;

	// Check if name (which may be an alias) is present in the template
	if ( this.params[name] ) {
		return true;
	}

	// Check if the name is known at all
	if ( this.spec.isParameterKnown( name ) ) {
		primaryName = this.spec.getParameterName( name );
		// Check for primary name (may be the same as name)
		if ( this.params[primaryName] ) {
			return true;
		}
		// Check for other aliases (may include name)
		names = this.spec.getParameterAliases( primaryName );
		for ( i = 0, len = names.length; i < len; i++ ) {
			if ( this.params[names[i]] ) {
				return true;
			}
		}
	}

	return false;
};

/**
 * Get ordered list of parameter names.
 *
 * Numeric names, whether strings or real numbers, are placed at the begining, followed by
 * alphabetically sorted names.
 *
 * @method
 * @returns {string[]} List of parameter names
 */
ve.dm.MWTemplateModel.prototype.getParameterNames = function () {
	if ( !this.sequence ) {
		this.sequence = ve.getObjectKeys( this.params ).sort( function ( a, b ) {
			var aIsNaN = isNaN( a ),
				bIsNaN = isNaN( b );
			if ( aIsNaN && bIsNaN ) {
				// Two strings
				return a < b ? -1 : a === b ? 0 : 1;
			}
			if ( aIsNaN ) {
				// A is a string
				return 1;
			}
			if ( bIsNaN ) {
				// B is a string
				return -1;
			}
			// Two numbers
			return a - b;
		} );
	}
	return this.sequence;
};

/**
 * Add a parameter to template.
 *
 * @method
 * @param {ve.dm.MWTemplateParameterModel} param Parameter to add
 * @emits add
 */
ve.dm.MWTemplateModel.prototype.addParameter = function ( param ) {
	var name = param.getName();
	this.sequence = null;
	this.params[name] = param;
	this.spec.fill();
	this.emit( 'add', param );
};

/**
 * Remove parameter from template.
 *
 * @method
 * @param {ve.dm.MWTemplateParameterModel} param Parameter to remove
 * @emits remove
 */
ve.dm.MWTemplateModel.prototype.removeParameter = function ( param ) {
	if ( param ) {
		this.sequence = null;
		delete this.params[param.getName()];
		this.emit( 'remove', param );
	}
};

/**
 * Set original data, to be used as a base for serialization.
 *
 * @method
 * @returns {Object} Template data
 */
ve.dm.MWTemplateModel.prototype.setOriginalData = function ( data ) {
	this.originalData = data;
};

/**
 * @inheritdoc
 */
ve.dm.MWTemplateModel.prototype.serialize = function () {
	var name,
		template = ve.extendObject(
			this.originalData || {}, { 'target': this.getTarget(), 'params': {} }
		),
		params = this.getParameters();

	for ( name in params ) {
		template.params[params[name].getOriginalName()] = { 'wt': params[name].getValue() };
	}

	return { 'template': template };
};
