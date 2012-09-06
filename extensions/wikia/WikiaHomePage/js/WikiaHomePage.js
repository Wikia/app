var WikiaHomePageRemix = function (params) {
	this.NUMBEROFSLOTS = 17;
	this.PRELOADTIMEOUT = 200;
	this.WIKISETSTACKOFFSET = 3;
	this.NUMBEROFBATCHESTODOWNLOAD = 5;

	this.wikiSetStack = [];
	this.wikiSetStackIndex = 0;
};

function WikiPreview(el) {
	this.el = $(el);
	this.init();
	$().log('made preview');
}

var WikiPreviewInterstitial = {
	previewCache: {},
	init: function () {
		WikiPreviewInterstitial.mask = $('.WikiPreviewInterstitialMask');
		WikiPreviewInterstitial.el = $('.WikiPreviewInterstitial');
		WikiPreviewInterstitial.contentArea = WikiPreviewInterstitial.el.find('.content-area');

		$('#visualization').delegate('.wikia-slot', 'click', function (e) {
			var target = $(e.target);
			$().log(target);
			if (!target.hasClass('goVisit') && target.closest('.goVisit').length === 0) {
				e.preventDefault();
				var wikiId = $(this).data("wiki-id");
				WikiPreviewInterstitial.show();
				WikiPreviewInterstitial.loadContent(wikiId);
			}
		});

		$('.close-button').click(function (e) {
			WikiPreviewInterstitial.hide();
		});
	},
	loadContent: function (wikiId) {
		WikiPreviewInterstitial.el.removeClass('loaded');
		WikiPreviewInterstitial.el.startThrobbing();
		var cache = WikiPreviewInterstitial.previewCache[wikiId];
		if (cache) {
			WikiPreviewInterstitial.showContent(cache);
		} else {
			$.nirvana.sendRequest({
				type: 'post',
				format: 'html',
				controller: 'WikiaHomePage',
				method: 'getInterstitial',
				data: {
					wikiId: wikiId
				},
				callback: function (html) {
					var wikiPreview = new WikiPreview(html);
					WikiPreviewInterstitial.previewCache[wikiId] = wikiPreview;
					WikiPreviewInterstitial.showContent(wikiPreview);
					$('#carouselContainer').carousel({
						itemClick: WikiPreviewInterstitial.changeHeroImg
					});
					$('.WikiaMediaCarousel')
						.on('click', '.previous', function(e) {e.preventDefault();})
						.on('click', '.next', function(e) {e.preventDefault();})
						.find('.previous').addClass('disabled');
				}
			});
		}
	},
	showContent: function (wikiPreview) {
		WikiPreviewInterstitial.contentArea.children().detach();	// detach without unbinding events
		WikiPreviewInterstitial.contentArea.append(wikiPreview.el);
		WikiPreviewInterstitial.el.stopThrobbing();
		WikiPreviewInterstitial.el.addClass('loaded');
	},
	show: function () {
		if (!WikiPreviewInterstitial.mask.hasClass('hidden')) {
			if (WikiPreviewInterstitial.mask.hasClass('toggle')) {
				WikiPreviewInterstitial.mask.removeClass('toggle').addClass('toggle2');
			} else {
				WikiPreviewInterstitial.mask.removeClass('toggle2').addClass('toggle');
			}
		} else {
			WikiPreviewInterstitial.mask.removeClass('hidden');
		}
		var maskElement = document.getElementById('WikiPreviewInterstitialMask');
		if(maskElement) {
			maskElement.scrollIntoView();
		}
	},
	hide: function () {
		WikiPreviewInterstitial.mask
			.addClass('hidden')
			.addClass('overflow-hidden')
			.removeClass('overflow-visible');
	},
	changeHeroImg: function(e) {
		$(e.target).parents('.WikiPreviewInterstitial').find('.hero-image').attr(
			'src',
			$(e.target).data('bigimage')
		);
	}
};

