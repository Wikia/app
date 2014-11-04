/**
 * Module that checks if a given wikia exists
 * in a user's native language (based on a Geo cookie)
 * and displays a notification with a link.
 */

( function( $, mw, undefined ) {
	'use strict';

	var wikiaInYourLang = {

		init: function() {
			this.geo = $.cookie( 'Geo' );
			this.supportedLanguages = [ 'ja' ];

			if ( $.inArray( this.geo, this.supportedLanguages ) !== -1 && wgContentLanguage == 'en' ) {
				var results = this.getWikiaInUserLanguageInfo();

				if ( results.wikiaExists ) {

					this.displayNotification( results.wikiaSitename, results.wikiaUrl );
				}
			}
		},

		getWikiaInUserLanguageInfo: function() {
			var results = {
				'wikiaExists': true,
				'wikiaSitename': 'ナルト Wiki',
				'wikiaUrl': 'http://ja.naruto.wikia.com/wiki/_Wiki',
			};
			return results;
		},

		displayNotification: function( wikiaSitename, wikiaUrl ) {
			var currentSitename = wgSitename,
			    linkElement = '<a href="' + wikiaUrl + '">' + wikiaSitename + '</a>',
			    message = mw.message( 'wikia-in-your-lang-available', currentSitename , linkElement );

			window.GlobalNotification.show( message.plain(), 'notify' );
		}
	};

	$( function() {
		wikiaInYourLang.init();
	} );

}( jQuery, mediaWiki ) );
