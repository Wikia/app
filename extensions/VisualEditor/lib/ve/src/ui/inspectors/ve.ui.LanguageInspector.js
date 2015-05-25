/*!
 * VisualEditor UserInterface LanguageInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Inspector for specifying the language of content.
 *
 * @class
 * @extends ve.ui.AnnotationInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageInspector = function VeUiLanguageInspector( config ) {
	// Parent constructor
	ve.ui.AnnotationInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.LanguageInspector, ve.ui.AnnotationInspector );

/* Static properties */

ve.ui.LanguageInspector.static.name = 'language';

ve.ui.LanguageInspector.static.title =
	OO.ui.deferMsg( 'visualeditor-languageinspector-title' );

ve.ui.LanguageInspector.static.modelClasses = [ ve.dm.LanguageAnnotation ];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.getAnnotation = function () {
	var lang = this.languageInput.getLang(),
		dir = this.languageInput.getDir();
	return ( lang || dir ?
		new ve.dm.LanguageAnnotation( {
			type: 'meta/language',
			attributes: {
				lang: lang,
				dir: dir
			}
		} ) :
		null
	);
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.getAnnotationFromFragment = function ( fragment ) {
	return new ve.dm.LanguageAnnotation( {
		type: 'meta/language',
		attributes: {
			lang: fragment.getDocument().getLang(),
			dir: fragment.getDocument().getDir()
		}
	} );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.LanguageInspector.super.prototype.initialize.call( this );

	// Properties
	this.languageInput = new ve.ui.LanguageInputWidget( { $: this.$ } );

	// Initialization
	this.form.$element.append( this.languageInput.$element );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.LanguageInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.languageInput.setLangAndDir(
				this.initialAnnotation.getAttribute( 'lang' ),
				this.initialAnnotation.getAttribute( 'dir' )
			);
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.LanguageInspector );
