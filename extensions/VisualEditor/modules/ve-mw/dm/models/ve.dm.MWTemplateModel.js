/*!
 * VisualEditor DataModel MWTemplateModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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
 */
ve.dm.MWTemplateModel = function VeDmMWTemplateModel( transclusion, target ) {
	// Parent constructor
	ve.dm.MWTransclusionPartModel.call( this, transclusion );

	// Properties
	this.target = target;

	// TODO: Either here or in uses of this constructor we need to validate the title
	this.title = ( target.href && target.href.replace( /^(\.\.?\/)*/, '' ) ) || null;
	this.sequence = null;
	this.params = {};
	this.spec = new ve.dm.MWTemplateSpecModel( this );
	this.originalData = null;
};

/* Inheritance */

OO.inheritClass( ve.dm.MWTemplateModel, ve.dm.MWTransclusionPartModel );

/* Events */

/**
 * @event add
 * @param {ve.dm.MWParameterModel} param Added param
 */

/**
 * @event remove
 * @param {ve.dm.MWParameterModel} param Removed param
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
		template = new ve.dm.WikiaTemplateModel( transclusion, data.target, 'data' );

	for ( key in data.params ) {
		template.addParameter(
			new ve.dm.MWParameterModel( template, key, data.params[key].wt, 'data' )
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
 * @param {string|mw.Title} name Template name
 * @returns {ve.dm.MWTemplateModel|null} New template model
 */
ve.dm.MWTemplateModel.newFromName = function ( transclusion, name ) {
	var href, title,
		templateNs = mw.config.get( 'wgNamespaceIds' ).template;
	if ( name instanceof mw.Title ) {
		title = name;
		name = title.getRelativeText( templateNs );
	} else {
		title = mw.Title.newFromText( name, templateNs );
	}
	if ( title !== null ) {
		href = title.getPrefixedText();
		return new ve.dm.WikiaTemplateModel( transclusion, { href: href, wt: name }, 'user' );
	}

	return null;
};

/* Methods */

/**
 * Get template target.
 *
 * @returns {Object} Template target
 */
ve.dm.MWTemplateModel.prototype.getTarget = function () {
	return this.target;
};

/**
 * Get template title.
 *
 * @returns {string|null} Template title, if available
 */
ve.dm.MWTemplateModel.prototype.getTitle = function () {
	return this.title;
};

/**
 * Get template specification.
 *
 * @returns {ve.dm.MWTemplateSpecModel} Template specification
 */
ve.dm.MWTemplateModel.prototype.getSpec = function () {
	return this.spec;
};

/**
 * Get all params.
 *
 * @returns {Object.<string,ve.dm.MWParameterModel>} Parameters keyed by name
 */
ve.dm.MWTemplateModel.prototype.getParameters = function () {
	return this.params;
};

/**
 * Get a parameter.
 *
 * @param {string} name Parameter name
 * @returns {ve.dm.MWParameterModel} Parameter
 */
ve.dm.MWTemplateModel.prototype.getParameter = function ( name ) {
	return this.params[name];
};

/**
 * Check if a parameter exists.
 *
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
 * @returns {string[]} List of parameter names
 */
ve.dm.MWTemplateModel.prototype.getParameterNames = function () {
	var i, len, index, paramOrder, paramNames;

	if ( !this.sequence ) {
		paramOrder = this.spec.getParameterOrder();
		paramNames = ve.getObjectKeys( this.params );

		this.sequence = [];
		// Known parameters first
		for ( i = 0, len = paramOrder.length; i < len; i++ ) {
			index = paramNames.indexOf( paramOrder[i] );
			if ( index !== -1 ) {
				this.sequence.push( paramOrder[i] );
				paramNames.splice( index, 1 );
			}
		}
		// Unknown parameters in alpha-numeric order second, empty string at the very end
		paramNames.sort( function ( a, b ) {
			if ( a === '' ) {
				return 1;
			}
			if ( b === '' ) {
				return -1;
			}
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
		ve.batchPush( this.sequence, paramNames );
	}
	return this.sequence;
};

/**
 * Get parameter from its ID.
 *
 * @param {string} id Parameter ID
 * @returns {ve.dm.MWParameterModel|null} Parameter with matching ID, null if no parameters match
 */
ve.dm.MWTemplateModel.prototype.getParameterFromId = function ( id ) {
	var name;

	for ( name in this.params ) {
		if ( this.params[name].getId() === id ) {
			return this.params[name];
		}
	}

	return null;
};

/**
 * Add a parameter to template.
 *
 * @param {ve.dm.MWParameterModel} param Parameter to add
 * @fires add
 */
ve.dm.MWTemplateModel.prototype.addParameter = function ( param ) {
	var name = param.getName();
	this.sequence = null;
	this.params[name] = param;
	this.spec.fill();
	param.connect( this, { change: [ 'emit', 'change' ] } );
	this.emit( 'add', param );
	this.emit( 'change' );
};

/**
 * Remove parameter from template.
 *
 * @param {ve.dm.MWParameterModel} param Parameter to remove
 * @fires remove
 */
ve.dm.MWTemplateModel.prototype.removeParameter = function ( param ) {
	if ( param ) {
		this.sequence = null;
		delete this.params[param.getName()];
		param.disconnect( this );
		this.emit( 'remove', param );
		this.emit( 'change' );
	}
};

/**
 * Add all non-existing required and suggested parameters, if any.
 *
 * @method
 * @returns {number} Number of parameters added
 */
ve.dm.MWTemplateModel.prototype.addPromptedParameters = function () {
	var i, len, addedCount = 0,
		spec = this.getSpec(),
		names = spec.getParameterNames();

	for ( i = 0, len = names.length; i < len; i++ ) {
		if (
				!this.params[name] &&
				(
					spec.isParameterRequired( names[i] ) ||
					spec.isParameterSuggested( names[i] )
				)
			) {
			this.addParameter( new ve.dm.MWParameterModel( this, names[i] ) );
			addedCount++;
		}
	}

	return addedCount;
};

/**
 * Set original data, to be used as a base for serialization.
 *
 * @returns {Object} Template data
 */
ve.dm.MWTemplateModel.prototype.setOriginalData = function ( data ) {
	this.originalData = data;
};

/**
 * @inheritdoc
 */
ve.dm.MWTemplateModel.prototype.serialize = function () {
	var name, origName,
		origData = this.originalData || {},
		origParams = origData.params || {},
		template = { target: this.getTarget(), params: {} },
		params = this.getParameters();

	for ( name in params ) {
		if ( name === '' ) {
			continue;
		}
		origName = params[name].getOriginalName();
		template.params[origName] = ve.extendObject(
			{},
			origParams[origName],
			{ wt: params[name].getValue() }
		);

	}

	// Performs a non-deep extend, so this won't reintroduce
	// deleted parameters (bug 73134)
	template = ve.extendObject( {}, origData, template );
	return { template: template };
};

/**
 * @inheritdoc
 */
ve.dm.MWTemplateModel.prototype.getWikitext = function () {
	var param,
		wikitext = this.getTarget().wt,
		params = this.getParameters();

	for ( param in params ) {
		if ( param === '' ) {
			continue;
		}
		wikitext += '|' + param + '=' +
			ve.dm.MWTransclusionNode.static.escapeParameter( params[param].getValue() );
	}

	return '{{' + wikitext + '}}';
};
