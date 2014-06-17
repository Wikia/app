/*global require*/
require(
	[
		'jquery', 'JSMessages', 'wikia.window', 'wikia.log',
		'ext.wikia.adEngine.adEngine', 'ext.wikia.adEngine.adConfigMobile',
		'ext.wikia.adEngine.messageListener'
	],
	function ( $, msg, window, log, adEngine, adConfigMobile, messageListener ) {
		'use strict';

		var minZerothSectionLength = 700,
			minPageLength = 2000,
			mobileTopLeaderBoard = 'MOBILE_TOP_LEADERBOARD',
			mobileInContent = 'MOBILE_IN_CONTENT',
			mobilePreFooter = 'MOBILE_PREFOOTER',
			doc = window.document,
			logGroup = 'ads_run',
			logLevel = log.levels.info,
			$firstSection = $( 'h2[id]' ).first(),
			$footer = $( '#wkMainCntFtr' ),
			firstSectionTop = ( $firstSection.length && $firstSection.offset().top) || 0,
			showInContent = firstSectionTop > minZerothSectionLength,
			showPreFooter = doc.body.offsetHeight > minPageLength || firstSectionTop < minZerothSectionLength,
			adLabel = msg( 'wikiamobile-ad-label' ),
			createSlot = function ( name ) {
				return '<div id="' +
					name +
					'" class="ad-in-content"><label class="wkAdLabel inContent">' +
					adLabel +
					'</label></div></div>';
			},
			adSlots = [];

		messageListener.init();

		// Slots
		log( 'Loading slot: ' + mobileTopLeaderBoard, logLevel, logGroup );
		adSlots.push( [mobileTopLeaderBoard] );

		if ( window.wgArticleId && (showInContent || showPreFooter ) ) {
			//this can wait to on load as is under the fold
			$( window ).on( 'load', function () {
				if ( showInContent ) {
					log( 'Loading slot: ' + mobileInContent, logLevel, logGroup );
					$firstSection.before( createSlot( mobileInContent ) );
					adSlots.push( [mobileInContent] );
				}

				if ( showPreFooter ) {
					log( 'Loading slot: ' + mobilePreFooter, logLevel, logGroup );
					$footer.after( createSlot( mobilePreFooter ) );
					adSlots.push( [mobilePreFooter] );
				}
			} );
		}

		// Start queue
		log( 'Running mobile queue', logLevel, logGroup );
		adEngine.run( adConfigMobile, adSlots, 'queue.mobile' );
	}
);
