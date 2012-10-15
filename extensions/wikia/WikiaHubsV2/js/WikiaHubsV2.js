var WikiaHubs = {
	init: function () {
		WikiaHubs.el = $('#WikiaHubs');
		WikiaHubs.el.click(WikiaHubs.clickTrackingHandler);

		// Featured Video
		$('#WikiaHubs .wikiahubs-sponsored-video .thumbinner').mousedown(function (e) {
			if ($(e.target).is('embed')) {
				WikiaHubs.clickTrackingHandler(e);
			}
		});

		// FB iFrame
		var WikiaFrame = $('.WikiaFrame');
		if (WikiaFrame.length > 0) {
			WikiaFrame.on('click', 'a', WikiaHubs.iframeLinkChanger);
			window.onFBloaded = function () {
				FB.init();
				FB.XFBML.parse();
				FB.Canvas.setAutoGrow();
			};
		}

		$('body').on('click', '.modalWrapper', WikiaHubs.modalClickTrackingHandler);
	},

	iframeLinkChanger: function (e) {
		e.preventDefault();
		var node = $(e.target).closest('a');
		window.top.location = node.attr('href');
		return false;
	},

	trackClick: function (category, action, label, value, params) {
		var trackingObj = {
			ga_category: category,
			ga_action: action,
			ga_label: label
		};

		if (value) {
			trackingObj['ga_value'] = value;
		}

		if (params) {
			$.extend(trackingObj, params);
		}

		WikiaTracker.trackEvent(
			'trackingevent',
			trackingObj,
			'internal'
		);
	},

	clickTrackingHandler: function (e) {
		var node = $(e.target),
			startTime = new Date(),
			url,
			lang;

		lang = wgContentLanguage;

		if (node.closest('.wikiahubs-sponsored-video').length > 0) {    // featured video
			if (node.hasClass('thumbinner') || node.hasParent('.thumbinner')) {
				url = node.closest('.thumbinner').find('a').attr('href');
				var videoTitle = url.substr(url.indexOf(':') + 1);
				WikiaHubs.trackClick('FeaturedVideo', WikiaTracker.ACTIONS.PLAY_VIDEO, 'play', null, {video_title: videoTitle, lang: lang});
			} else if (node.is('a')) {
				url = node.closest('a').attr('href');
				WikiaHubs.trackClick('FeaturedVideo', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'link', null, {href: url, lang: lang});
			}
		} else if (node.closest('.wikiahubs-popular-videos').length > 0) {    // suggest video
			if (node.is('#suggestVideo')) {
				WikiaHubs.trackClick('SuggestVideo', WikiaTracker.ACTIONS.CLICK, 'suggest', null, {lang: lang});
			}
		} else if (node.closest('.wikiahubs-from-the-community').length > 0) {    // suggest article
			if (node.is('img') && node.hasParent('a')) {
				url = node.closest('a').attr('href');
				WikiaHubs.trackClick('SuggestArticle', WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'hero', null, {href: url, lang: lang});
			} else if (node.is('a')) {
				url = node.closest('a').attr('href');
				if (node.closest('.wikiahubs-ftc-title').length > 0) {
					WikiaHubs.trackClick('SuggestArticle', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'title', null, {href: url, lang: lang});
				} else if (node.closest('.wikiahubs-ftc-subtitle').length > 0) {
					if (node.is('a:first-child')) {
						WikiaHubs.trackClick('SuggestArticle', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'username', null, {href: url, lang: lang});
					} else {
						WikiaHubs.trackClick('SuggestArticle', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'wikiname', null, {href: url, lang: lang});
					}
				}
			} else if (node.is('#suggestArticle')) {
				WikiaHubs.trackClick('SuggestArticle', WikiaTracker.ACTIONS.CLICK, 'suggest', null, {lang: lang});
			}
		} else if (node.closest('.wikiahubs-pulse').length > 0) {    // pulse
			if (node.is('#facebook')) {
				WikiaHubs.trackClick('Pulse', WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'facebook', null, {lang: lang});
			} else if (node.is('#twitter')) {
				WikiaHubs.trackClick('Pulse', WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'twitter', null, {lang: lang});
			} else if (node.is('#google')) {
				WikiaHubs.trackClick('Pulse', WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'plus', null, {lang: lang});
			} else if (node.is('#HubSearch')) {
				WikiaHubs.trackClick('Pulse', WikiaTracker.ACTIONS.CLICK, 'search', null, {lang: lang});
			} else if (node.closest('.mw-headline').length > 0) {
				if (node.is('a')) {
					url = node.closest('a').attr('href');
					WikiaHubs.trackClick('Pulse', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'wikiname', null, {href: url, lang: lang});
				}
			}
		} else if (node.closest('.wikiahubs-explore').length > 0) {    // Explore
			if (node.is('a')) {
				url = node.closest('a').attr('href');
				if (node.hasParent('.mw-headline')) {
					WikiaHubs.trackClick('Explore', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'title', null, {href: url, lang: lang});
				} else {
					var aNode = node.closest('a'),
						allANode = node.closest('.explore-content').find('a'),
						itemIndex = allANode.index(aNode) + 1;
					WikiaHubs.trackClick('Explore', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'item', itemIndex, {href: url, lang: lang});
				}
			}
		} else if (node.closest('.wikiahubs-top-wikis').length > 0) {    // TopWikis
			if (node.is('a')) {
				var liNode = node.closest('li'),
					allLiNode = node.closest('.top-wikis-content').find('li'),
					nameIndex = allLiNode.index(liNode) + 1;

				url = node.closest('a').attr('href');
				WikiaHubs.trackClick('TopWikis', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'wikiname', nameIndex, {href: url, lang: lang});
			}
		}

		$().log('tracking took ' + (new Date() - startTime) + ' ms');
	},

	modalClickTrackingHandler: function (e) {
		var node = $(e.target),
			lang = wgContentLanguage;

		if (node.closest('.VideoSuggestModal').length > 0) {
			if (node.hasClass('submit')) {
				WikiaHubs.trackClick('SuggestVideo', WikiaTracker.ACTIONS.SUBMIT, 'suggest', null, {lang: lang});
			}
		} else if (node.closest('.ArticleSuggestModal').length > 0) {
			if (node.hasClass('submit')) {
				WikiaHubs.trackClick('SuggestArticle', WikiaTracker.ACTIONS.SUBMIT, 'suggest', null, {lang: lang});
			}
		}
	}

};

$(function () {
	$('#carouselContainer').carousel();
	WikiaHubs.init();
});
