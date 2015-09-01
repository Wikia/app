/*!
 * VisualEditor UserInterface SpecialCharacterInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Inspector for inserting special characters.
 *
 * @class
 * @extends ve.ui.FragmentInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.SpecialCharacterInspector = function VeUiSpecialCharacterInspector( config ) {
	// Parent constructor
	ve.ui.FragmentInspector.call( this, config );

	this.characters = null;
	this.$buttonDomList = null;
	this.categories = null;

	this.$element.addClass( 've-ui-specialCharacterInspector' );
};

/* Inheritance */

OO.inheritClass( ve.ui.SpecialCharacterInspector, ve.ui.FragmentInspector );

/* Static properties */

ve.ui.SpecialCharacterInspector.static.name = 'specialcharacter';

ve.ui.SpecialCharacterInspector.static.title =
	OO.ui.deferMsg( 'visualeditor-specialcharacterinspector-title' );

ve.ui.SpecialCharacterInspector.static.size = 'large';

ve.ui.SpecialCharacterInspector.static.actions = [
	{
		action: 'cancel',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe'
	}
];

/* Methods */

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.SpecialCharacterInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.SpecialCharacterInspector.super.prototype.initialize.call( this );

	this.$spinner = this.$( '<div>' ).addClass( 've-ui-specialCharacterInspector-spinner' );
	this.form.$element.append( this.$spinner );
};

/**
 * Handle the inspector being setup.
 *
 * @method
 * @param {Object} [data] Inspector opening data
 */
ve.ui.SpecialCharacterInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.SpecialCharacterInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var inspector = this;
			// Stage a space to show insertion position
			this.getFragment().getSurface().pushStaging();
			this.getFragment().insertContent( ' ' );
			// Don't request the character list again if we already have it
			if ( !this.characters ) {
				this.$spinner.show();
				this.fetchCharList()
					.done( function () {
						inspector.buildButtonList();
					} )
					// TODO: show error message on fetchCharList().fail
					.always( function () {
						// TODO: generalize push/pop pending, like we do in Dialog
						inspector.$spinner.hide();
					} );
			}
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.SpecialCharacterInspector.prototype.getTeardownProcess = function ( data ) {
	data = data || {};
	return ve.ui.SpecialCharacterInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.getFragment().getSurface().popStaging();
			if ( data.character ) {
				this.getFragment().insertContent( data.character, true ).collapseToEnd().select();
			}
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.SpecialCharacterInspector.prototype.getActionProcess = function ( action ) {
	return new OO.ui.Process( function () {
		this.close( { action: action } );
	}, this );
};

/**
 * Fetch the special character list object
 *
 * Returns a promise which resolves when this.characters has been populated
 *
 * @returns {jQuery.Promise}
 */
ve.ui.SpecialCharacterInspector.prototype.fetchCharList = function () {
	var charsList,
		charsObj = {};

	// Get the character list
	charsList = ve.msg( 'visualeditor-specialcharinspector-characterlist-insert' );
	try {
		charsObj = $.parseJSON( charsList );
	} catch ( err ) {
		// There was no character list found, or the character list message is
		// invalid json string. Force a fallback to the minimal character list
		ve.log( 've.ui.SpecialCharacterInspector: Could not parse the Special Character list.');
		ve.log( err.message );
	} finally {
		this.characters = charsObj;
	}

	// This implementation always resolves instantly
	return $.Deferred().resolve().promise();
};

/**
 * Builds the button DOM list based on the character list
 */
ve.ui.SpecialCharacterInspector.prototype.buildButtonList = function () {
	var category, character, characters, $categoryButtons,
		$list = this.$( '<div>' ).addClass( 've-ui-specialCharacterInspector-list' );

	for ( category in this.characters ) {
		characters = this.characters[category];
		$categoryButtons = $( '<div>' ).addClass( 've-ui-specialCharacterInspector-list-group' );
		for ( character in characters ) {
			$categoryButtons.append(
				$( '<div>' )
					.addClass( 've-ui-specialCharacterInspector-list-character' )
					.data( 'character', characters[character] )
					.text( character )
			);
		}

		$list
			.append( this.$( '<h3>').text( category ) )
			.append( $categoryButtons );
	}

	$list.on( 'click', this.onListClick.bind( this ) );

	this.form.$element.append( $list );
};

/**
 * Handle the click event on the list
 */
ve.ui.SpecialCharacterInspector.prototype.onListClick = function ( e ) {
	this.close( { character: $( e.target ).data( 'character' ) } );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.SpecialCharacterInspector );
