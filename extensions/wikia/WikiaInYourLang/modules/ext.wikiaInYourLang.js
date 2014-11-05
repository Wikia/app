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
				this.getNativeWikiaInfo( this );
			}
		},

		getNativeWikiaInfo: function( obj ) {
			// console.log( window.wgServer );
			$.nirvana.sendRequest( {
				controller: 'WikiaInYourLangController',
				method: 'getNativeWikiaInfo',
				data: {
					currentUrl: wgServer,
					targetLanguage: obj.geo
				},
				callback: function( results ) {
					console.log( results );
					if ( results.success == true ) {
						obj.displayNotification( results.wikiaSitename, results.wikiaUrl );
					} else {
						alert( results.errorMsg );
					}
				}
			} );
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
