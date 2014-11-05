/**
 * Module that checks if a given wikia exists
 * in a user's native language (based on a Geo cookie)
 * and displays a notification with a link.
 *
 * Author - Adam Karmiński <adamk@wikia-inc.com>
 */

require(
	[
		'jquery',
		'mw',
		'wikia.cache',
		'wikia.tracker',
	],
	function( $, mw, cache, tracker ) {
		'use strict';

		var wikiaInYourLang = {

			init: function() {
				this.currentUrl = wgServer;

				/**
				 * An array of language codes for which we want to look for a native wikia
				 * @type {Array}
				 */
				this.supportedLanguages = [ 'ja' ];

				// Get user's geographic data and a country code
				this.geo = JSON.parse( $.cookie( 'Geo' ) );
				this.targetLanguage = this.geo.country.toLowerCase();

				// Check if the country code is one of the supported languages
				// and if the content is in English
				if ( $.inArray( this.targetLanguage, this.supportedLanguages ) !== -1 && wgContentLanguage == 'en' ) {

					// Check local browser cache to see if the notification
					// has already been shown to this user.
					if ( cache.get( 'wikiaInYourLangShown' ) !== true ) {

						// If not - set the cached info to true and show the popup
						var ttl = 60 * 60 * 24 * 14; // Cache for 2 weeks
						cache.set( 'wikiaInYourLangShown', true, ttl );

						this.getNativeWikiaInfo( this );
					}
				}
			},

			getNativeWikiaInfo: function( obj ) {
				/**
				 * Sends a request to the WikiaInYourLangController via Nirvana.
				 * Response consists of:
				 * {
				 *   success:       bool    True if a native wikia is found
				 *   wikiaSitename: string  A wgSitename value for the wikia
				 *   wikiaUrl:      string  A city_url valur for the wikia
				 * }
				 */
				$.nirvana.sendRequest( {
					controller: 'WikiaInYourLangController',
					method: 'getNativeWikiaInfo',
					data: {
						currentUrl: obj.currentUrl,
						targetLanguage: obj.targetLanguage
					},
					callback: function( results ) {
						if ( results.success == true ) {

							// Display notification and then set tracking on
							// the text link in it
							if ( obj.displayNotification( results.wikiaSitename, results.wikiaUrl ) ){
								obj.setupTracking( obj.targetLanguage );
							}
						}
					}
				} );
			},

			displayNotification: function( wikiaSitename, wikiaUrl ) {
				var currentSitename = wgSitename,
				    linkElement = '<a href="' + wikiaUrl + '" title="' + wikiaSitename +'" id="wikia-in-your-lang-link">' + wikiaSitename + '</a>',
				    message = mw.message( 'wikia-in-your-lang-available', currentSitename , linkElement );

				GlobalNotification.show( message.plain(), 'notify' );
				return true;
			},

			setupTracking: function( targetLanguage ) {
				var body = $( 'body' );
				body
					.on('click', 'a#wikia-in-your-lang-link', function() {
						var trackingParams = {
							trackingMethod: 'ga',
							category: 'wikia-in-your-lang',
							action: tracker.ACTIONS.CLICK_LINK_TEXT,
							label: targetLanguage + '-notification-link-click',
						};

						tracker.track( trackingParams );
					});
			},
		};

		$( function() {
			wikiaInYourLang.init();
		} );
	}
);
