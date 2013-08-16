/*!
 * VisualEditor DataModel MWTemplatePlaceholderModel class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki template placeholder model.
 *
 * @class
 * @extends ve.dm.MWTransclusionPartModel
 *
 * @constructor
 * @param {ve.dm.MWTransclusionModel} transclusion Transclusion
 */
ve.dm.MWTemplatePlaceholderModel = function VeDmMWTemplatePlaceholderModel( transclusion ) {
	// Parent constructor
	ve.dm.MWTransclusionPartModel.call( this, transclusion );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWTemplatePlaceholderModel, ve.dm.MWTransclusionPartModel );
