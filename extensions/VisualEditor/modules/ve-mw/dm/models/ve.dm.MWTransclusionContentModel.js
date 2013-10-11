/*!
 * VisualEditor DataModel MWTransclusionContentModel class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki transclusion content model.
 *
 * @class
 * @extends ve.dm.MWTransclusionPartModel
 *
 * @constructor
 * @param {ve.dm.MWTransclusionModel} transclusion Transclusion
 * @param {string} [value] Content value
 */
ve.dm.MWTransclusionContentModel = function VeDmMWTransclusionContentModel( transclusion, value ) {
	// Parent constructor
	ve.dm.MWTransclusionPartModel.call( this, transclusion );

	// Properties
	this.value = value || '';
};

/* Inheritance */

ve.inheritClass( ve.dm.MWTransclusionContentModel, ve.dm.MWTransclusionPartModel );

/* Methods */

/**
 * Get content value.
 *
 * @method
 * @returns {string} Content value
 */
ve.dm.MWTransclusionContentModel.prototype.getValue = function () {
	return this.value;
};

/**
 * Set content value.
 *
 * @method
 * @param {string} value Content value
 */
ve.dm.MWTransclusionContentModel.prototype.setValue = function ( value ) {
	this.value = value;
};

/**
 * @inheritdoc
 */
ve.dm.MWTransclusionContentModel.prototype.serialize = function () {
	return this.getValue();
};
