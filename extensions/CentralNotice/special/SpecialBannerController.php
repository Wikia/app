<?php

/**
 * Generates Javascript file which controls banner selection on the client side
 */
class SpecialBannerController extends UnlistedSpecialPage {
	protected $sharedMaxAge = 3600; // Cache for 1 hour on the server side
	protected $maxAge = 3600; // Cache for 1 hour on the client side

	function __construct() {
		// Register special page
		parent::__construct( "BannerController" );
	}

	function execute( $par ) {
		global $wgOut;

		$wgOut->disable();
		$this->sendHeaders();

		$content = $this->getOutput();
		if ( strlen( $content ) == 0 ) {
			// Hack for IE/Mac 0-length keepalive problem, see RawPage.php
			echo "/* Empty */";
		} else {
			echo $content;
		}
	}

	/**
	 * Generate the HTTP response headers for the banner controller
	 */
	function sendHeaders() {
		global $wgJsMimeType;
		header( "Content-type: $wgJsMimeType; charset=utf-8" );
		header( "Cache-Control: public, s-maxage=$this->sharedMaxAge, max-age=$this->maxAge" );
	}

	/**
	 * Generate the body for the Javascript file
	 *
	 * We use a jsonp scheme for actual delivery of the banner so that they can be served from meta.
	 * In order to circumvent the normal squid cache override we add '/cn.js' to the bannerlist URL.
	 */
	function getOutput() {
		global $wgCentralPagePath, $wgContLang;

		$js = $this->getScriptFunctions() . $this->getToggleScripts();
		$js .= <<<JAVASCRIPT
( function( $, mw ) { mw.loader.using( 'mediawiki.util', function () {

	$.ajaxSetup({ cache: true });
	$.centralNotice = {
		data: {
			getVars: {},
			bannerType: 'default'
		},
		fn: {
			loadBanner: function( bannerName, campaign, bannerType ) {
				var bannerPageQuery, bannerPage, bannerScript;

				// Store the bannerType in case we need to set a banner hiding cookie later
				$.centralNotice.data.bannerType = bannerType;
				// Get the requested banner
				bannerPageQuery = $.param( {
					banner: bannerName,
					campaign: campaign,
					userlang: mw.config.get( 'wgUserLanguage' ),
					db: mw.config.get( 'wgDBname' ),
					sitename: mw.config.get( 'wgSiteName' ),
					country: Geo.country
				} );
				bannerPage = '?title=Special:BannerLoader&' + bannerPageQuery;
JAVASCRIPT;
		$js .= "\n\t\t\t\tbannerScript = '<script type=\"text/javascript\" src=\"" .
			Xml::escapeJsString( $wgCentralPagePath ) .
			"' + bannerPage + '\"></script>';\n";
		$js .= <<<JAVASCRIPT
				if ( document.cookie.indexOf( 'centralnotice_' + bannerType + '=hide' ) === -1 ) {
					jQuery( '#siteNotice' ).prepend( '<div id="centralNotice" class="' +
						'cn-' + bannerType + '">'+bannerScript+'</div>' );
				}
			},
			loadBannerList: function( geoOverride ) {
				var geoLocation, bannerListQuery, bannerListURL;

				if ( geoOverride ) {
					geoLocation = geoOverride; // override the geo info
				} else {
					geoLocation = Geo.country; // pull the geo info
				}
				bannerListQuery = $.param( {
					language: mw.config.get( 'wgContentLanguage' ),
					project: mw.config.get( 'wgNoticeProject' ),
					country: geoLocation
				} );
JAVASCRIPT;
		$js .= "\n\t\t\t\tbannerListURL = mw.util.wikiScript() + '?title=' + encodeURIComponent('" .
			$wgContLang->specialPage( 'BannerListLoader' ) .
			"') + '&cache=/cn.js&' + bannerListQuery;\n";
		$js .= <<<JAVASCRIPT
				// Prevent loading banners on Special pages
				if ( mw.config.get( 'wgNamespaceNumber' ) !== -1 ) {
					$.ajax( {
						url: bannerListURL,
						dataType: 'json',
						success: $.centralNotice.fn.chooseBanner
					} );
				}
			},
			chooseBanner: function( bannerList ) {
				mw.loader.using( 'mediawiki.user', function() {
					var groomedBannerList = [], i, j, pointer;

					// Make sure there are some banners to choose from
					if ( bannerList.length === 0 ) {
						return false;
					}

					for( i = 0; i < bannerList.length; i++ ) {
						// Only include this banner if it's intended for the current user
						if( ( !mw.user.anonymous() && bannerList[i].display_account === 1 ) ||
							( mw.user.anonymous() && bannerList[i].display_anon === 1 ) )
						{
							// Add the banner to our list once per weight
							for( j = 0; j < bannerList[i].weight; j++ ) {
								groomedBannerList.push( bannerList[i] );
							}
						}
					}

					// Return if there's nothing left after the grooming
					if ( groomedBannerList.length === 0 ) {
						return false;
					}

					// Choose a random key
					pointer = Math.floor( Math.random() * groomedBannerList.length );

					// Load a random banner from our groomed list
					$.centralNotice.fn.loadBanner(
						groomedBannerList[pointer].name,
						groomedBannerList[pointer].campaign,
						( groomedBannerList[pointer].fundraising ? 'fundraising' : 'default' )
					);
				});
			},
			getQueryStringVariables: function() {
				function decode( s ) {
					return decodeURIComponent( s.split( '+' ).join( ' ' ) );
				}
				document.location.search.replace( /\??(?:([^=]+)=([^&]*)&?)/g, function ( str, p1, p2 ) {
					$.centralNotice.data.getVars[decode( p1 )] = decode( p2 );
				} );
			}
		}
	};

	$( document ).ready( function ( $ ) {
		// Initialize the query string vars
		$.centralNotice.fn.getQueryStringVariables();
		if( $.centralNotice.data.getVars.banner ) {
			// if we're forcing one banner
			$.centralNotice.fn.loadBanner( $.centralNotice.data.getVars.banner );
		} else {
			// Look for banners ready to go NOW
			$.centralNotice.fn.loadBannerList( $.centralNotice.data.getVars.country );
		}
	} );

} ); } )( jQuery, mediaWiki );
JAVASCRIPT;
		return $js;

	}

