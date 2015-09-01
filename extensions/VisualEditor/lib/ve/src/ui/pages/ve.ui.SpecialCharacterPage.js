/*!
 * VisualEditor user interface SpecialCharacterPage class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki meta dialog Languages page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.SpecialCharacterPage = function VeUiSpecialCharacterPage( name, config ) {
	var character, characterNode, characters, $characters, charactersNode;

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	this.label = config.label;
	this.icon = config.icon;

	characters = config.characters;
	$characters = $( '<div>' ).addClass( 've-ui-specialCharacterPage-characters' );
	charactersNode = $characters[ 0 ];

	// The body of this loop is executed a few thousand times when opening
	// ve.ui.SpecialCharacterDialog, avoid jQuery wrappers.
	for ( character in characters ) {
		characterNode = document.createElement( 'div' );
		characterNode.className = 've-ui-specialCharacterPage-character';
		if ( characters[ character ].titleMsg ) {
			characterNode.setAttribute( 'title', ve.msg( characters[ character ].titleMsg ) );
		}
		characterNode.textContent = character;
		$.data( characterNode, 'character', characters[ character ] );
		charactersNode.appendChild( characterNode );
	}

	this.$element
		.addClass( 've-ui-specialCharacterPage' )
		.append( $( '<h3>' ).text( name ), $characters );
};

/* Inheritance */

OO.inheritClass( ve.ui.SpecialCharacterPage, OO.ui.PageLayout );

/* Methods */

ve.ui.SpecialCharacterPage.prototype.setupOutlineItem = function ( outlineItem ) {
	ve.ui.SpecialCharacterPage.super.prototype.setupOutlineItem.call( this, outlineItem );
	this.outlineItem.setLabel( this.label );
};
