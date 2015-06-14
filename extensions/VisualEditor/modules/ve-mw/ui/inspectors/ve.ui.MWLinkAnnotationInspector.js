/*!
 * VisualEditor UserInterface LinkInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for applying and editing labeled MediaWiki internal and external links.
 *
 * @class
 * @extends ve.ui.LinkInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkAnnotationInspector = function VeUiMWLinkAnnotationInspector( config ) {
	// Parent constructor
	ve.ui.LinkInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLinkAnnotationInspector, ve.ui.LinkInspector );

/* Static properties */

ve.ui.MWLinkAnnotationInspector.static.name = 'link';

ve.ui.MWLinkAnnotationInspector.static.modelClasses = [
	ve.dm.MWExternalLinkAnnotation,
	ve.dm.MWInternalLinkAnnotation
];

ve.ui.MWLinkAnnotationInspector.static.linkTargetInputWidget = ve.ui.MWLinkTargetInputWidget;

/* Methods */

/**
 * Gets an annotation object from a fragment.
 *
 * The type of link is automatically detected based on some crude heuristics.
 *
 * @method
 * @param {ve.dm.SurfaceFragment} fragment Current selection
 * @returns {ve.dm.MWInternalLinkAnnotation|ve.dm.MWExternalLinkAnnotation|null}
 */
ve.ui.MWLinkAnnotationInspector.prototype.getAnnotationFromFragment = function ( fragment ) {
	var target = fragment.getText(),
		title = mw.Title.newFromText( target );

	// Figure out if this is an internal or external link
	if ( ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( target ) ) {
		// External link
		return new ve.dm.MWExternalLinkAnnotation( {
			type: 'link/mwExternal',
			attributes: {
				href: target
			}
		} );
	} else if ( title ) {
		// Internal link
		// TODO: In the longer term we'll want to have autocompletion and existence and validity
		// checks using AJAX

		if ( title.getNamespaceId() === 6 || title.getNamespaceId() === 14 ) {
			// File: or Category: link
			// We have to prepend a colon so this is interpreted as a link
			// rather than an image inclusion or categorization
			target = ':' + target;
		}

		return new ve.dm.MWInternalLinkAnnotation( {
			type: 'link/mwInternal',
			attributes: {
				title: target,
				// bug 62816: we really need a builder for this stuff
				normalizedTitle: ve.dm.MWInternalLinkAnnotation.static.normalizeTitle( target ),
				lookupTitle: ve.dm.MWInternalLinkAnnotation.static.getLookupTitle( target )
			}
		} );
	} else {
		// Doesn't look like an external link and mw.Title considered it an illegal value,
		// for an internal link.
		return null;
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getInsertionData = function () {
	var target = this.targetInput.getValue(),
		inserting = this.initialSelection.isCollapsed();

	// If this is a new external link, insert an autonumbered link instead of a link annotation (in
	// #getAnnotation we have the same condition to skip the annotating). Otherwise call parent method
	// to figure out the text to insert and annotate.
	if ( inserting && ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( target ) ) {
		return [
			{
				type: 'link/mwNumberedExternal',
				attributes: {
					href: target
				}
			},
			{ type: '/link/mwNumberedExternal' }
		];
	} else {
		return ve.ui.MWLinkAnnotationInspector.super.prototype.getInsertionData.call( this );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getAnnotation = function () {
	var target = this.targetInput.getValue(),
		inserting = this.initialSelection.isCollapsed();

	// If this is a new external link, we've just inserted an autonumbered link node (see
	// #getInsertionData). Do not place any annotations of top of it.
	if ( inserting && ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( target ) ) {
		return null;
	} else {
		return ve.ui.MWLinkAnnotationInspector.super.prototype.getAnnotation.call( this );
	}
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWLinkAnnotationInspector );
