/**
 * Module that checks if a given wikia exists
 * in a user's native language (based on a Geo cookie)
 * and displays a notification with a link.
 */

( function( $, mw, undefined ) {
	'use strict';

	var wikiaInYourLang = {

		init: function() {
			$.cookie( 'Geo', '{"country":"ja"}' );
			this.geo = JSON.parse( $.cookie( 'Geo' ) );
			this.targetLanguage = this.geo.country.toLowerCase();
			this.supportedLanguages = [ 'ja' ];
			this.currentUrl = wgServer;

			if ( $.inArray( this.targetLanguage, this.supportedLanguages ) !== -1 && wgContentLanguage == 'en' ) {
				this.getNativeWikiaInfo( this );
			}
		},

		getNativeWikiaInfo: function( obj ) {
			$.nirvana.sendRequest( {
				controller: 'WikiaInYourLangController',
				method: 'getNativeWikiaInfo',
				data: {
					currentUrl: obj.currentUrl,
					targetLanguage: obj.targetLanguage
				},
				callback: function( results ) {
					if ( results.success == true ) {
						obj.displayNotification( results.wikiaSitename, results.wikiaUrl );
					}
				}
			} );
		},

		displayNotification: function( wikiaSitename, wikiaUrl ) {
			var currentSitename = wgSitename,
			    linkElement = '<a href="' + wikiaUrl + '" title="' + wikiaSitename +'">' + wikiaSitename + '</a>',
			    message = mw.message( 'wikia-in-your-lang-available', currentSitename , linkElement );

			GlobalNotification.show( message.plain(), 'notify' );
		}
	};

	$( function() {
		wikiaInYourLang.init();
	} );

}( jQuery, mediaWiki ) );
