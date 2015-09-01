/*!
 * VisualEditor DataModel MWHeadingNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki heading node.
 *
 * @class
 * @extends ve.dm.HeadingNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.MWHeadingNode = function VeDmMWHeadingNode() {
	// Parent constructor
	ve.dm.HeadingNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWHeadingNode, ve.dm.HeadingNode );

/* Static Properties */

ve.dm.MWHeadingNode.static.name = 'mwHeading';

ve.dm.MWHeadingNode.static.suggestedParentNodeTypes = [ 'document', 'tableCell' ];

ve.dm.MWHeadingNode.static.handlesOwnChildren = true;

ve.dm.MWHeadingNode.static.toDataElement = function ( domElements, converter ) {
	var shouldConvert = this.shouldConvertToParagraph( domElements[ 0 ] ),
		parentResult = ve.dm.MWHeadingNode.super.static.toDataElement.apply( this, arguments );
	parentResult.type = this.name;
	if ( shouldConvert ) {
		ve.setProp( parentResult, 'attributes', 'noconvert', true );
	}
	return converter.getDataFromDomSubtree(
		domElements[ 0 ],
		parentResult,
		new ve.dm.AnnotationSet( converter.getStore() )
	);
};

ve.dm.MWHeadingNode.static.toDomElements = function ( dataElements, doc, converter ) {
	var paragraph,
		parentResult = ve.dm.MWHeadingNode.super.static.toDomElements.call( this, dataElements[ 0 ], doc, converter );
	converter.getDomSubtreeFromData( dataElements.slice( 1, -1 ), parentResult[ 0 ] );

	if (
		( !dataElements[ 0 ].attributes || !dataElements[ 0 ].attributes.noconvert ) &&
		this.shouldConvertToParagraph( parentResult[ 0 ] )
	) {
		// Change parentResult[0] to a paragraph
		paragraph = doc.createElement( 'p' );
		while ( parentResult[ 0 ].firstChild ) {
			paragraph.appendChild( parentResult[ 0 ].firstChild );
		}
		parentResult[ 0 ] = paragraph;
	}

	return parentResult;
};

/**
 * Determine whether a heading should be converted to a paragraph.
 *
 * This function is called by toDomElements to determine whether the heading should be
 * converted to a paragraph, and also by toDataElement to determine whether the heading
 * already met the conversion criteria coming in (in which case it won't be converted).
 *
 * This implementation returns true if the heading does not contain a non-whitespace character,
 * but subclasses may override this to add their own logic.
 *
 * @param {HTMLElement} headingElement Heading DOM element
 * @return {boolean} Whether the heading should be converted to a paragraph
 */
ve.dm.MWHeadingNode.static.shouldConvertToParagraph = function ( headingElement ) {
	function containsNonWhitespace( el ) {
		var i, len, childNode;
		for ( i = 0, len = el.childNodes.length; i < len; i++ ) {
			childNode = el.childNodes[ i ];
			if (
				childNode.nodeType === Node.TEXT_NODE &&
				childNode.data.match( /\S/ )
			) {
				// Text node with a non-whitespace character
				return true;
			}
			if ( childNode.nodeType === Node.ELEMENT_NODE && containsNonWhitespace( childNode ) ) {
				return true;
			}
		}
		return false;
	}

	return !containsNonWhitespace( headingElement );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWHeadingNode );
