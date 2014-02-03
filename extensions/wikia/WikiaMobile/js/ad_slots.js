require( ['ads', 'jquery', 'JSMessages', 'wikia.window', 'wikia.log'], function ( ads, $, msg, window, log ) {
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
		showInContent = firstSectionTop > MIN_ZEROTH_SECTION_LENGTH,
		showBeforeFooter = doc.body.offsetHeight > MIN_PAGE_LENGTH || firstSectionTop < MIN_ZEROTH_SECTION_LENGTH;

	function loadAd( adWrapper, slotName ) {
		log( 'Loading slot: ' + slotName, logLevel, logGroup );

		ads.setupSlot( {
			name: slotName,
			size: '300x250',
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

	log( 'Loading slot: MOBILE_TOP_LEADERBOARD', logLevel, logGroup );
	ads.setupSlot( {
		name: 'MOBILE_TOP_LEADERBOARD',
		size: '320x50',
		wrapper: topAdWrapper,
		init: function ( found ) {
			log( 'Slot: MOBILE_TOP_LEADERBOARD loaded, found: ' + found, logLevel, logGroup );
			if ( !found ) {
				topAdWrapper.className = 'hidden';
			}
		}
	} );

	if ( window.wgArticleId && (showInContent || showBeforeFooter ) ) {
		//this can wait to on load as is under the fold
		$( window ).on( 'load', function () {
			if ( showInContent ) {
				$firstSection.before( '<div id=MOBILE_IN_CONTENT class=ad-in-content />' );
				loadAd( doc.getElementById( 'MOBILE_IN_CONTENT' ), 'MOBILE_IN_CONTENT' );
			}

			if ( showBeforeFooter ) {
				$footer.after( '<div id=MOBILE_PREFOOTER class=ad-in-content />' );
				loadAd( doc.getElementById( 'MOBILE_PREFOOTER' ), 'MOBILE_PREFOOTER' );
			}
		} );
	}
} );
