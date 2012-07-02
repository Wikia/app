mediaWiki.messages.set( {
	"en_simple": "Simple message",
	"en_replace": "Simple $1 replacement",
	"en_link": "Simple [http://example.com link to example].",
	"en_link_replace": "Complex [$1 $2] behaviour.",
	"en_simple_magic": "Simple {{ALOHOMORA}} message",
	"en_undelete_short": "Undelete {{PLURAL:$1|one edit|$1 edits}}",
	"en_category-subcat-count": "{{PLURAL:$2|This category has only the following subcategory.|This category has the following {{PLURAL:$1|subcategory|$1 subcategories}}, out of $2 total.}}",
	"en_escape0": "Escape \\to fantasy island",
	"en_escape1": "I had \\$2.50 in my pocket",
	"en_escape2": "I had {{PLURAL:$1|the absolute \\|$1\\| which came out to \\$3.00 in my C:\\\\drive| some stuff}}",
	"en_fail": "This should fail to {{parse"
} );

var jasmineMsgSpec = [
	{
		"name": "en undelete_short 0",
		"key": "en_undelete_short",
		"args": [
			0
		],
		"result": "Undelete 0 edits",
		"lang": "en"
	},
	{
		"name": "en undelete_short 1",
		"key": "en_undelete_short",
		"args": [
			1
		],
		"result": "Undelete one edit",
		"lang": "en"
	},
	{
		"name": "en undelete_short 2",
		"key": "en_undelete_short",
		"args": [
			2
		],
		"result": "Undelete 2 edits",
		"lang": "en"
	},
	{
		"name": "en undelete_short 5",
		"key": "en_undelete_short",
		"args": [
			5
		],
		"result": "Undelete 5 edits",
		"lang": "en"
	},
	{
		"name": "en undelete_short 21",
		"key": "en_undelete_short",
		"args": [
			21
		],
		"result": "Undelete 21 edits",
		"lang": "en"
	},
	{
		"name": "en undelete_short 101",
		"key": "en_undelete_short",
		"args": [
			101
		],
		"result": "Undelete 101 edits",
		"lang": "en"
	},
	{
		"name": "en category-subcat-count 0,10",
		"key": "en_category-subcat-count",
		"args": [
			0,
			10
		],
		"result": "This category has the following 0 subcategories, out of 10 total.",
		"lang": "en"
	},
	{
		"name": "en category-subcat-count 1,1",
		"key": "en_category-subcat-count",
		"args": [
			1,
			1
		],
		"result": "This category has only the following subcategory.",
		"lang": "en"
	},
	{
		"name": "en category-subcat-count 1,2",
		"key": "en_category-subcat-count",
		"args": [
			1,
			2
		],
		"result": "This category has the following subcategory, out of 2 total.",
		"lang": "en"
	},
	{
		"name": "en category-subcat-count 3,30",
		"key": "en_category-subcat-count",
		"args": [
			3,
			30
		],
		"result": "This category has the following 3 subcategories, out of 30 total.",
		"lang": "en"
	}
];

/**
 * Tests
 */
