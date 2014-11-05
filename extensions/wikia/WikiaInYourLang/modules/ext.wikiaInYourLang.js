/**
 * Module that checks if a given wikia exists
 * in a user's native language (based on a Geo cookie)
 * and displays a notification with a link.
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
				$.cookie( 'Geo', '{"country":"ja"}' );
				this.geo = JSON.parse( $.cookie( 'Geo' ) );
				this.targetLanguage = this.geo.country.toLowerCase();
				this.supportedLanguages = [ 'ja' ];
				this.currentUrl = wgServer;

				if ( $.inArray( this.targetLanguage, this.supportedLanguages ) !== -1 && wgContentLanguage == 'en' ) {
					if ( cache.get( 'wikiaInYourLangShown' ) === true ) {
						var ttl = 60 * 60 * 24 * 14; // Cache for 2 weeks
						cache.set( 'wikiaInYourLangShown', true, ttl );
						this.getNativeWikiaInfo( this );
					}
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
