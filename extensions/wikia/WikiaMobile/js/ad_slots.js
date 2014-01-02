require( ['ads', 'sloth', 'jquery', 'JSMessages', 'wikia.window', 'wikia.log'], function ( ads, sloth, $, msg, window, log ) {
	'use strict';

	var MIN_ZEROTH_SECTION_LENGTH = 700,
		MIN_PAGE_LENGTH = 2000,
		doc = window.document,
		logGroup = 'ad_slots',
		logLevel = log.levels.info,
		topAdWrapper = doc.getElementById( 'wkAdTopLeader' ),
		$firstSection = $( 'h2[id]' ).first(),
		$footer = $( '#wkMainCntFtr' ),
		firstSectionTop = ( $firstSection.length && $firstSection.offset().top ) || 0,
		showInContent = firstSectionTop > MIN_ZEROTH_SECTION_LENGTH,
		showBeforeFooter = doc.body.offsetHeight > MIN_PAGE_LENGTH || firstSectionTop < MIN_ZEROTH_SECTION_LENGTH,
		lazyLoadAd = function ( elem, slotName ) {
			log( 'Lazy load: ' + slotName, logLevel, logGroup );

			sloth( {
				on: elem,
				threshold: 500,
				callback: function onEnter ( adWrapper ) {
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
							}
						}
					} );
				}
			} );
		};

	log( 'Loading slot: MOBILE_TOP_LEADERBOARD', logLevel, logGroup );
	$(topAdWrapper).html('<div id="MOBILE_TOP_LEADERBOARD"></div>');
	window.adslots2.push(['MOBILE_TOP_LEADERBOARD']);

	if ( window.wgArticleId ) {
		if ( showInContent ) {
			$firstSection.before( '<div id=wkAdInContent class=ad-in-content />' );
			$('#wkAdInContent').html('<div id="MOBILE_IN_CONTENT"></div>');
			window.adslots2.push(['MOBILE_IN_CONTENT']);
		}

		if ( showBeforeFooter ) {
			$footer.after( '<div id=wkAdBeforeFooter class=ad-in-content />' );
			$('#wkAdBeforeFooter').html('<div id="MOBILE_PREFOOTER"></div>');
			window.adslots2.push(['MOBILE_PREFOOTER']);
		}
	}

	sloth();
} );
