require(
	[
		'jquery', 'JSMessages', 'wikia.window', 'wikia.log',
		'ext.wikia.adengine.adengine', 'ext.wikia.adengine.config.mobile'
	],
	function ( $, msg, window, log, adEngine, adConfigMobile ) {
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
			adSlots = [],
			isAdVisible = function ( adSlotName ) {
				return function ( hop ) {
					var slot = document.getElementById( adSlotName ),
						$iframe = $( slot ).find( 'iframe' ).contents();

					if (
						$iframe.find( 'body *:not(script)' ).length === 0 ||
						$iframe.find( 'body img' ).width() <= 1
					) {
						log( 'Slot seems to be empty: ' + adSlotName, logLevel, logGroup );
						if (window.wgEnableRHonMobile) {
							hop({method: 'hop'}, 'RemnantDartMobile');
						} else {
							hop({method: 'hop'}, 'Null');
						}
					} else {
						slot.className += ' show';
					}
				}
			};

		// Slots
		log( 'Loading slot: ' + mobileTopLeaderBoard, logLevel, logGroup );
		adSlots.push( [mobileTopLeaderBoard, isAdVisible( mobileTopLeaderBoard )] );

		if ( window.wgArticleId && (showInContent || showPreFooter ) ) {
			//this can wait to on load as is under the fold
			$( window ).on( 'load', function () {
				if ( showInContent ) {
					log( 'Loading slot: ' + mobileInContent, logLevel, logGroup );
					$firstSection.before( createSlot( mobileInContent ) );
					adSlots.push( [mobileInContent, isAdVisible( mobileInContent )] );
				}

				if ( showPreFooter ) {
					log( 'Loading slot: ' + mobilePreFooter, logLevel, logGroup );
					$footer.after( createSlot( mobilePreFooter ) );
					adSlots.push( [mobilePreFooter, isAdVisible( mobilePreFooter )] );
				}
			} );
		}

		// Start queue
		log( 'Running mobile queue', logLevel, logGroup );
		adEngine.run( adConfigMobile, adSlots, 'queue.mobile' );
	}
);
