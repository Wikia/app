/* global wgServer wgArticlePath wgPageName $*/

/**
 * @define share
 * module used to handle sharing of a page and image
 *
 * @define share
 * @require cache
 *
 * @author Jakub Olek
 */
define('share', ['wikia.cache', 'JSMessages', 'wikia.loader', 'wikia.window'], function (cache, msg, loader, w) {
	'use strict';

	var shrData,
		pageUrl = w.wgServer + w.wgArticlePath.replace('$1', w.wgPageName),
		shrImgTxt,
		shrPageTxt,
		shrMailPageTxt,
		shrMailImgTxt,
		$1 = /__1__/g,
		$2 = /__2__/g,
		$3 = /__3__/g,
		$4 = /__4__/g;

	return function(link){
		return function(cnt){
			var cacheKey = 'shareButtons' + w.wgStyleVersion;

			function handle(html){
				if(link){
					var imgUrl = pageUrl + '?file=' + encodeURIComponent(encodeURIComponent(link));
					cnt.innerHTML = html.replace($1, imgUrl).replace($2, shrImgTxt).replace($3, shrMailImgTxt).replace($4, shrImgTxt);
				}else{
					cnt.innerHTML = html.replace($1, pageUrl).replace($2, shrPageTxt).replace($3, shrMailPageTxt).replace($4, shrPageTxt);
				}
			}

			if(!shrData){
				shrData = cache.get(cacheKey);
				loader.processStyle(cache.get(cacheKey + 'style'));
				shrPageTxt = msg('wikiamobile-sharing-page-text', w.wgTitle, w.wgSitename);
				shrMailPageTxt = encodeURIComponent(msg('wikiamobile-sharing-email-text', shrPageTxt));
				shrImgTxt = msg('wikiamobile-sharing-modal-text', msg('wikiamobile-sharing-media-image'), w.wgTitle, w.wgSitename);
				shrMailImgTxt = encodeURIComponent(msg('wikiamobile-sharing-email-text', shrImgTxt));
			}

			if(shrData){
				handle(shrData);
			}else{
				loader({
					type: loader.MULTI,
					resources: {
						templates: [{
							controller: 'WikiaMobileSharingService',
							method: 'index'
						}],
						styles: '/extensions/wikia/WikiaMobile/css/sharing.scss',
						ttl: 86400
					}
				}).done(
					function(res){
						var html = res.templates.WikiaMobileSharingService_index,
							style = res.styles;

						loader.processStyle(style);
						cache.set(cacheKey, html, 604800);/*7 days*/
						cache.set(cacheKey + 'style', style, 604800);
						shrData = html;
						handle(html);
					}
				)
			}
		};
	};
});
