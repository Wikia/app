$(window).on('load', function(){
	require( ['jquery', 'JSMessages', 'wikia.window', 'wikia.log'], function ( $, msg, window, log ) {
		'use strict';

		var MIN_ZEROTH_SECTION_LENGTH = 700,
			MIN_PAGE_LENGTH = 2000,
			doc = window.document,
			logGroup = 'ad_slots',
			logLevel = log.levels.info,
			$firstSection = $( 'h2[id]' ).first(),
			$footer = $( '#wkMainCntFtr' ),
			firstSectionTop = ( $firstSection.length && $firstSection.offset().top ) || 0,
			showInContent = firstSectionTop > MIN_ZEROTH_SECTION_LENGTH,
			showBeforeFooter = doc.body.offsetHeight > MIN_PAGE_LENGTH || firstSectionTop < MIN_ZEROTH_SECTION_LENGTH,
			adLabel = msg( 'wikiamobile-ad-label' ),
			createSlot = function( name ) {
				return '<div id="' +
					name +
					'" class="ad-in-content"><label class="wkAdLabel inContent">' +
					adLabel +
					'</label></div></div>';
			};

		log( 'Loading slot: MOBILE_TOP_LEADERBOARD', logLevel, logGroup );
		window.adslots2.push(['MOBILE_TOP_LEADERBOARD']);

		if ( window.wgArticleId ) {
			if ( showInContent ) {
				log( 'Loading slot: MOBILE_IN_CONTENT', logLevel, logGroup );
				$firstSection.before( createSlot( 'MOBILE_IN_CONTENT', true ) );
				window.adslots2.push(['MOBILE_IN_CONTENT']);
			}

			if ( showBeforeFooter ) {
				log( 'Loading slot: MOBILE_PREFOOTER', logLevel, logGroup );
				$footer.before( createSlot( 'MOBILE_PREFOOTER', true ) );
				window.adslots2.push(['MOBILE_PREFOOTER']);
			}
		}

//		$footer.before( createSlot( 'GPT_FLUSH', true ) );
//		window.adslots2.push(['GPT_FLUSH']);
	} );
});
