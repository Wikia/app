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
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageInspector = function VeUiLanguageInspector( surface, config ) {
	// Parent constructor
	ve.ui.AnnotationInspector.call( this, surface, config );

	// Placeholder for the dm properties:
	this.lang = '';
	this.dir = '';

	// Placeholder for the annotation:
	this.annotation = null;
};

/* Inheritance */

ve.inheritClass( ve.ui.LanguageInspector, ve.ui.AnnotationInspector );

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
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.LanguageInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.initialize.call( this );

	// Properties
	this.targetInput = new ve.ui.LanguageInputWidget( {
		'$$': this.frame.$$,
		'$overlay': this.surface.$localOverlay
	} );

	// Initialization
	this.$form.append( this.targetInput.$ );
};

/**
 * Handle the inspector being opened.
 */
ve.ui.LanguageInspector.prototype.onOpen = function () {
	// Parent method
	ve.ui.AnnotationInspector.prototype.onOpen.call( this );

	// Wait for animation to complete
	setTimeout( ve.bind( function () {
		// Setup annotation
		this.setAnnotation( this.initialAnnotation );
	}, this ), 200 );
};
/**
 * Handle the inspector being set up.
 * Make sure the initial language and direction are set by the parent
 * of the DOM element of the selected fragment before the rest of the
 * onSetup method is processed by the parent ve.ui.AnnotationInspector
 */
ve.ui.LanguageInspector.prototype.onSetup = function () {
	var fragDOM,
		fragment = this.surface.getModel().getFragment( null, true );

	// Get the fragment documentView object (the real DOM object):
	fragDOM = this.surface.getView().documentView.getNodeFromOffset( fragment.getRange( true ).start );

	// Set initial parameters according to parent of the DOM object.
	// This will be called only if the annotation doesn't already exist, setting
	// the default value as the current language/dir of the selected text.
	if ( fragDOM ) {
		this.lang = fragDOM.$.closest( '[lang]' ).attr( 'lang' );
		this.dir = fragDOM.$.closest( '[dir]' ).css( 'direction' );
	}

	// Parent method
	ve.ui.AnnotationInspector.prototype.onSetup.call( this );
};


/**
 * Handle the inspector being closed: refresh the annotation
 * from the widget values
 *
 * @param {string} action Action that caused the window to be closed
 */
ve.ui.LanguageInspector.prototype.onClose = function ( action ) {
	// Read the annotation values from the widget:
	var attrs = this.targetInput.getAttributes();

	// Set the annotation with the new attributes:
	this.annotation = new ve.dm.LanguageAnnotation( {
		'type': 'meta/language',
		'attributes': attrs
	} );

	// Call parent method
	ve.ui.AnnotationInspector.prototype.onClose.call( this, action );

};

/**
 * Gets the annotation value.
 *
 * @method
 * @returns {ve.dm.LanguageAnnotation} Language annotation
 */
ve.ui.LanguageInspector.prototype.getAnnotation = function () {
	return this.annotation;
};


/**
 * Validates and sets the annotation value
 * Then updates the attributes and the widget table display
 *
 * @method
 * @param {ve.dm.LanguageAnnotation} annotation Language annotation
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

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.LanguageInspector );
