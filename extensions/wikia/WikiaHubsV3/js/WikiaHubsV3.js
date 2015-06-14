define('wikia.hubs', ['wikia.window', 'jquery'], function wikiaHubs(window, $) {
	'use strict';

	var WikiaHubs = {
		init: function() {
			document.getElementById( 'WikiaHubs' ).addEventListener( 'click', WikiaHubs.clickTrackingHandler, true );

			// Featured Video
			$( '#WikiaHubs .wikiahubs-sponsored-video .thumbinner' ).mousedown( function( e ) {
				if ( $( e.target ).is( 'embed' ) ) {
					WikiaHubs.clickTrackingHandler( e );
				}
			} );

			// FB iFrame
			var WikiaFrame = $( '.WikiaFrame' );
			if ( WikiaFrame.length > 0 ) {
				WikiaFrame.on( 'click', 'a', WikiaHubs.iframeLinkChanger );
			}

			$('.tooltip-icon ').tooltip();
			$( 'body' ).on( 'click', '.modalWrapper', WikiaHubs.modalClickTrackingHandler );
		},

		iframeLinkChanger: function( e ) {
			e.preventDefault();
			var node = $( e.target ).closest( 'a' );
			window.top.location = node.attr( 'href' );
			return false;
		},

		trackClick: function( category, action, label, value, params, event ) {
			Wikia.Tracker.track( {
				action: action,
				browserEvent: event,
				category: category,
				eventName: 'wikiahubs',
				label: label,
				trackingMethod: 'analytics',
				value: value
			}, params );
		},

		clickTrackingHandler: function( e ) {
			var node = $( e.target ),
				startTime = new Date(),
				url,
				rank,
				parentNode,
				allNodes,
				itemIndex;

			if ( node.closest( '.wikiahubs-featured-video' ).length > 0 ) {    // featured video
				if ( node.is( 'a' ) ) {
					url = node.closest( 'a' ).attr( 'href' );
					WikiaHubs.trackClick(
						'featured-video',
						Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
						'link',
						null,
						{ href: url },
						e
					);
				} else if ( node.is( '.sponsored-image' ) ) {
					WikiaHubs.trackClick(
						'featured-video',
						Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
						'sponsoredimage',
						null,
						{},
						e
					);
				}
			} else if ( node.closest( '.wikiahubs-popular-videos' ).length > 0 ) {    // popular videos
				if ( node.hasClass( 'previous' ) ) {
					WikiaHubs.trackClick( 'popular-videos', Wikia.Tracker.ACTIONS.PAGINATE, 'previous', null, { }, e );
				}
			} else if ( node.closest( '.wikiahubs-popular-videos' ).length > 0 ) {    // popular videos
				if ( node.hasClass( 'previous' ) ) {
					WikiaHubs.trackClick( 'popular-videos', Wikia.Tracker.ACTIONS.PAGINATE, 'previous', null, { }, e );
				}
				else if ( node.hasClass( 'next' ) ) {
					WikiaHubs.trackClick( 'popular-videos', Wikia.Tracker.ACTIONS.PAGINATE, 'next', null, { }, e );
				}
			} else if ( node.closest( '.wikiahubs-from-the-community' ).length > 0 ) {    // From the Community
				if ( node.is( 'img' ) && node.hasParent( 'a' ) ) {
					url = node.closest( 'a' ).attr( 'href' );
					WikiaHubs.trackClick(
						'suggest-article',
						Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
						'hero',
						null,
						{ href: url },
						e
					);
				} else if ( node.is( 'a' ) ) {
					url = node.closest( 'a' ).attr( 'href' );
					if ( node.closest( '.wikiahubs-ftc-title' ).length > 0 ) {
						WikiaHubs.trackClick(
							'suggest-article',
							Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
							'title',
							null,
							{ href: url },
							e
						);
					} else if ( node.closest( '.wikiahubs-ftc-subtitle' ).length > 0 ) {
						if ( node.is( 'a:first-child' ) ) {
							WikiaHubs.trackClick(
								'suggest-article',
								Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
								'username',
								null,
								{ href: url },
								e
							);
						} else {
							WikiaHubs.trackClick(
								'suggest-article',
								Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
								'wikiname',
								null,
								{ href: url },
								e
							);
						}
					}
				} else if ( node.is( '#suggestArticle' ) ) { //get promoted button
					WikiaHubs.trackClick(
						'suggest-article',
						Wikia.Tracker.ACTIONS.CLICK,
						'getpromotedbutton',
						null,
						{ },
						e
					);
				}
			} else if ( node.closest( '.wam-header' ).length > 0 ) {    // hub header
				if ( node.is( '.facebook' ) ) {
					WikiaHubs.trackClick( 'hub-header', Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'facebook', null, { }, e );
				} else if ( node.is( '.twitter' ) ) {
					WikiaHubs.trackClick( 'hub-header', Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'twitter', null, { }, e );
				} else if ( node.is( '.gplus' ) ) {
					WikiaHubs.trackClick( 'hub-header', Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'plus', null, { }, e );
				} else if ( node.is( '#HubSearch' ) ) {
					WikiaHubs.trackClick( 'hub-header', Wikia.Tracker.ACTIONS.CLICK, 'search', null, { }, e );
				}
			} else if ( node.closest( '.wikiahubs-explore' ).length > 0 ) {    // Explore
				if ( node.is( 'a' ) ) {
					url = node.closest( 'a' ).attr( 'href' );
					if ( node.hasParent( '.mw-headline' ) ) {
						WikiaHubs.trackClick(
							'explore',
							Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
							'title',
							null,
							{ href: url },
							e
						);
					} else {
						parentNode = node.closest( 'a' );
						allNodes = node.closest( '.explore-content' ).find( 'a' );
						itemIndex = allNodes.index( parentNode ) + 1;
						WikiaHubs.trackClick(
							'explore',
							Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
							'item',
							itemIndex,
							{ href: url },
							e
						);
					}
				}
			} else if ( node.closest( '.wikiahubs-newstabs' ).length > 0 ) {    // Wikia's Picks
				if ( node.is( 'a' ) ) {
					url = node.closest( 'a' ).attr( 'href' );
					WikiaHubs.trackClick(
						'wikias-picks',
						Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
						'link',
						null,
						{ href: url },
						e
					);
				} else if ( node.is( '.sponsored-image' ) ) {
					WikiaHubs.trackClick(
						'wikias-picks',
						Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
						'sponsoredimage',
						null,
						{},
						e
					);
				} else if ( node.is( 'img' ) ) {
					WikiaHubs.trackClick( 'wikias-picks', Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'image', null, { }, e );
				}
			} else if ( node.closest( '.wikiahubs-wam' ).length > 0 ) {    // WAM
				url = node.closest( 'a' ).attr( 'href' );
				rank = node.closest( 'tr' ).attr( 'data-rank' );
				if ( node.hasParent( '.wiki-thumb' ) ) {
					WikiaHubs.trackClick(
						'hub-wam',
						Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
						'wikithumbnail',
						null,
						{ href: url, rank: rank },
						e
					);
				} else if ( node.is( '.wiki-name' ) ) {
					WikiaHubs.trackClick(
						'hub-wam',
						Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
						'wikiname',
						null,
						{ href: url, rank: rank },
						e
					);
				} else if ( node.is( '.read-more' ) ) {
					WikiaHubs.trackClick(
						'hub-wam',
						Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
						'readmore',
						null,
						{ href: url },
						e
					);
				}
			} else if ( node.closest( '.wikiahubs-slider' ).length > 0 ) {    // Slider
				if ( node.closest( '.wikia-mosaic-slider-region' ).length > 0 ) {
					WikiaHubs.trackClick(
						'hub-slider',
						Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
						'slider-hero',
						null,
						{},
						e
					);
				} else if ( node.closest( '.wikia-mosaic-slide' ).length > 0 ) {

					parentNode = node.closest( 'li' );
					allNodes = node.closest( '.wikia-mosaic-thumb-region' ).find( 'li' );
					itemIndex = allNodes.index( parentNode ) + 1;
					WikiaHubs.trackClick(
						'hub-slider',
						Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
						'slider-thumb',
						itemIndex,
						{},
						e
					);
				}
			}

			$().log( 'tracking took ' + (new Date() - startTime) + ' ms' );
		},

		modalClickTrackingHandler: function( e ) {
			var node = $( e.target );

			if ( node.closest( '.VideoSuggestModal' ).length > 0 ) {
				if ( node.hasClass( 'submit' ) ) {
					WikiaHubs.trackClick( 'suggest-video', Wikia.Tracker.ACTIONS.SUBMIT, 'suggest', null, { }, e );
				}
			} else if ( node.closest( '.ArticleSuggestModal' ).length > 0 ) {
				if ( node.hasClass( 'submit' ) ) {
					WikiaHubs.trackClick( 'suggest-article', Wikia.Tracker.ACTIONS.SUBMIT, 'suggest', null, { }, e );
				}
			}
		}
	};

	return {
		init: WikiaHubs.init,
		trackClick: WikiaHubs.trackClick
	};
});

$( function() {
	'use strict';
	require(['wikia.hubs'], function (wikiaHubs) {
		$( '#carouselContainer' ).carousel();
		wikiaHubs.init();
	});
});

