require( ['jquery', 'JSMessages', 'wikia.window', 'wikia.log'], function ( $, msg, window, log ) {
	'use strict';

	var minZerothSectionLength = 700,
		minPageLength = 2000,
		mobileTopLeaderBoard = 'MOBILE_TOP_LEADERBOARD',
		mobileInContent = 'MOBILE_IN_CONTENT',
		mobilePreFooter = 'MOBILE_PREFOOTER',
		doc = window.document,
		logGroup = 'ad_slots',
		logLevel = log.levels.info,
		$firstSection = $( 'h2[id]' ).first(),
		$footer = $( '#wkMainCntFtr' ),
		firstSectionTop = ( $firstSection.length && $firstSection.offset().top ) || 0,
		showInContent = firstSectionTop > minZerothSectionLength,
		showPreFooter = doc.body.offsetHeight > minPageLength || firstSectionTop < minZerothSectionLength,
		adLabel = msg( 'wikiamobile-ad-label' ),
		createSlot = function( name ) {
			return '<div id="' +
				name +
				'" class="ad-in-content"><label class="wkAdLabel inContent">' +
				adLabel +
				'</label></div></div>';
		};

	log( 'Loading slot: ' + mobileTopLeaderBoard, logLevel, logGroup );
	window.adslots2.push([mobileTopLeaderBoard]);

	if ( window.wgArticleId ) {
		if ( showInContent ) {
			log( 'Loading slot: ' + mobileInContent, logLevel, logGroup );
			$firstSection.before( createSlot( mobileInContent ) );
			window.adslots2.push([mobileInContent]);
		}

		if ( showPreFooter ) {
			log( 'Loading slot: ' + mobilePreFooter, logLevel, logGroup );
			$footer.after( createSlot( mobilePreFooter ) );
			window.adslots2.push([mobilePreFooter]);
		}
	}

//		$footer.before( createSlot( 'GPT_FLUSH', true ) );
//		window.adslots2.push(['GPT_FLUSH']);
} );

