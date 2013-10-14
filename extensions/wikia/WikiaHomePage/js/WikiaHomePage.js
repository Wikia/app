// From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
if (!Object.keys) {
	Object.keys = (function () {
		'use strict';
		var hasOwnProperty = Object.prototype.hasOwnProperty,
			hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
			dontEnums = [
				'toString',
				'toLocaleString',
				'valueOf',
				'hasOwnProperty',
				'isPrototypeOf',
				'propertyIsEnumerable',
				'constructor'
			],
			dontEnumsLength = dontEnums.length;

		return function (obj) {
			if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
				throw new TypeError('Object.keys called on non-object');
			}

			var result = [], prop, i;

			for (prop in obj) {
				if (hasOwnProperty.call(obj, prop)) {
					result.push(prop);
				}
			}

			if (hasDontEnumBug) {
				for (i = 0; i < dontEnumsLength; i++) {
					if (hasOwnProperty.call(obj, dontEnums[i])) {
						result.push(dontEnums[i]);
					}
				}
			}
			return result;
		};
	}());
}

var WikiaHomePageRemix = function () {
	this.WIKISETSTACKOFFSET = 2;
	this.NUMBEROFBATCHESTODOWNLOAD = 5;

	this.COLLECTIONS_LS_KEY = 'WHP_collections';
	this.COLLECTIONS_LS_VALIDITY = 12; // in hours
	this.SPONSOR_HERO_IMG_TIMEOUT = 3000;
	this.SPONSOR_HERO_IMG_CONTAINER_ID = 'WikiaHomePageHeroImage';
	this.SPONSOR_HERO_IMG_FADE_OUT_TIME = 800;

	this.wikiSetStack = [];
	this.wikiSetStackIndex = 0;

	var collections = window.wgCollectionsBatches || [];
	this.collectionsWikisStack = collections;
	this.remixesWhenShowCollection = [0, 3, 5];
	this.heroImageDisplayed = false;
	this.heroImage = null;
	
	function retriveHeroImageSrc() {
		var collectionsKeys = Object.keys(collections) || [];
		var firstCollection = collections[collectionsKeys[0]] || [];
		
		if( typeof(firstCollection['sponsor_hero_image']) !== 'undefined' && typeof(firstCollection['sponsor_hero_image']['url']) !== 'undefined' ) {
			return firstCollection['sponsor_hero_image']['url'];
		}
		
		return null;
	}
	
	this.heroImageSrc = retriveHeroImageSrc();
	if( this.heroImageSrc !== null ) {
		$().log('Preloading hero image...');
		this.heroImage = new Image();
		this.heroImage.src = this.heroImageSrc;
	}
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
		this.wikiSetStack = window.wgInitialWikiBatchesForVisualization;

		this.statsContainer = $('#WikiaHomePageStats');
		this.initCollectionRemixVariables();

		$('#WikiaArticle').on(
			'mousedown',
			'.WikiaHomePage',
			$.proxy(this.trackClick, this)
		);

		$(".remix-button").click($.proxy(
			function (event) {
				event.preventDefault();
				this.remixHandler();
			}, this)
		);
		
		$(".collection-link").click($.proxy(
			function( event ) {
				var collectionId = $(event.target).data('collection-id') || 0;
				this.displayCollection(collectionId);
			}, this)
		);
		
		$('#WikiaHomePageSponsorImage').on(
			'click', 
			'.sponsor-image-link', 
			$.proxy(this.trackClick, this)
		);

		// show / hide collections dropdown
		var $collectionsDropdown = $(".collections-dropdown");
		$('body').on('click', '.collections-button',
			function (event) {
				event.preventDefault();
				$collectionsDropdown.toggleClass("show");
			}
		).on('click', $.proxy(function(event) {
				var $target = $(event.target);
				if(this.isTargetOutsideRemixChevron($target)) {
					$collectionsDropdown.removeClass('show');
				}
			}, this)
		);

		$('.wikia-slot a').removeAttr('title');

		this.remixHandler();
		$().log('WikiaHomePageRemix initialised');
	},
	isTargetOutsideRemixChevron: function ($target) {
		return !($target.is('.collections-button') || $target.is('.collections-button .chevron'));
	},

	track: function(action, label, params, event) {
		Wikia.Tracker.track({
			action: action,
			browserEvent: event,
			category: 'wikia-home-page',
			label: label,
			trackingMethod: 'both'
		}, params);
	},
	trackClick: function(ev) {
		var node = $(ev.target);
		
		if( node.hasParent('.remix-button') || node.hasClass('remix-button') ) {
			var remixCounter = $.storage.get('remixCounter') || 0;
			remixCounter++;
			this.track(
				Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				'remix',
				{remixCounter: remixCounter}
			);
			$.storage.set('remixCounter', remixCounter);
		}
		else if (node.hasParent('.goPreview') || node.is('.goPreview')) {
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'preview', {}, ev);
		}
		else if (node.hasParent('.goVisit') || node.is('.goVisit')) {
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'visit', {}, ev);
		}
		else if (node.hasParent('.wikia-slot')) {
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'slot-image', {}, ev);
		}
		else if (node.is('.create-wiki')) {
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'create-wiki', {}, ev);
		}
		else if (node.hasParent('.wikiahomepage-hubs-section')) {
			if (node.hasParent('.videogames') && node.is('img')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-image-videogames', {}, ev);
			}
			else if (node.hasParent('.entertainment') && node.is('img')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-image-entertainment', {}, ev);
			}
			else if (node.hasParent('.lifestyle') && node.is('img')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'hubs-image-lifestyle', {}, ev);
			}
			else if (node.is('a')) {
				this.track(
					Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
					'hubs-link',
					{href: node.attr('href'), anchor: node.text()},
					ev
				);
			}
		}
		else if (node.hasParent('.WikiPreviewInterstitial')) {
			if (node.hasParent('.carousel')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'interstitial-carousel', {}, ev);
			}
			else if (node.is('.hero-image')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'interstitial-hero-image', {}, ev);
			}
			else if (node.is('.close-button')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'interstitial-close', {}, ev);
			}
			else if (node.hasParent('.user-page')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT, 'interstitial-user-page', {}, ev);
			}
			else if (node.hasParent('.user-contributions')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT, 'interstitial-user-contributions', {}, ev);
			}
			else if (node.is('.visit') || node.hasParent('.visit')) {
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'interstitial-visit', {}, ev);
			}
			else if ( node.hasParent('.wam') ) {
				var wamLinkState = (node.hasClass('inactive') || node.hasParent('.inactive')) ? 'inactive' : 'active';
				this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'interstitial-wam-score', {'wam-link-state': wamLinkState}, ev);
			}
		} else if( node.hasClass('collections-button') || node.hasParent('.collections-button') ) {
			var collectionListState = ( $('.collections-dropdown').hasClass('show') ) ? 'shown' : 'hidden';
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'collections-button', {'collection-list-state': collectionListState}, ev);
		} else if( node.hasClass('collection-link') || node.hasParent('.collection-link') ) {
			var collectionId = node.data('collection-id');
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'collections-link', {'collection-id': collectionId}, ev);
		} else if( node.hasClass('sponsor-image-link') ) {
			var collectionId = node.data('collection-id');
			var isLink = node.hasParent('a');
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'collection-sponsor', {'collection-id': collectionId, 'is-link': isLink}, ev);
		}
	},
	preload: function () {
		if (typeof this.wikiSetStack[this.wikiSetStackIndex] != 'undefined') {
			var allWikisInBatch = this.wikiSetStack[this.wikiSetStackIndex].mediumslots;
			allWikisInBatch = allWikisInBatch.concat(this.wikiSetStack[this.wikiSetStackIndex].smallslots);
			allWikisInBatch = allWikisInBatch.concat(this.wikiSetStack[this.wikiSetStackIndex].bigslots);
			for (var i in allWikisInBatch) {
				var image = new Image();
				image.src = allWikisInBatch[i].image;
			}
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

			this.showStats();

			$().log('WikiaHomePageRemix data remixed');
		} else {
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

	remixHandler: function() {
		var collectionId = this.getNextCollectionId();
		if (collectionId) {
			this.displayCollection(collectionId);
			this.displaySponsorHeroImage(collectionId);

			this.track(Wikia.Tracker.ACTIONS.IMPRESSION, 'collection-remix', {'collection-id': collectionId, 'remix-count': this.remixCount});
		} else {
			this.updateVisualisation();
		}
	},

	displayCollection: function(collectionId) {
		var selectedCollection;
		if (typeof collectionId === 'undefined' || !(collectionId in this.collectionsWikisStack)) {
			var avaliableCollectionIds = Object.keys(this.collectionsWikisStack);
			if (avaliableCollectionIds.length) {
				collectionId = avaliableCollectionIds[0];
			} else {
				this.updateVisualisation();
				return false;
			}
		}

		this.markCollectionAsShown(collectionId);
		$().log('displaying collection #' + collectionId);
		
		selectedCollection = this.collectionsWikisStack[collectionId];
		selectedCollection['collection_id'] = collectionId;

		this.remix($('.slot-medium'), selectedCollection.mediumslots);
		this.remix($('.slot-small'), selectedCollection.smallslots);
		this.remix($('.slot-big'), selectedCollection.bigslots);

		if( 'sponsor_image' in selectedCollection ) {
			var container = this.createSponsorImageContainer(selectedCollection);
			$('#WikiaHomePageSponsorImage').remove();
			this.statsContainer
				.hide()
				.after(container);
		} else {
			this.showStats();
		}
	},

	initCollectionRemixVariables: function() {
		this.remixCount = 0;
		this.shownCollections = {};
		for (collectionId in this.collectionsWikisStack) {
			if (this.collectionsWikisStack.hasOwnProperty(collectionId)) {
				this.shownCollections[collectionId] = false;
			}
		}

		var lsData = $.storage.get(this.COLLECTIONS_LS_KEY);
		var lsShownCollections;
		if (lsData) {
			if ('date' in lsData && 'collections' in lsData) {
				var tmpDate = new Date();
				tmpDate.setHours(tmpDate.getHours() - this.COLLECTIONS_LS_VALIDITY);
				if (new Date(lsData.date) > tmpDate) {
					lsShownCollections = lsData.collections;
					if ('remixCount' in lsData) {
						this.remixCount = lsData.remixCount;
					}
				}
			}

			if (lsShownCollections) {
				$.extend(this.shownCollections, lsShownCollections);
			} else {
				$.storage.set(this.COLLECTIONS_LS_KEY, null);
			}
		}
	},

	icreaseRemixCount: function() {
		this.remixCount++;
		this.saveLSData({remixCount: this.remixCount});
	},

	markCollectionAsShown: function(collectionId) {
		this.shownCollections[collectionId] = true;
		this.saveLSData({collectionId: collectionId});
	},

	saveLSData: function(data) {
		var lsData = $.storage.get(this.COLLECTIONS_LS_KEY);
		if (!lsData) {
			lsData = {};
		}

		if (!('collections' in lsData)) {
			lsData.collections = {};
		}
		if ('collectionId' in data) {
			lsData.collections[data.collectionId] = true;
		}
		if ('remixCount' in data) {
			lsData.remixCount = data.remixCount;
		}

		if (!('date' in lsData)) {
			lsData.date = new Date();
		}

		$.storage.set(this.COLLECTIONS_LS_KEY, lsData);
	},

	getNextCollectionId: function() {
		var nextCollectionId;
		var out;

		for (collectionId in this.shownCollections) {
			if (this.shownCollections.hasOwnProperty(collectionId) && !this.shownCollections[collectionId]) {
				nextCollectionId = collectionId;
				break;
			}
		}

		if (nextCollectionId && $.inArray(this.remixCount, this.remixesWhenShowCollection) > -1) {
			out = nextCollectionId;
		}

		this.icreaseRemixCount();

		return out;
	},

	showStats: function() {
		this.statsContainer.show();
		$('#WikiaHomePageSponsorImage').remove();
	},

	createSponsorImageContainer: function(collection) {
		var imgData = collection['sponsor_image'];
		var img = $('<img />')
			.attr('alt', imgData['title'])
			.attr('witdh', imgData['width'])
			.attr('witdh', imgData['height'])
			.attr('src', imgData['url'])
			.addClass('sponsor-image-link')
			.data('collection-id', collection['collection_id']);

		var container = $('<div />')
			.attr('id', 'WikiaHomePageSponsorImage')
			.addClass('grid-2');

		if ('sponsor_url' in collection) {
			var link = $('<a />').attr('href', collection['sponsor_url']);
			link.append(img);
			container.append(link);
		} else {
			container.append(img);
		}
		return container;
	},

	createHeroImageContainer: function() {
		var imgData = this.getFirstCollection()['sponsor_hero_image'];
		
		if( this.heroImage !== null ) {
			var img = $(this.heroImage)
				.attr('alt', imgData['title'])
				.attr('witdh', imgData['width'])
				.attr('witdh', imgData['height']);

			var container = $('<div />').attr('id', this.SPONSOR_HERO_IMG_CONTAINER_ID);
			container.append(img);
		}
		
		return container;
	},
	
	displaySponsorHeroImage: function(collectionId) {
		if( this.isFirstCollection(collectionId) && !this.heroImageDisplayed ) {
			var heroContainer = this.createHeroImageContainer();
			$('#visualization').append(heroContainer);
			this.heroImageDisplayed = true;
		}
	},

	isFirstCollection: function(collectionId) {
		return (collectionId === this.getFirstCollectionId());
	},
	
	getFirstCollectionId: function() {
		return Object.keys(this.collectionsWikisStack)[0];
	},
	
	getFirstCollection: function() {
		return this.collectionsWikisStack[ this.getFirstCollectionId() ];
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

$(window).load(function() {
	setTimeout(function() {
		$('#' + WikiaRemixInstance.SPONSOR_HERO_IMG_CONTAINER_ID).fadeOut(WikiaRemixInstance.SPONSOR_HERO_IMG_FADE_OUT_TIME);
	}, WikiaRemixInstance.SPONSOR_HERO_IMG_TIMEOUT);
});
