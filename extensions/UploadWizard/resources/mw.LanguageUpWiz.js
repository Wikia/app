( function( mw ) {
mediaWiki.messages.set( {
	"mwe-upwiz-code-unknown": "Unknown language"
} );

/**
 * Utility class which knows about languages, and how to construct HTML to select them
 * TODO: make this a more common library, used by this and TimedText
 */
mw.LanguageUpWiz = {

	defaultCode: 'en',  // when we absolutely have no idea what language to preselect

	initialized: false,

	UNKNOWN: 'unknown',

	/**
	 * List of default languages
	 * Make sure you have language templates set up for each of these on your wiki, e.g. {{en}}
	 */
	languages: [
		{ lang: "de",		text: "Deutsch" },
		{ lang: "en",		text: "English" },
		{ lang: "es",		text: "Español" },
		{ lang: "fr",		text: "Français" },
		{ lang: "it",		text: "Italiano" },
		{ lang: "nl",		text: "Nederlands" },
		{ lang: "pl",		text: "Polski" },
		{ lang: "pt",		text: "Português" },
		{ lang: "ru",		text: "Русский" },
		{ lang: "zh",		text: "中文" },
		{ lang: "ja",		text: "日本語" }
	],

	/**
	 * cache some useful objects
	 * 1) mostly ready-to-go language HTML menu. When/if we upgrade, make it a jQuery combobox
	 * 2) dict of language code to name -- useful for testing for existence, maybe other things.
	 */
	initialize: function() {
		if ( mw.LanguageUpWiz.initialized ) {
			return;	
		}
		// if a language list is defined locally (MediaWiki:LanguageHandler.js), use that list instead
		if ( typeof LanguageHandler != 'undefined' ) {
			this.languages = LanguageHandler.languages;
		}
		mw.LanguageUpWiz._codes = {};
		var select = $j( '<select/>' );
		$j.each( mw.LanguageUpWiz.languages, function( i, language ) {
			// add an option for each language
			select.append(
				$j( '<option>' )
					.attr( 'value', language.lang )
					.append( language.text )
			);
			// add each language into dictionary
			mw.LanguageUpWiz._codes[language.lang] = language.text;
		} );
		mw.LanguageUpWiz.$_select = select;
		mw.LanguageUpWiz.initialized = true;
	},

	/**
	 * Get an HTML select menu of all our languages. 
	 * @param name	desired name of select element
	 * @param code	desired default language code
	 * @return HTML	select element configured as desired
	 */
	getMenu: function( name, code ) {
		mw.LanguageUpWiz.initialize();
		var $select = mw.LanguageUpWiz.$_select.clone();
		$select.attr( 'name', name );
		if ( code === mw.LanguageUpWiz.UNKNOWN ) {
			// n.b. MediaWiki LanguageHandler has ability to add custom label for 'Unknown'; possibly as pseudo-label
			$select.prepend( $j( '<option>' ).attr( 'value', mw.LanguageUpWiz.UNKNOWN ).append( gM( 'mwe-upwiz-code-unknown' )) );
			$select.val( mw.LanguageUpWiz.UNKNOWN );
		} else if ( code !== undefined ) {
			$select.val( mw.LanguageUpWiz.getClosest( code ));
		}
		return $select.get( 0 );
	},

	/** 
 	 * Figure out the closest language we have to a supplied language code.
	 * It seems that people on Mediawiki set their language code as freetext, and it could be anything, even
	 * variants we don't have a record for, or ones that are not in any ISO standard.
	 *
	 * Logic copied from MediaWiki:LanguageHandler.js 
	 * handle null cases, special cases for some Chinese variants
	 * Otherwise, if handed "foo-bar-baz" language, try to match most specific language,
	 *    "foo-bar-baz", then "foo-bar", then "foo"
	 *
	 * @param code 	A string representing a language code, which we may or may not have. 
	 *		Expected to be separated with dashes as codes from ISO 639, e.g. "zh-tw" for Chinese ( Traditional )
	 * @return a language code which is close to the supplied parameter, or fall back to mw.LanguageUpWiz.defaultCode
	 */
	getClosest: function( code ) {
		mw.LanguageUpWiz.initialize();
		if ( typeof ( code ) != 'string' || code === null || code.length === 0 ) {
			return mw.LanguageUpWiz.defaultCode;
		}
    		if ( code == 'nan' || code == 'minnan' ) {
			return 'zh-min-nan';
		} else if ( mw.LanguageUpWiz._codes[code] !== undefined ) {
			return code;					
		} 
		return mw.LanguageUpWiz.getClosest( code.substring( 0, code.indexOf( '-' )) );
	}


	// enhance a simple text input to be an autocompleting language menu
	// this will work when/if we move to jQuery 1.4. As of now the autocomplete is too underpowered for our needs without
	// serious hackery
	/* 
	$j.fn.languageMenu = function( options ) {
		var _this = this;
		_this.autocomplete( null, {
			minChars: 0,
			width: 310,
			selectFirst: true, 
			autoFill: true,
			mustMatch: true,
			matchContains: false,
			highlightItem: true,
			scroll: true,
			scrollHeight: 220,
			formatItem: function( row, i, max, term ) {
				return row.code + " " + row.code;
			},
			formatMatch: function( row, i, max, term ) {
				return row.code + " " + row.code;
			},
			formatResult: function( row ) {
				return row.code;
			}
		}, mw.Languages );

		// and add a dropdown so we can see the thingy, too 
		return _this;
	};
	*/

	// XXX the concept of "internal language" exists in UploadForm.js -- seems to be how they handled i18n, with 
	// language codes that has underscores rather than dashes, ( "en_gb" rather than the correct "en-gb" ).
	// although other info such as Information boxes was recorded correctly.	
	// This is presumed not to apply to the shiny new world of JS2, where i18n is handled in other ways.

};


} )( window.mediaWiki );

