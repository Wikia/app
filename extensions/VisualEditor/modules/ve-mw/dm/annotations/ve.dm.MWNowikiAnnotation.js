/*!
 * VisualEditor DataModel MWNowikiAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki nowiki annotation
 *
 * Represents `<nowiki>` tags (in HTML as `<span typeof="mw:Nowiki">`) and unwraps them when they change
 * so as to retrigger Parsoid's escaping mechanism.
 *
 * @class
 * @extends ve.dm.Annotation
 * @constructor
 * @param {Object} element [description]
 */
ve.dm.MWNowikiAnnotation = function VeDmMWNowikiAnnotation( element ) {
	// Parent constructor
	ve.dm.Annotation.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWNowikiAnnotation, ve.dm.Annotation );

/* Static Properties */

ve.dm.MWNowikiAnnotation.static.name = 'mwNowiki';

ve.dm.MWNowikiAnnotation.static.matchRdfaTypes = [ 'mw:Nowiki' ];

ve.dm.MWNowikiAnnotation.static.toDataElement = function ( domElements ) {
	return {
		'type': 'mwNowiki',
		'attributes': {
			'originalDomElements': ve.copy( domElements )
		}
	};
};

ve.dm.MWNowikiAnnotation.static.toDomElements = function ( dataElement, doc, converter, childDomElements ) {
	var i, len,
		originalDomElements = dataElement.attributes.originalDomElements,
		originalChildren = originalDomElements && originalDomElements[0] && originalDomElements[0].childNodes,
		contentsChanged = false,
		domElement = document.createElement( 'span' );

	// Determine whether the contents changed
	if ( !originalChildren || childDomElements.length !== originalChildren.length ) {
		contentsChanged = true;
	} else {
		for ( i = 0, len = originalChildren.length; i < len; i++ ) {
			if ( !originalChildren[i].isEqualNode( childDomElements[i] ) ) {
				contentsChanged = true;
				break;
			}
		}
	}

	// If the contents changed, unwrap, otherwise, restore
	if ( contentsChanged ) {
		return [];
	}
	domElement.setAttribute( 'typeof', 'mw:Nowiki' );
	return [ domElement ];
};

ve.dm.MWNowikiAnnotation.static.getHashObject = function ( dataElement ) {
	var parentResult = ve.dm.Annotation.static.getHashObject( dataElement );
	if ( parentResult.attributes.originalDomElements ) {
		// If present, replace originalDomElements with a DOM summary
		parentResult.attributes = ve.copy( parentResult.attributes );
		parentResult.attributes.originalDomElements = ve.copy(
			parentResult.attributes.originalDomElements, ve.convertDomElements
		);
	}
	return parentResult;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWNowikiAnnotation );
