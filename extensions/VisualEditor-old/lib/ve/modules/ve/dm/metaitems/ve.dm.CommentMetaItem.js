/*!
 * VisualEditor DataModel CommentMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @extends ve.dm.MetaItem
 *
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.CommentMetaItem = function VeDmCommentMetaItem( element ) {
	ve.dm.CommentMetaItem.super.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.CommentMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.CommentMetaItem.static.name = 'comment';

ve.dm.CommentMetaItem.static.matchTagNames = [ '#comment' ];

ve.dm.CommentMetaItem.static.storeHtmlAttributes = false;

ve.dm.CommentMetaItem.static.toDataElement = function ( domElements ) {
	return {
		'type': this.name,
		'attributes': {
			'text': domElements[0].data
		}
	};
};

ve.dm.CommentMetaItem.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createComment( dataElement.attributes.text ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.CommentMetaItem );
