/*!
 * VisualEditor DataModel MWParameterModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki template parameter.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.dm.MWTemplateModel} template Template
 * @param {string} [name=''] Parameter name
 * @param {string} [value=''] Parameter value
 */
ve.dm.MWParameterModel = function VeDmMWParameterModel( template, name, value ) {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.template = template;
	this.originalName = name;
	this.name = typeof name === 'string' ? name.trim() : '';
	this.value = value || '';
	this.id = this.template.getId() + '/' + name;
};

/* Inheritance */

OO.mixinClass( ve.dm.MWParameterModel, OO.EventEmitter );

/* Events */

/**
 * @event change
 */

/* Methods */

/**
 * Check if parameter is required.
 *
 * @method
 * @returns {boolean} Parameter is required
 */
ve.dm.MWParameterModel.prototype.isRequired = function () {
	return this.template.getSpec().isParameterRequired( this.name );
};

/**
 * Check if parameter is suggested.
 *
 * @method
 * @param {string} name Parameter name
 * @returns {boolean} Parameter is suggested
 */
ve.dm.MWParameterModel.prototype.isSuggested = function () {
	return this.template.getSpec().isParameterSuggested( this.name );
};

/**
 * Check if parameter is deprecated.
 *
 * @method
 * @returns {boolean} Parameter is deprecated
 */
ve.dm.MWParameterModel.prototype.isDeprecated = function () {
	return this.template.getSpec().isParameterDeprecated( this.name );
};

/**
 * Get template of which this parameter is part.
 *
 * @returns {ve.dm.MWTemplateModel} Template
 */
ve.dm.MWParameterModel.prototype.getTemplate = function () {
	return this.template;
};

/**
 * Get unique parameter ID within the transclusion.
 *
 * @returns {string} Unique ID
 */
ve.dm.MWParameterModel.prototype.getId = function () {
	return this.id;
};

/**
 * Get parameter name.
 *
 * @returns {string} Parameter name
 */
ve.dm.MWParameterModel.prototype.getName = function () {
	return this.name;
};

/**
 * Get parameter name.
 *
 * @returns {string} Parameter name
 */
ve.dm.MWParameterModel.prototype.getOriginalName = function () {
	return this.originalName;
};

/**
 * Get parameter value.
 *
 * @returns {string} Parameter value
 */
ve.dm.MWParameterModel.prototype.getValue = function () {
	return this.value;
};

/**
 * Set parameter value.
 *
 * @param {string} value Parameter value
 */
ve.dm.MWParameterModel.prototype.setValue = function ( value ) {
	this.value = value;
	this.emit( 'change' );
};

/**
 * Remove parameter from template.
 */
ve.dm.MWParameterModel.prototype.remove = function () {
	this.template.removeParameter( this );
};
