/*!
 * VisualEditor DataModel MWTemplateParameterModel class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki template parameter.
 *
 * @class
 *
 * @constructor
 * @param {ve.dm.MWTemplateModel} template Template
 * @param {string} name Parameter name
 * @param {string} value Parameter value
 */
ve.dm.MWTemplateParameterModel = function VeDmMWTemplateParameterModel( template, name, value ) {
	// Properties
	this.template = template;
	this.originalName = name;
	this.name = name.trim();
	this.value = value || '';
	this.id = this.template.getId() + '/' + name;
};

/* Methods */

/**
 * Get template parameter is part of.
 *
 * @method
 * @returns {ve.dm.MWTemplateModel} Template
 */
ve.dm.MWTemplateParameterModel.prototype.getTemplate = function () {
	return this.template;
};

/**
 * Get unique parameter ID within the transclusion.
 *
 * @returns {string} Unique ID
 */
ve.dm.MWTemplateParameterModel.prototype.getId = function () {
	return this.id;
};

/**
 * Get parameter name.
 *
 * @method
 * @returns {string} Parameter name
 */
ve.dm.MWTemplateParameterModel.prototype.getName = function () {
	return this.name;
};

/**
 * Get parameter name.
 *
 * @method
 * @returns {string} Parameter name
 */
ve.dm.MWTemplateParameterModel.prototype.getOriginalName = function () {
	return this.originalName;
};

/**
 * Get parameter value.
 *
 * @method
 * @returns {string} Parameter value
 */
ve.dm.MWTemplateParameterModel.prototype.getValue = function () {
	return this.value;
};

/**
 * Set parameter value.
 *
 * @method
 * @param {string} value Parameter value
 */
ve.dm.MWTemplateParameterModel.prototype.setValue = function ( value ) {
	this.value = value;
};

/**
 * Remove parameter from template.
 *
 * @method
 */
ve.dm.MWTemplateParameterModel.prototype.remove = function () {
	this.template.removeParameter( this );
};
