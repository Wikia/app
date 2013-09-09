require( [ 'sloth', 'wikia.nirvana', 'wikia.window', 'wikia.loader', 'wikia.mustache', 'JSMessages' ], function( sloth, nirvana, w, loader, mustache, msg ){
	'use strict';

	var isMobileSkin = (w.skin === 'wikiamobile' ? true : false);

	var $placeholder = $('#RelatedPagesPlaceholder'),
		element = ( $placeholder[0] ) ? $placeholder[0] : false, // $placeholder[0] because sloth doesn't accept jQuery objects
		controller = 'RelatedPagesApi',
		method = 'getList';

	if( isMobileSkin ) {
		$placeholder = $('#wkRltdCnt');
		element = $placeholder[0]; // sloth doesn't accept jQuery objects
	}

	if( element ) {
		sloth({
			on: element,
			threshold: 100,
			callback: function() {
				loader({
					type: loader.MULTI,
					resources: {
						mustache: 'extensions/wikia/RelatedPages/templates/RelatedPages_section.mustache',
						templates: [{
							controller: controller,
							method: method,
							params: {
								ids: w.wgArticleId
							}
						}],
						messages: 'RelatedPages'
					}
				}).done(
					function(data) {
						var items = JSON.parse(data.templates[controller + '_' + method]).items,
							pages = items && items[w.wgArticleId],
							mustacheData = {
								relatedPagesHeading: msg( 'wikiarelatedpages-heading' ),
								imgWidth: (isMobileSkin ? 100 : 200),
								imgHeight: (isMobileSkin ? 50 : 100),
								mobileSkin: isMobileSkin,
								relatedPages: []
							},
							artImgPlaceholder = (isMobileSkin ? w.wgCdnRootUrl + '/extensions/wikia/WikiaMobile/images/read_placeholder.png' : '');

						if( pages && pages.length ) {
							var page,
								i = 0;

							while( page = pages[i++] ) {
								var relatedPage = {};
								relatedPage.pageUrl = page.url;
								relatedPage.pageTitle = page.title;
								relatedPage.imgUrl = ( page.imgUrl ? page.imgUrl : artImgPlaceholder );
								relatedPage.artSnippet = page.text;

								mustacheData.relatedPages.push( relatedPage );
							}

							$placeholder.append( mustache.render( data.mustache[0], mustacheData ) );
						} else {
							if( !isMobileSkin ) {
								$placeholder.remove();
							}
						}
					}
				);
			}
		});
	}
});