describe( "mediaWiki.language.parser", function() {
		/**
		* Get a language transform key
		* returns default "en" fallback if none found
	 	* @FIXME the resource loader should do this anyway, should not be necessary to know this client side
		* @param String langKey The language key to be checked	
		mediaWiki.language.getLangTransformKey = function( langKey ) {		
			//if( mediaWiki.language.fallbackTransformMap[ langKey ] ) {
			//	langKey = mediaWiki.language.fallbackTransformMap[ langKey ];
			//}
			// Make sure the langKey has a transformClass: 
			//for( var i = 0; i < mediaWiki.language.transformClass.length ; i++ ) {
			//	if( langKey == mediaWiki.language.transformClass[i] ){
			//		return langKey;
			//	}
			//}
			// By default return the base 'en' class
			return 'en';
		};

		/**
		 * @@FIXME this should be handled dynamically handled in the resource loader 
		 * 	so it keeps up-to-date with php maping. 
		 * 	( not explicitly listed here ) 
		mediaWiki.language.fallbackTransformMap = {
				'mwl' : 'pt', 
				'ace' : 'id', 
				'hsb' : 'de', 
				'frr' : 'de', 
				'pms' : 'it', 
				'dsb' : 'de', 
				'gan' : 'gan-hant', 
				'lzz' : 'tr', 
				'ksh' : 'de', 
				'kl' : 'da', 
				'fur' : 'it', 
				'zh-hk' : 'zh-hant', 
				'kk' : 'kk-cyrl', 
				'zh-my' : 'zh-sg', 
				'nah' : 'es', 
				'sr' : 'sr-ec', 
				'ckb-latn' : 'ckb-arab', 
				'mo' : 'ro', 
				'ay' : 'es', 
				'gl' : 'pt', 
				'gag' : 'tr', 
				'mzn' : 'fa', 
				'ruq-cyrl' : 'mk', 
				'kk-arab' : 'kk-cyrl', 
				'pfl' : 'de', 
				'zh-yue' : 'yue', 
				'ug' : 'ug-latn', 
				'ltg' : 'lv', 
				'nds' : 'de', 
				'sli' : 'de', 
				'mhr' : 'ru', 
				'sah' : 'ru', 
				'ff' : 'fr', 
				'ab' : 'ru', 
				'ko-kp' : 'ko', 
				'sg' : 'fr', 
				'zh-tw' : 'zh-hant', 
				'map-bms' : 'jv', 
				'av' : 'ru', 
				'nds-nl' : 'nl', 
				'pt-br' : 'pt', 
				'ce' : 'ru', 
				'vep' : 'et', 
				'wuu' : 'zh-hans', 
				'pdt' : 'de', 
				'krc' : 'ru', 
				'gan-hant' : 'zh-hant', 
				'bqi' : 'fa', 
				'as' : 'bn', 
				'bm' : 'fr', 
				'gn' : 'es', 
				'tt' : 'ru', 
				'zh-hant' : 'zh-hans', 
				'hif' : 'hif-latn', 
				'zh' : 'zh-hans', 
				'kaa' : 'kk-latn', 
				'lij' : 'it', 
				'vot' : 'fi', 
				'ii' : 'zh-cn', 
				'ku-arab' : 'ckb-arab', 
				'xmf' : 'ka', 
				'vmf' : 'de', 
				'zh-min-nan' : 'nan', 
				'bcc' : 'fa', 
				'an' : 'es', 
				'rgn' : 'it', 
				'qu' : 'es', 
				'nb' : 'no', 
				'bar' : 'de', 
				'lbe' : 'ru', 
				'su' : 'id', 
				'pcd' : 'fr', 
				'glk' : 'fa', 
				'lb' : 'de', 
				'kk-kz' : 'kk-cyrl', 
				'kk-tr' : 'kk-latn', 
				'inh' : 'ru', 
				'mai' : 'hi', 
				'tp' : 'tokipona', 
				'kk-latn' : 'kk-cyrl', 
				'ba' : 'ru', 
				'nap' : 'it', 
				'ruq' : 'ruq-latn', 
				'tt-cyrl' : 'ru', 
				'lad' : 'es', 
				'dk' : 'da', 
				'de-ch' : 'de', 
				'be-x-old' : 'be-tarask', 
				'za' : 'zh-hans', 
				'kk-cn' : 'kk-arab', 
				'shi' : 'ar', 
				'crh' : 'crh-latn', 
				'yi' : 'he', 
				'pdc' : 'de', 
				'eml' : 'it', 
				'uk' : 'ru', 
				'kv' : 'ru', 
				'koi' : 'ru', 
				'cv' : 'ru', 
				'zh-cn' : 'zh-hans', 
				'de-at' : 'de', 
				'jut' : 'da', 
				'vec' : 'it', 
				'zh-mo' : 'zh-hk', 
				'fiu-vro' : 'vro', 
				'frp' : 'fr', 
				'mg' : 'fr', 
				'ruq-latn' : 'ro', 
				'sa' : 'hi', 
				'lmo' : 'it', 
				'kiu' : 'tr', 
				'tcy' : 'kn', 
				'srn' : 'nl', 
				'jv' : 'id', 
				'vls' : 'nl', 
				'zea' : 'nl', 
				'ty' : 'fr', 
				'szl' : 'pl', 
				'rmy' : 'ro', 
				'wo' : 'fr', 
				'vro' : 'et', 
				'udm' : 'ru', 
				'bpy' : 'bn', 
				'mrj' : 'ru', 
				'ckb' : 'ckb-arab', 
				'xal' : 'ru', 
				'de-formal' : 'de', 
				'myv' : 'ru', 
				'ku' : 'ku-latn', 
				'crh-cyrl' : 'ru', 
				'gsw' : 'de', 
				'rue' : 'uk', 
				'iu' : 'ike-cans', 
				'stq' : 'de', 
				'gan-hans' : 'zh-hans', 
				'scn' : 'it', 
				'arn' : 'es', 
				'ht' : 'fr', 
				'zh-sg' : 'zh-hans', 
				'bat-smg' : 'lt', 
				'aln' : 'sq', 
				'tg' : 'tg-cyrl', 
				'li' : 'nl', 
				'simple' : 'en', 
				'os' : 'ru', 
				'ln' : 'fr', 
				'als' : 'gsw', 
				'zh-classical' : 'lzh', 
				'arz' : 'ar', 
				'wa' : 'fr'
			};	
		*/
		/**
		 * Language classes ( which have a file in /languages/classes/Language{code}.js )
		 * ( for languages that override default transforms ) 
		 * 
		 * @@FIXME again not needed if the resource loader manages this mapping and gives 
		 * 	us the "right" transform class regardless of what language key we request. 
		mediaWiki.language.transformClass = ['am', 'ar', 'bat_smg', 'be_tarak', 'be', 'bh',
				'bs', 'cs', 'cu', 'cy', 'dsb', 'fr', 'ga', 'gd', 'gv', 'he', 'hi',
				'hr', 'hsb', 'hy', 'ksh', 'ln', 'lt', 'lv', 'mg', 'mk', 'mo', 'mt',
				'nso', 'pl', 'pt_br', 'ro', 'ru', 'se', 'sh', 'sk', 'sl', 'sma',
				'sr_ec', 'sr_el', 'sr', 'ti', 'tl', 'uk', 'wa' ];

		// wgLang??
		var wgLanguageCode = 'en';
		// Set-up base convert plural and gender (to restore for non-transform languages ) 
		var cachedConvertPlural = { 'en' : mediaWiki.language.convertPlural };
		 
		// XXX THIS ONLY WORKS FOR NEIL
		/**
		var wgScriptPath = 'http://wiki.ivy.local/w';	
		 * Clear out digit transform table, load new pluralization rules, for a new language.
		 * Typically we don't need to do this in MediaWiki, it's one interface language per page.
		 * @param {String} languageCode
		 * @param {Function} to be executed when related scripts have loaded
		mediaWiki.language.resetForLang = function( lang, fn ) {
			mediaWiki.language.digitTransformTable = null;
			// Load the current language js file if it has a langKey		
			var lang = mediaWiki.language.getLangTransformKey( lang );
			if( cachedConvertPlural[lang] ) {
				mediaWiki.language.convertPlural = cachedConvertPlural[lang];
				fn();
			} else { 
				mw.log( lang + " load msg transform" );
				$j.getScript( wgScriptPath + '/resources/mediaWiki.language/languages/' + lang.toLowerCase() + '.js' , function(){
					cachedConvertPlural[lang] = mediaWiki.language.convertPlural;
					fn();
				});			
			}
		};
		 */
	

	describe( "basic message functionality", function() {

		it( "should return identity for simple string", function() {
			var parser = new mediaWiki.language.parser();
			expect( parser.parse( 'en_simple' ).html() ).toEqual( 'Simple message' );
		} );

	} );

	describe( "escaping", function() {

		it ( "should handle simple escaping", function() {
			var parser = new mediaWiki.language.parser();
			expect( parser.parse( 'en_escape0' ).html() ).toEqual( 'Escape to fantasy island' );
		} );

		it ( "should escape dollar signs found in ordinary text when backslashed", function() {
			var parser = new mediaWiki.language.parser();
			expect( parser.parse( 'en_escape1' ).html() ).toEqual( 'I had $2.50 in my pocket' );
		} );

		it ( "should handle a complicated escaping case, including escaped pipe chars in template args", function() {
			var parser = new mediaWiki.language.parser();
			expect( parser.parse( 'en_escape2', [ 1 ] ).html() ).toEqual( 'I had the absolute |1| which came out to $3.00 in my C:\\drive' );
		} );

	} );

	describe( "replacing", function() {

		it ( "should handle simple replacing", function() {
			var parser = new mediaWiki.language.parser();
			expect( parser.parse( 'en_replace', [ 'foo' ] ).html() ).toEqual( 'Simple foo replacement' );
		} );

	} );

	describe( "linking", function() {

		it ( "should handle a simple link", function() {
			var parser = new mediaWiki.language.parser();
			var parsed = parser.parse( 'en_link' );
			var contents = parsed.contents();
			expect( contents.length ).toEqual( 3 );
			expect( contents[0].nodeName ).toEqual( '#text' );
			expect( contents[0].nodeValue ).toEqual( 'Simple ' );
			expect( contents[1].nodeName ).toEqual( 'A' );
			expect( contents[1].getAttribute( 'href' ) ).toEqual( 'http://example.com' );
			expect( contents[1].childNodes[0].nodeValue ).toEqual( 'link to example' );
			expect( contents[2].nodeName ).toEqual( '#text' );
			expect( contents[2].nodeValue ).toEqual( '.' );
		} );

		it ( "should replace a URL into a link", function() {
			var parser = new mediaWiki.language.parser();
			var parsed = parser.parse( 'en_link_replace', [ 'http://example.com/foo', 'linking' ] );
			var contents = parsed.contents();
			expect( contents.length ).toEqual( 3 );
			expect( contents[0].nodeName ).toEqual( '#text' );
			expect( contents[0].nodeValue ).toEqual( 'Complex ' );
			expect( contents[1].nodeName ).toEqual( 'A' );
			expect( contents[1].getAttribute( 'href' ) ).toEqual( 'http://example.com/foo' );
			expect( contents[1].childNodes[0].nodeValue ).toEqual( 'linking' );
			expect( contents[2].nodeName ).toEqual( '#text' );
			expect( contents[2].nodeValue ).toEqual( ' behaviour.' );
		} );

		it ( "should bind a click handler into a link", function() {
			var parser = new mediaWiki.language.parser();
			var clicked = false;
			var click = function() { clicked = true; };
			var parsed = parser.parse( 'en_link_replace', [ click, 'linking' ] );
			var contents = parsed.contents();
			expect( contents.length ).toEqual( 3 );
			expect( contents[0].nodeName ).toEqual( '#text' );
			expect( contents[0].nodeValue ).toEqual( 'Complex ' );
			expect( contents[1].nodeName ).toEqual( 'A' );
			expect( contents[1].getAttribute( 'href' ) ).toEqual( '#' );
			expect( contents[1].childNodes[0].nodeValue ).toEqual( 'linking' );
			expect( contents[2].nodeName ).toEqual( '#text' );
			expect( contents[2].nodeValue ).toEqual( ' behaviour.' );
			// determining bindings is hard in IE
			var anchor = parsed.find( 'a' );
			if ( ( $j.browser.mozilla || $j.browser.webkit ) && anchor.click ) {
				expect( clicked ).toEqual( false );
				anchor.click(); 
				expect( clicked ).toEqual( true );
			}
		} );

		it ( "should wrap a jquery arg around link contents -- even another element", function() {
			var parser = new mediaWiki.language.parser();
			var clicked = false;
			var click = function() { clicked = true; };
			var button = $j( '<button>' ).click( click );
			var parsed = parser.parse( 'en_link_replace', [ button, 'buttoning' ] );
			var contents = parsed.contents();
			expect( contents.length ).toEqual( 3 );
			expect( contents[0].nodeName ).toEqual( '#text' );
			expect( contents[0].nodeValue ).toEqual( 'Complex ' );
			expect( contents[1].nodeName ).toEqual( 'BUTTON' );
			expect( contents[1].childNodes[0].nodeValue ).toEqual( 'buttoning' );
			expect( contents[2].nodeName ).toEqual( '#text' );
			expect( contents[2].nodeValue ).toEqual( ' behaviour.' );
			// determining bindings is hard in IE
			if ( ( $j.browser.mozilla || $j.browser.webkit ) && button.click ) {
				expect( clicked ).toEqual( false );
				parsed.find( 'button' ).click();
				expect( clicked ).toEqual( true );
			}
		} );


	} );


	describe( "magic keywords", function() {
		it( "should substitute magic keywords", function() {
			var options = {
				magic: { 
					'alohomora' : 'open'
			        }
			};
			var parser = new mediaWiki.language.parser( options );
			expect( parser.parse( 'en_simple_magic' ).html() ).toEqual( 'Simple open message' );
		} );
	} );

	describe( "quantities and plurals", function() {
		
		$j.each( jasmineMsgSpec, function( i, test ) { 
			var parser = new mediaWiki.language.parser();
			it( "should parse " + test.name, function() { 
				//var argArray = [ test.key ].concat( test.args );
				var parsed = parser.parse( test.key, test.args ).html();
				expect( parsed ).toEqual( test.result );
			} );
		} );

	} );
	
	describe( "error conditions", function() {
		it( "should return non-existent key in angle brackets", function() {
			var parser = new mediaWiki.language.parser();
			expect( parser.parse( 'en_does_not_exist' ).html() ).toEqual( '&lt;en_does_not_exist&gt;' );
		} );


		it( "should fail to parse", function() {
			var parser = new mediaWiki.language.parser();
			expect( function() { parser.parse( 'en_fail' ); } ).toThrow( 
				'Parse error at position 20 in input: This should fail to {{parse'
			);
		} );
	} );

	describe( "easy message interface functions", function() {
		it( "should allow a global that returns strings", function() {
			var gM = mediaWiki.language.parser.getMessageFunction();
			// passing this through jQuery and back to string, because browsers may have subtle differences, like the case of tag names.
			// a surrounding <SPAN> is needed for html() to work right
			var expectedHtml = $j( '<span>Complex <a href="http://example.com/foo">linking</a> behaviour.</span>' ).html();
			var result = gM( 'en_link_replace', 'http://example.com/foo', 'linking' );
			expect( typeof result ).toEqual( 'string' );
			expect( result ).toEqual( expectedHtml );
		} );

		it( "should allow a jQuery plugin that appends to nodes", function() {
			$j.fn.msg = mediaWiki.language.parser.getJqueryPlugin();
			var $div = $j( '<div>' ).append( $j( '<p>' ).addClass( 'foo' ) );
			var clicked = false;
			var $button = $j( '<button>' ).click( function() { clicked = true; } );
			$div.find( '.foo' ).msg( 'en_link_replace', $button, 'buttoning' );
			// passing this through jQuery and back to string, because browsers may have subtle differences, like the case of tag names.
			// a surrounding <SPAN> is needed for html() to work right
			var expectedHtml = $j( '<span>Complex <button>buttoning</button> behaviour.</span>' ).html();
			var createdHtml = $div.find( '.foo' ).html();
			// it is hard to test for clicks with IE; also it inserts or removes spaces around nodes when creating HTML tags, depending on their type.
			// so need to check the strings stripped of spaces.
			if ( ( $j.browser.mozilla || $j.browser.webkit ) && $button.click ) {
				expect( createdHtml ).toEqual( expectedHtml );
				$div.find( 'button ').click();
				expect( clicked ).toEqual( true );
			} else if ( $j.browser.ie ) {
				expect( createdHtml.replace( /\s/, '' ) ).toEqual( expectedHtml.replace( /\s/, '' ) );
			}
			delete $j.fn.msg;
		} );


	} );

} );
