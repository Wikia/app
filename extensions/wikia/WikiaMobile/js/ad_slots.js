require( ['ads', 'jquery', 'JSMessages', 'wikia.window', 'wikia.log', 'sections'], function ( ads, $, msg, window, log, sections ) {
	'use strict';
	var MIN_ZEROTH_SECTION_LENGTH = 700,
		MIN_PAGE_LENGTH = 2000,
		doc = window.document,
		logGroup = 'ad_slots',
		logLevel = log.levels.info,
		topAdWrapper = doc.getElementById( 'MOBILE_TOP_LEADERBOARD' ),
		$firstSection = $( 'h2[id]' ).first(),
		$footer = $( '#wkMainCntFtr' ),
		firstSectionTop = ( $firstSection.length && $firstSection.offset().top ) || 0,
		shouldShowAds = window.wgArticleId && window.navigator.userAgent.indexOf( 'sony_tvs' ) === -1,
		shouldShowInContent = sections.isSectionLongerThan( 0, MIN_ZEROTH_SECTION_LENGTH ),
		shouldShowBeforeFooter =
			( doc.body.offsetHeight > MIN_PAGE_LENGTH || firstSectionTop < MIN_ZEROTH_SECTION_LENGTH ) &&
				sections.isDefined( 1 ),
		div;

	function loadAd( adWrapper, slotName ) {
		log( 'Loading slot: ' + slotName, logLevel, logGroup );

		ads.setupSlot( {
			name: slotName,
			size: ['300x250', '1x1'],
			wrapper: adWrapper,
			init: function onInit ( found ) {
				log( 'Slot: ' + slotName + ' loaded, found: ' + found, logLevel, logGroup );
				if ( found ) {
					adWrapper.innerHTML += '<label class="wkAdLabel inContent">' + msg( 'wikiamobile-ad-label' ) + '</label>';
					adWrapper.className += ' show';
				} else {
					adWrapper.className += ' hidden';
				}
			}
		} );
	}

	if( shouldShowAds ) {
		log( 'Loading slot: MOBILE_TOP_LEADERBOARD', logLevel, logGroup );
		ads.setupSlot( {
			name: 'MOBILE_TOP_LEADERBOARD',
			size: ['320x50', '1x1'],
			wrapper: topAdWrapper,
			init: function ( found ) {
				log( 'Slot: MOBILE_TOP_LEADERBOARD loaded, found: ' + found, logLevel, logGroup );
				if ( !found ) {
					topAdWrapper.className = 'hidden';
				}
			}
		} );

		//this can wait to on load as is under the fold
		$( window ).on( 'load', function () {
			if ( shouldShowInContent ) {
				div = '<div id=MOBILE_IN_CONTENT class=ad-in-content />';

				if ( window.Wikia.AbTest.getGroup( 'WIKIAMOBILE_RELATEDPAGES' ) ) {
					sections.getElementAt( MIN_ZEROTH_SECTION_LENGTH ).after( div );
				} else {
					$firstSection.before( div );
				}

				loadAd( doc.getElementById( 'MOBILE_IN_CONTENT' ), 'MOBILE_IN_CONTENT' );
			}

			if ( shouldShowBeforeFooter ) {
				$footer.after( '<div id=MOBILE_PREFOOTER class=ad-in-content />' );
				loadAd( doc.getElementById( 'MOBILE_PREFOOTER' ), 'MOBILE_PREFOOTER' );
			}
		} );

	} else {
		if ( topAdWrapper ) {
			topAdWrapper.className = 'hidden';
		}

		log( 'Ads blocked by UA or this is not an article', logLevel, logGroup );
	}
} );
