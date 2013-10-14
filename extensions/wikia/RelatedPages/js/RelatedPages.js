require( [ 'sloth', 'wikia.window', 'jquery' ], function( sloth, w, $ ){
	'use strict';

	var $placeholder, isMobileSkin = false;

	switch( w.skin ) {
		case 'wikiamobile':
			$placeholder = $( '#wkRltdCnt' );
			isMobileSkin = true;
			break;
		case 'oasis':
			$placeholder = $( '#WikiaArticleFooter' );
			break;
		case 'monobook':
			$placeholder = $( '#mw-data-after-content' );
			break;
	}

	var element = $placeholder[0], // $placeholder[0] because sloth doesn't accept jQuery objects
		cacheKey = 'RelatedPagesAssets',
		articleId = w.wgArticleId;

	/**
	 * Checks if template is cached in LocalStorage and if not loads it by using loader
	 * @returns {$.Deferred}
	 */
	function loadTemplate(){
		var dfd = new $.Deferred();

		require(['wikia.loader', 'wikia.cache'], function(loader, cache) {
			var template = cache.getVersioned(cacheKey);

			if(template) {
				dfd.resolve(template);
			} else {
				loader({
					type: loader.MULTI,
					resources: {
						mustache: 'extensions/wikia/RelatedPages/templates/RelatedPages_section.mustache'
					}
				}).done(function(data){
					template = data.mustache[0];

					dfd.resolve(template);

					cache.setVersioned(cacheKey, template, 604800); //7days
				});
			}

		});

		return dfd.promise();
	}

	if( element && articleId ) {
		sloth({
			on: element,
			threshold: 200,
			callback: function() {
				require([ 'wikia.mustache', 'JSMessages', 'wikia.nirvana', 'wikia.tracker' ], function( mustache, msg, nirvana, tracker ) {
					$.when(
						nirvana.getJson(
							'RelatedPagesApi',
							'getList',
							{ ids: [articleId] }
						),
						loadTemplate()
					).done(function(data ,template){
						var items = data[0] && data[0].items,
							pages = items && items[articleId],
							relatedPages =  [],
							artImgPlaceholder = (isMobileSkin ? w.wgCdnRootUrl + '/extensions/wikia/WikiaMobile/images/read_placeholder.png' : ''),
							page,
							mustacheData;

						if( pages && pages.length ) {
							while( page = pages.shift() ) {
								relatedPages.push( {
									pageUrl: page.url,
									pageTitle: page.title,
									imgUrl: ( page.imgUrl ? page.imgUrl : artImgPlaceholder ),
									artSnippet: page.text
								} );
							}

							mustacheData = {
								relatedPagesHeading: msg( 'wikiarelatedpages-heading' ),
								imgWidth: (isMobileSkin ? 100 : 200),
								imgHeight: (isMobileSkin ? 50 : 100),
								mobileSkin: isMobileSkin,
								pages: relatedPages
							};

							$placeholder.prepend( mustache.render( template, mustacheData ) );
							$placeholder.on( 'mousedown', '.RelatedPagesModule a', function( event ) {
								// Primary mouse button only
								if( event.type === 'mousedown' && event.which !== 1 ) {
									return;
								}

								tracker.track({
									action: Wikia.Tracker.ACTIONS.CLICK,
									trackingMethod: 'ga',
									category: 'article',
									label: 'related-pages'
								});
							})
						}
					});
				});
			}
		});
	}
});
