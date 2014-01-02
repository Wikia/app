/*!
 * VisualEditor DataModel MWTransclusionPartModel class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki transclusion part model.
 *
 * @class
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {ve.dm.MWTransclusionModel} transclusion Transclusion
 */
ve.dm.MWTransclusionPartModel = function VeDmMWTransclusionPartModel( transclusion ) {
	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.transclusion = transclusion;
	this.id = 'part_' + this.transclusion.getUniquePartId();
};

/* Inheritance */

ve.mixinClass( ve.dm.MWTransclusionPartModel, ve.EventEmitter );

/* Methods */

/**
 * Get transclusion part is in.
 *
 * @method
 * @returns {ve.dm.MWTransclusionModel} Transclusion
 */
ve.dm.MWTransclusionPartModel.prototype.getTransclusion = function () {
	return this.transclusion;
};

/**
 * Get a unique part ID within the transclusion.
 *
 * @returns {string} Unique ID
 */
ve.dm.MWTransclusionPartModel.prototype.getId = function () {
	return this.id;
};

/**
 * Remove part from transclusion.
 *
 * @method
 */
ve.dm.MWTransclusionPartModel.prototype.remove = function () {
	this.transclusion.removePart( this );
};

/**
 * Get serialized representation of transclusion part.
 *
 * @method
 * @returns {Mixed} Serialized representation, or undefined if empty
 */
ve.dm.MWTransclusionPartModel.prototype.serialize = function () {
	return undefined;
};