	function getToggleScripts() {
		$script = "var wgNoticeToggleState = document.cookie.indexOf( 'hidesnmessage=1' ) === -1;\n\n";
		return $script;
	}

	function getScriptFunctions() {
		global $wgNoticeFundraisingUrl;
		$script = <<<JAVASCRIPT
function insertBanner( bannerJson ) {
	var url, targets;

	jQuery( 'div#centralNotice' ).prepend( bannerJson.bannerHtml );
	if ( bannerJson.autolink ) {
JAVASCRIPT;
	$script .= "\n\t\turl = '" .
	Xml::escapeJsString( $wgNoticeFundraisingUrl ) . "';\n";
	$script .= <<<JAVASCRIPT
		if ( ( bannerJson.landingPages !== null ) && bannerJson.landingPages.length ) {
			targets = String( bannerJson.landingPages ).split(',');
			url += "?" + jQuery.param( {
				landing_page: targets[Math.floor( Math.random() * targets.length )].replace( /^\s+|\s+$/, '' )
			} );
			url += "&" + jQuery.param( {
				utm_medium: 'sitenotice',
				utm_campaign: bannerJson.campaign,
				utm_source: bannerJson.bannerName,
				language: mw.config.get( 'wgUserLanguage' ),
				country: Geo.country
			} );
			jQuery( '#cn-landingpage-link' ).attr( 'href', url );
		}
	}
}
function setBannerHidingCookie( bannerType ) {
	var e = new Date();
	e.setTime( e.getTime() + (14*24*60*60*1000) ); // two weeks
	var work = 'centralnotice_' + bannerType + '=hide; expires=' + e.toGMTString() + '; path=/';
	document.cookie = work;
}
function hideBanner() {
	jQuery( '#centralNotice' ).hide(); // Hide current banner
	var bannerType = jQuery.centralNotice.data.bannerType;
	if ( bannerType === undefined ) {
		bannerType = 'default';
	}
	setBannerHidingCookie( bannerType ); // Hide future banners of the same type
}
// This function is deprecated
function toggleNotice() {
	hideBanner();
}

JAVASCRIPT;
		return $script;
	}

}
