/*!
 * VisualEditor DataModel LinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel link annotation.
 *
 * Represents `<a>` tags that don't have a specific type.
 *
 * @class
 * @extends ve.dm.Annotation
 * @constructor
 * @param {Object} element
 */
ve.dm.LinkAnnotation = function VeDmLinkAnnotation() {
	// Parent constructor
	ve.dm.LinkAnnotation.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.LinkAnnotation, ve.dm.Annotation );

/* Static Properties */

ve.dm.LinkAnnotation.static.name = 'link';

ve.dm.LinkAnnotation.static.matchTagNames = ['a'];

ve.dm.LinkAnnotation.static.splitOnWordbreak = true;

ve.dm.LinkAnnotation.static.toDataElement = function ( domElements ) {
	return {
		type: this.name,
		attributes: {
			href: domElements[0].getAttribute( 'href' )
		}
	};
};

ve.dm.LinkAnnotation.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'a' );
	domElement.setAttribute( 'href', this.getHref( dataElement ) );
	return [ domElement ];
};

/**
 * Get the link href from linear data. Helper function for toDomElements.
 *
 * Subclasses can override this if they provide complex href computation.
 *
 * @static
 * @method
 * @inheritable
 * @param {Object} dataElement Linear model element
 * @returns {string} Link href
 */
ve.dm.LinkAnnotation.static.getHref = function ( dataElement ) {
	return dataElement.attributes.href;
};

/* Methods */

/**
 * Convenience wrapper for .getHref() on the current element.
 * @see #static-getHref
 * @returns {string} Link href
 */
ve.dm.LinkAnnotation.prototype.getHref = function () {
	return this.constructor.static.getHref( this.element );
};

/**
 * @inheritdoc
 */
ve.dm.LinkAnnotation.prototype.getComparableObject = function () {
	return {
		type: this.getType(),
		href: this.getAttribute( 'href' )
	};
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.LinkAnnotation );