WikiPreview.prototype = {
	AVATAR_HOVER_TIMEOUT: 750,

	init: function () {
		var avatars = this.el.find('.users .user');

		var popoverTimeout = 0;

		function setPopoverTimeout(elem) {
			popoverTimeout = setTimeout(function() {
				elem.popover('hide');
			}, 300);
		}

		avatars.popover({
			trigger: "manual",
			placement: "top",
			content: function() {
				return $(this).find('.details').clone().wrap('<div>').parent().html();
			}
		}).on('mouseenter', function() {
			clearTimeout(popoverTimeout);
			$('.popover').remove();
			$(this).popover('show');
		}).on('mouseleave', function() {
			var $this = $(this);
			setPopoverTimeout($this);
			$('.popover').mouseenter(function() {
				$().log("mouse re-entering");
				clearTimeout(popoverTimeout);
			}).mouseleave(function() {
					setPopoverTimeout($this);
			});
		});
	}
};

WikiaHomePageRemix.prototype = {
	init: function () {
		this.wikiSetStack = wgInitialWikiBatchesForVisualization;

		$('#WikiaArticle').on(
			'click',
			'.WikiaHomePage',
			$.proxy(this.trackClick, this)
		);

		$(".remix a").click($.proxy(
			function (event) {
				event.preventDefault();
				this.updateVisualisation();
			}, this));

		$('.wikia-slot a').removeAttr('title');

		this.updateVisualisation();
		$().log('WikiaHomePageRemix initialised');
	},
	track: function(action, label, params) {
		var trackObj = {
			ga_category: 'wikiaHomePage',
			ga_action: action,
			ga_label: label
		};
		if(params) {
			$.extend(trackObj, params);
		}
		WikiaTracker.trackEvent(
			'trackingevent',
			trackObj,
			'internal'
		);
	},
	trackClick: function(ev) {
		var node = $(ev.target);
		if (node.is('a') && node.hasParent('.remix')) {
			var remixCounter = $.storage.get('remixCounter') || 0;
			remixCounter++;
			this.track(
				WikiaTracker.ACTIONS.CLICK_LINK_BUTTON,
				'remix',
				{remixCounter: remixCounter}
			);
			$.storage.set('remixCounter', remixCounter);
		}
		else if (node.hasParent('.goPreview') || node.is('.goPreview')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'preview');
		}
		else if (node.hasParent('.goVisit') || node.is('.goVisit')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'visit');
		}
		else if (node.hasParent('.wikia-slot')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'slot-image');
		}
		else if (node.is('.create-wiki')) {
			this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'create-wiki');
		}
		else if (node.hasParent('.wikiahomepage-hubs-section')) {
			if (node.hasParent('.videogames') && node.is('img')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-image-videogames');
			}
			else if (node.hasParent('.entertainment') && node.is('img')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-image-entertainment');
			}
			else if (node.hasParent('.lifestyle') && node.is('img')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-image-lifestyle');
			}
			else if (node.is('a')) {
				this.track(
					WikiaTracker.ACTIONS.CLICK_LINK_TEXT,
					'hubs-link',
					{href: node.attr('href'), anchor: node.text()}
				);
			}
		}
		else if (node.hasParent('.WikiPreviewInterstitial')) {
			if (node.hasParent('.carousel')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'interstitial-carousel');
			}
			else if (node.is('.hero-image')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_IMAGE, 'interstitial-hero-image');
			}
			else if (node.is('.close-button')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'interstitial-close');
			}
			else if (node.hasParent('.user-page')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'interstitial-user-page');
			}
			else if (node.hasParent('.user-contributions')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'interstitial-user-contributions');
			}
			else if (node.is('.visit') || node.hasParent('.visit')) {
				this.track(WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'interstitial-visit');
			}
		}
	},
	preload: function () {
		var allWikisInBatch = this.wikiSetStack[this.wikiSetStackIndex].mediumslots;
		allWikisInBatch = allWikisInBatch.concat(this.wikiSetStack[this.wikiSetStackIndex].smallslots);
		allWikisInBatch = allWikisInBatch.concat(this.wikiSetStack[this.wikiSetStackIndex].bigslots);
		for (var i in allWikisInBatch) {
			var image = new Image();
			image.src = allWikisInBatch[i].image;
		}
	},
	updateVisualisation: function () {
		if (this.wikiSetStack.length !== this.wikiSetStackIndex) {
			$().log('WikiaHomePageRemix remixing (batch ' + this.wikiSetStackIndex + ')');
			this.remix($('.slot-medium'), this.wikiSetStack[this.wikiSetStackIndex].mediumslots);
			this.remix($('.slot-small'), this.wikiSetStack[this.wikiSetStackIndex].smallslots);
			this.remix($('.slot-big'), this.wikiSetStack[this.wikiSetStackIndex].bigslots);
			if (this.wikiSetStack.length - this.wikiSetStackIndex - this.WIKISETSTACKOFFSET <= 0) {
				this.addWikiToStack();
			}
			this.wikiSetStackIndex++;
			this.preload();
			$().log('WikiaHomePageRemix data remixed');
		}
		else {
			$().log('wikiSetStack is empty');
			$('.remix').startThrobbing();
		}
	},
	remix: function (getSlotCurrent, getSlotList) {
		getSlotCurrent.each(function(slotIndex, slot) {
			var listslot = getSlotList[slotIndex];
			var currentslot = $(slot);
			var currentlink = currentslot.find('a');
			if (currentlink.is('a')) {
				currentlink.attr('href', listslot.wikiurl);
				currentlink.attr('data-wikiurl', listslot.wikiurl);
			}
			currentslot.find('span').remove().end().find('img').attr('src', listslot.image);
			var wikinamehtml = $('<span class="hotNew"></span>');
			if (listslot.wikinew) {
				wikinamehtml.append('<strong class="new">' + $.msg('wikia-home-page-new') + '</strong>');
			}
			if (listslot.wikihot) {
				wikinamehtml.append('<strong class="hot">' + $.msg('wikia-home-page-hot') + '</strong>');
			}
			currentslot.data('wiki-id', listslot.wikiid);
			wikinamehtml.append(listslot.wikiname);
			var previewDiv = $('<div class="preview-pane"></div>');
			var previewDivWrapperClass = 'preview-pane-wrapper';
			var previewDivWrapper = $('<div class="'+previewDivWrapperClass+'"></div>');
			var previewVisitHtml;
			if (currentslot.hasClass('slot-small')) {
				previewVisitHtml = $('<span class="previewVisit"><a href="#" class="goPreview"><img src="' + wgBlankImgUrl + '" class="previcon" /></a><a href="' + listslot.wikiurl + '" class="goVisit"><img src="' + wgBlankImgUrl + '" class="visicon" /></span></a>');
			} else {
				previewVisitHtml = $('<span class="previewVisit"><a href="#" class="goPreview"><img src="' + wgBlankImgUrl + '" class="previcon" />' + $.msg('wikia-home-page-preview') + '</a><a href="' + listslot.wikiurl + '" class="goVisit"><img src="' + wgBlankImgUrl + '" class="visicon" />' + $.msg('wikia-home-page-visit') + '</span></a>');
			}
			previewDiv.append(wikinamehtml.clone()).append($('<span class="hotNewSeparator"></span>')).append(previewVisitHtml);
			previewDivWrapper.append(previewDiv);
			currentslot
				.find('.'+previewDivWrapperClass)
				.remove()
				.end()
				.append(wikinamehtml)
				.append(previewDivWrapper);
		});
	},
	addWikiToStack: function() {
		$.nirvana.sendRequest({
			type: 'post',
			format: 'json',
			controller: 'WikiaHomePage',
			method: 'getWikiBatchesForVisualization',
			data: {numberOfBatches: this.NUMBEROFBATCHESTODOWNLOAD},
			callback: $.proxy(function(response) {
				this.wikiSetStack = this.wikiSetStack.concat(response.wikis);
				$('.remix').stopThrobbing();
				$().log('WikiSet preloaded');
			}, this)
		});
	}
};

var WikiaRemixInstance = new WikiaHomePageRemix();
$(function () {
	WikiaRemixInstance.init();
	WikiPreviewInterstitial.init();
});
