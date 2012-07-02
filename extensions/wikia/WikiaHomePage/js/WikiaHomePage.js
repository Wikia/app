var WikiaHomePageRemix = function (params) {
	this.NUMBEROFSLOTS = 17;
	this.PRELOADTIMEOUT = 200;

	this.wikis = [];
	this.hotslots = 0;
	this.newslots = 0;
	this.currentset = [];
	this.newset = [];
	this.preloadlist = [];
	this.flatwikilist = [];
	this.listslots = [];
};

WikiaHomePageRemix.prototype = {
	randOrd: function () {
		return (Math.round(Math.random()) - 0.5);
	},
	/* important: O(N^2) so do not use for large sets */
	removeIntersectingElements: function (arrayFrom, arrayIntersecting, minimumElementsLeft) {
		if (typeof arrayIntersecting == 'undefined') {
			return arrayFrom;
		}
		var duplicatedindices = [];
		var tmparray = [];
		var outputarray = [];

		for (var newcount = 0, limit = arrayFrom.length; newcount < limit; newcount++) {
			for (var currentcount = 0; currentcount < arrayIntersecting.length; currentcount++) {
				if (arrayFrom[newcount] == arrayIntersecting[currentcount]) {
					duplicatedindices.push(newcount);
				}
			}
			tmparray.push(arrayFrom[newcount]);
		}

		for (var cutloop = 0, limit = duplicatedindices.length; cutloop < limit; cutloop++) {
			// we cannot leave less than minimum number
			if (tmparray.length > (minimumElementsLeft)) {
				tmparray[duplicatedindices[cutloop]] = null;
			}
		}

		for (var newcount = 0, limit = tmparray.length; newcount < limit; newcount++) {
			if (tmparray[newcount] != null) {
				outputarray.push(tmparray[newcount]);
			}
		}

		return outputarray;
	},
	init: function (wikiList) {
		$('#WikiaArticle').on(
			'click',
			'.WikiaHomePage',
			$.proxy(this.trackClick, this)
		);

		this.wikis = wikiList.wikis;
		this.hotslots = wikiList.slots.hotwikis;
		this.newslots = wikiList.slots.newwikis;

		$(".remix a").click($.proxy(
			function (event) {
				event.preventDefault();
				this.updateVisualisation();
			}, this));

		$('.wikia-slot a').removeAttr('title');

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
			var remixCounter = 0;
			if("localStorage" in window) {
				remixCounter = window.localStorage.getItem('remixCounter');
			}
			remixCounter++;
			this.track(
				WikiaTracker.ACTIONS.CLICK_LINK_BUTTON,
				'remix',
				{remixCounter: remixCounter}
			);
			if("localStorage" in window) {
				localStorage.setItem('remixCounter', remixCounter);
			}
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
	preloadnextimage: function () {
		if (this.preloadlist.length > 0) {
			var imagepath = this.preloadlist.pop();
			while (typeof imagepath != 'undefined') {
				var image = new Image();
				image.src = imagepath;
				imagepath = this.preloadlist.pop();
			}
		} else {
			$().log('WikiaHomePageRemix preload ended');
		}
	},
	preload: function () {
		this.flatwikilist = [];

		for (var verticalcount = 0, totalverticals = this.wikis.length; verticalcount < totalverticals; verticalcount++) {
			var newsetforvertical = this.newset[verticalcount];
			for (var wikicount = 0, limit = newsetforvertical.length; wikicount < limit; wikicount++) {
				this.flatwikilist.push(newsetforvertical[wikicount]);
			}
		}
		this.flatwikilist.sort(this.randOrd);

		this.listslots = [];

		$('#visualization .wikia-slot').each(
			$.proxy(function (slot, element) {
				if (typeof this.flatwikilist[slot] != 'undefined') {
					var jqelement = $(element);
					var listslot = this.flatwikilist[slot];
					if (jqelement.hasClass('slot-small')) {
						this.listslots.push(listslot.imagesmall);
					} else if (jqelement.hasClass('slot-medium')) {
						this.listslots.push(listslot.imagemedium);
					} else if (jqelement.hasClass('slot-big')) {
						this.listslots.push(listslot.imagebig);
					}
				}
			}, this));

		var numlistslots = this.listslots.length;

		for (var slotindex = 0; slotindex < numlistslots; slotindex++) {
			this.preloadlist.push(this.listslots[slotindex]);
		}
		$().log('WikiaHomePageRemix starting preload');
		this.preloadnextimage();
	},
	filterHot: function (val, index, reverse) {
		if (val.wikihot && !val.wikinew) {
			return true;
		}
		return false;
	},
	filterNew: function (val, index, reverse) {
		if (val.wikinew && !val.wikihot) {
			return true;
		}
		return false;
	},
	filterHotAndNew: function (val, index, reverse) {
		if (val.wikinew && val.wikihot) {
			return true;
		}
		return false;
	},
	filterNotHotNorNew: function (val, index, reverse) {
		if (!val.wikinew && !val.wikihot) {
			return true;
		}
		return false;
	},
	remix: function () {
		$().log('WikiaHomePageRemix remixing');
		var totalhotwikispulled = 0;
		var totalnewwikispulled = 0;

		this.newset = [];

		for (var verticalcount = 0, totalverticals = this.wikis.length; verticalcount < totalverticals; verticalcount++) {
			var verticalwikis = this.wikis[verticalcount];
			var requestednumberofverticalwikis = this.wikis[verticalcount].slots;
			var verticalwikisrandomized = verticalwikis.wikilist.sort(this.randOrd);
			var maxnumberofverticalhotwikis = Math.min(this.hotslots - totalhotwikispulled, requestednumberofverticalwikis);
			var numberofverticalhotwikis = Math.max(0, maxnumberofverticalhotwikis);
			var maxnumberofverticalnewwikis = Math.min(this.newslots - totalnewwikispulled, requestednumberofverticalwikis);
			var numberofverticalnewwikis = Math.max(0, maxnumberofverticalnewwikis);
			var numberofverticalhotnewwikis = Math.min(numberofverticalhotwikis, numberofverticalnewwikis);

			var hotwikisetforvertical = $.grep(verticalwikisrandomized, this.filterHot);
			var newwikisetforvertical = $.grep(verticalwikisrandomized, this.filterNew);
			var newandhotwikisetforvertical = $.grep(verticalwikisrandomized, this.filterHotAndNew);
			var newsetforvertical = $.grep(verticalwikisrandomized, this.filterNotHotNorNew);
			var currentsetforvertical = this.currentset[verticalcount];

			var remainingnumberofnonflaggedwikis = requestednumberofverticalwikis;

			if (typeof currentsetforvertical != 'undefined') {
				newandhotwikisetforvertical = this.removeIntersectingElements(newandhotwikisetforvertical, currentsetforvertical, 0);
				newandhotwikisetforvertical = newandhotwikisetforvertical.slice(0, numberofverticalhotnewwikis);
				hotwikisetforvertical = this.removeIntersectingElements(hotwikisetforvertical, currentsetforvertical, 0).slice(0, numberofverticalhotwikis - newandhotwikisetforvertical.length);
				newwikisetforvertical = this.removeIntersectingElements(newwikisetforvertical, currentsetforvertical, 0).slice(0, numberofverticalnewwikis - newandhotwikisetforvertical.length);
				remainingnumberofnonflaggedwikis = requestednumberofverticalwikis - newandhotwikisetforvertical.length - hotwikisetforvertical.length - newwikisetforvertical.length;

				newsetforvertical = this.removeIntersectingElements(newsetforvertical, currentsetforvertical, remainingnumberofnonflaggedwikis);
				newsetforvertical = newsetforvertical.slice(0, remainingnumberofnonflaggedwikis);
				newsetforvertical = [].concat(newandhotwikisetforvertical, hotwikisetforvertical, newwikisetforvertical, newsetforvertical);
			} else {
				// old set empty - just take the first half
				newandhotwikisetforvertical = newandhotwikisetforvertical.slice(0, numberofverticalhotnewwikis);
				hotwikisetforvertical = hotwikisetforvertical.slice(0, numberofverticalhotwikis - newandhotwikisetforvertical.length);
				newwikisetforvertical = newwikisetforvertical.slice(0, numberofverticalnewwikis - newandhotwikisetforvertical.length);
				remainingnumberofnonflaggedwikis = requestednumberofverticalwikis - newandhotwikisetforvertical.length - hotwikisetforvertical.length - newwikisetforvertical.length;
				newsetforvertical = newsetforvertical.slice(0, remainingnumberofnonflaggedwikis);

				newsetforvertical = [].concat(newandhotwikisetforvertical, hotwikisetforvertical, newwikisetforvertical, newsetforvertical);
			}

			var hotwikispulled = $.grep(newsetforvertical, this.filterHot).sort(this.randOrd).length + $.grep(newsetforvertical, this.filterHotAndNew).sort(this.randOrd).length;
			var newwikispulled = $.grep(newsetforvertical, this.filterNew).sort(this.randOrd).length + $.grep(newsetforvertical, this.filterHotAndNew).sort(this.randOrd).length;

			totalhotwikispulled += hotwikispulled;
			totalnewwikispulled += newwikispulled;

			// assign to newset
			this.newset[verticalcount] = newsetforvertical;
		}

		this.preload();
		$().log('WikiaHomePageRemix data remixed');
	},
	reassign: function () {
		$('#visualization .wikia-slot').each(
			$.proxy(
				function (slot,element) {
					if (typeof this.flatwikilist[slot] != 'undefined') {
						var currentslot = $(element);
						var listslot = this.flatwikilist[slot];
						currentslot.find('img').attr('src', this.listslots[slot]);

						var currentlink = currentslot.find('a');
						if (currentlink.is('a')) {
							currentlink.attr('href', listslot.wikiurl);
							currentlink.attr('data-wikiurl', listslot.wikiurl);
						}

						currentslot.find('span').remove();

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
						var previewDivWrapper = $('<div class="preview-pane-wrapper"></div>');
						if (currentslot.hasClass('slot-small')) {
							var previewVisitHtml = $('<span class="previewVisit"><a href="#" class="goPreview"><img src="' + wgBlankImgUrl + '" class="previcon" /></a><a href="' + listslot.wikiurl + '" class="goVisit"><img src="' + wgBlankImgUrl + '" class="visicon" /></span></a>');
						} else {
							var previewVisitHtml = $('<span class="previewVisit"><a href="#" class="goPreview"><img src="' + wgBlankImgUrl + '" class="previcon" />' + $.msg('wikia-home-page-preview') + '</a><a href="' + listslot.wikiurl + '" class="goVisit"><img src="' + wgBlankImgUrl + '" class="visicon" />' + $.msg('wikia-home-page-visit') + '</span></a>');
						}

						//previewVisitHtml.hide();
						previewDiv.append(wikinamehtml.clone()).append($('<span class="hotNewSeparator"></span>')).append(previewVisitHtml);
						previewDivWrapper.append(previewDiv);
						currentslot.append(wikinamehtml).append(previewDivWrapper);
					}
				},
				this
			)
		);
		// store set for avoiding duplicate wikis in next mix
		this.currentset = this.newset;
		$().log('WikiaHomePageRemix data assigned');
	},
	updateVisualisation: function () {
		this.reassign();
		this.remix();
	}
};

function WikiPreview(el) {
	this.el = $(el);
	this.init();
	$().log('made preview');
}

WikiPreview.prototype = {
	AVATAR_HOVER_TIMEOUT: 750,

	init: function () {
		this.avatars = this.el.find('.users .user');
		this.avatars.bind('mouseenter.wikipreview',
			function (e) {
				var node = $(this);	// dom node context, not object
				var timeoutHandle = node.data('timeoutHandle');
				clearTimeout(timeoutHandle);
				timeoutHandle = setTimeout(function () {
					node.find('.details').fadeIn('fast');
				}, this.AVATAR_HOVER_TIMEOUT);
				node.data('timeoutHandle', timeoutHandle);
				WikiPreviewInterstitial.mask.css('overflow', 'visible');	//reference WikiaPreviewInterstitial global and unmask for hover outside the mask
			}).bind('mouseleave.wikipreview', function (e) {
				var node = $(this);	// dom node context, not object
				var timeoutHandle = node.data('timeoutHandle');
				clearTimeout(timeoutHandle);
				timeoutHandle = setTimeout(function () {
					node.find('.details').fadeOut('fast');
				}, this.AVATAR_HOVER_TIMEOUT);
				node.data('timeoutHandle', timeoutHandle);
			});
	}
};

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
					$('.WikiaMediaCarousel .previous').addClass('disabled');
					$('.WikiaMediaCarousel').on('click', '.previous', function(e) {e.preventDefault()});
					$('.WikiaMediaCarousel').on('click', '.next', function(e) {e.preventDefault()});
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
	},
	hide: function () {
		WikiPreviewInterstitial.mask.css('overflow', 'hidden').addClass('hidden');
	},
	changeHeroImg: function(e) {
		$(e.target).parents('.WikiPreviewInterstitial').find('.hero-image').attr(
			'src',
			$(e.target).data('bigimage')
		);
	}
};

var WikiaRemixInstance = new WikiaHomePageRemix();
$(function () {
	WikiaRemixInstance.init(wgWikiaHomePageVisualizationData);
	WikiaRemixInstance.remix();
	WikiaRemixInstance.updateVisualisation();
	WikiaRemixInstance.preload();

	WikiPreviewInterstitial.init();
});
