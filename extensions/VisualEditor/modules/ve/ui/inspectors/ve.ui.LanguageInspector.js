/*!
 * VisualEditor UserInterface LanguageInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Language inspector.
 *
 * @class
 * @extends ve.ui.AnnotationInspector
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this inspector is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageInspector = function VeUiLanguageInspector( windowSet, config ) {
	// Parent constructor
	ve.ui.AnnotationInspector.call( this, windowSet, config );

	// Placeholder for the dm properties:
	this.lang = '';
	this.dir = '';

	// Placeholder for the annotation:
	this.annotation = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.LanguageInspector, ve.ui.AnnotationInspector );

/* Static properties */

ve.ui.LanguageInspector.static.name = 'language';

ve.ui.LanguageInspector.static.icon = 'language';

ve.ui.LanguageInspector.static.titleMessage = 'visualeditor-languageinspector-title';

/**
 * Annotation models this inspector can edit.
 *
 * @static
 * @property {Function[]}
 */
ve.ui.LanguageInspector.static.modelClasses = [ ve.dm.LanguageAnnotation ];

/* Methods */

/**
 * Get the annotation.
 *
 * @method
 * @returns {ve.dm.LanguageAnnotation} Language annotation
 */
ve.ui.LanguageInspector.prototype.getAnnotation = function () {
	return this.annotation;
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.getAnnotationFromText = function () {
	return new ve.dm.LanguageAnnotation( {
		'type': 'meta/language',
		'attributes': {
			'lang': this.lang,
			'dir': this.dir
		}
	} );
};

/**
 * Gets a language from the annotation.
 *
 * @method
 * @param {ve.dm.LanguageAnnotation} annotation Language annotation
 * @returns {string} Language
 */
ve.ui.LanguageInspector.prototype.getLanguageFromAnnotation = function ( annotation ) {
	if ( annotation instanceof ve.dm.LanguageAnnotation ) {
		return annotation.getAttribute( 'lang' );
	}
	return '';
};

/**
 * Set the annotation.
 *
 * Form values will be updated from information within the annotation.
 *
 * @param {ve.dm.LanguageAnnotation} annotation Annotation to set
 * @chainable
 */
ve.ui.LanguageInspector.prototype.setAnnotation = function ( annotation ) {
	var langCode, langDir, annData;

	// Validate the given annotation:
	if ( annotation ) {
		// Give precedence to dir value if it already exists
		// in the annotation:
		langDir = annotation.getAttribute( 'dir' );

		// Set language according to the one in the given annotation
		// or leave blank if element has no language set
		langCode = annotation.getAttribute( 'lang' );
	} else {
		// No annotation (empty text or collapsed fragment on empty line)
		langCode = this.lang;
		langDir = this.dir;
	}

	// If language exists, but dir is undefined/null,
	// fix the dir in terms of language:
	if ( langCode && !langDir && $.uls ) {
		langDir = $.uls.data.getDir( langCode );
	}

	// Set the annotation data:
	annData = {
		'type': 'meta/language',
		'attributes': {}
	};

	if ( langCode ) {
		annData.attributes.lang = langCode;
	}

	if ( langDir ) {
		annData.attributes.dir = langDir;
	}

	// Update the widget:
	this.targetInput.setAttributes( langCode, langDir );

	// Update inspector properties:
	this.lang = langCode;
	this.dir = langDir;

	// Set up the annotation:
	this.annotation = new ve.dm.LanguageAnnotation( annData );

	return this;
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.initialize.call( this );

	// Properties
	this.targetInput = new ve.ui.LanguageInputWidget( {
		'$': this.$,
		'$overlay': this.surface.$localOverlay
	} );

	// Initialization
	this.$form.append( this.targetInput.$element );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.AnnotationInspector.prototype.setup.call( this, data );

	var fragDOM,
		fragment = this.surface.getModel().getFragment( null, true );

	// Get the fragment documentView object (the real DOM object):
	fragDOM = this.surface.getView().documentView.getNodeFromOffset( fragment.getRange( true ).start );

	// Set initial parameters according to parent of the DOM object.
	// This will be called only if the annotation doesn't already exist, setting
	// the default value as the current language/dir of the selected text.
	if ( fragDOM ) {
		this.lang = fragDOM.$element.closest( '[lang]' ).attr( 'lang' );
		this.dir = fragDOM.$element.closest( '[dir]' ).css( 'direction' );
	}
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.ready = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.ready.call( this );

	// Initialization
	this.setAnnotation( this.initialAnnotation );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.teardown = function ( data ) {
	// Read the annotation values from the widget:
	var attrs = this.targetInput.getAttributes();

	// Set the annotation with the new attributes:
	this.annotation = new ve.dm.LanguageAnnotation( {
		'type': 'meta/language',
		'attributes': attrs
	} );

	// Parent method
	ve.ui.AnnotationInspector.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.LanguageInspector );
