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

	this.SPONSOR_HERO_IMG_TIMEOUT = 3000;
	this.SPONSOR_HERO_IMG_CONTAINER_ID = 'WikiaHomePageHeroImage';
	this.SPONSOR_HERO_IMG_FADE_OUT_TIME = 800;
	this.SPONSOR_HERO_IMG_VALIDITY = 12; // in hours
	this.SPONSOR_HERO_IMAGE_STORAGE_KEY = 'WikiaHomePageHeroImageDisplayed';

	this.wikiSetStack = [];
	this.wikiSetStackIndex = 0;

	this.collections = window.wgCollectionsBatches || [];
	this.remixesWhenShowCollection = [0, 3, 5];
	this.heroImage = null;
	
	function retriveHeroImageSrc(collections) {
		var firstCollection = collections[0] || [];
		
		if( typeof(firstCollection.sponsor_hero_image) !== 'undefined' && typeof(firstCollection.sponsor_hero_image.url) !== 'undefined' ) {
			return firstCollection.sponsor_hero_image.url;
		}
		
		return null;
	}
	
	this.heroImageSrc = retriveHeroImageSrc(this.collections);
	if( this.heroImageSrc !== null ) {
		this.heroImage = new Image();
		this.heroImage.src = this.heroImageSrc;
	}
};

function WikiPreview(el) {
	this.el = $(el);
	this.init();
}

var WikiPreviewInterstitial = {
	previewCache: {},
	init: function () {
		WikiPreviewInterstitial.mask = $('.WikiPreviewInterstitialMask');
		WikiPreviewInterstitial.el = $('.WikiPreviewInterstitial');
		WikiPreviewInterstitial.contentArea = WikiPreviewInterstitial.el.find('.content-area');

		$('#visualization').delegate('.wikia-slot', 'click', function (e) {
			var target = $(e.target ),
				wikiId;

			if (!target.hasClass('goVisit') && target.closest('.goVisit').length === 0) {
				e.preventDefault();
				wikiId = $(this).data('wiki-id');
				WikiPreviewInterstitial.show();
				WikiPreviewInterstitial.loadContent(wikiId);
			}
		});

		$('.close-button').click(function (e) {
			WikiPreviewInterstitial.hide();
		});

		$('.tooltip-icon').tooltip();

	},
	loadContent: function (wikiId) {
		WikiPreviewInterstitial.el.removeClass('loaded');
		WikiPreviewInterstitial.el.startThrobbing();
		var cache = WikiPreviewInterstitial.previewCache[wikiId];
		if (cache) {
			WikiPreviewInterstitial.showContent(cache);
		} else {
			$.nirvana.sendRequest({
				type: 'get',
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
		var avatars = this.el.find('.users .user' ),
			popoverTimeout = 0;

		function setPopoverTimeout(elem) {
			popoverTimeout = setTimeout(function() {
				elem.popover('hide');
			}, 300);
		}

		avatars.popover({
			trigger: 'manual',
			placement: 'top',
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

		$('.remix-button').click($.proxy(
			function (event) {
				event.preventDefault();
				this.remixHandler();
			}, this)
		);
		
		$('.collection-link').click($.proxy(
			function( event ) {
				var collectionIndex = $( '.collections-dropdown li' ).index( event.target ) || 0;
				this.displayCollection(collectionIndex);
			}, this)
		);
		
		$('#WikiaHomePageSponsorImage').on(
			'click',
			'.sponsor-image-link',
			$.proxy(this.trackClick, this)
		);

		// show / hide collections dropdown
		var $collectionsDropdown = $('.collections-dropdown');
		$('body').on('click', '.collections-button',
			function (event) {
				event.preventDefault();
				$collectionsDropdown.toggleClass('show');
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
			trackingMethod: 'analytics'
		}, params);
	},
	trackClick: function(ev) {
		var node = $(ev.target ),
			remixCounter = 0,
			collectionId,
			isLink;
		
		if( node.hasParent('.remix-button') || node.hasClass('remix-button') ) {
			remixCounter = $.storage.get('remixCounter') || 0;
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
			collectionListState = ( $('.collections-dropdown').hasClass('show') ) ? 'shown' : 'hidden';
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'collections-button', {'collection-list-state': collectionListState}, ev);
		} else if( node.hasClass('collection-link') || node.hasParent('.collection-link') ) {
			collectionId = node.data('collection-id');
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'collections-link', {'collection-id': collectionId}, ev);
		} else if( node.hasClass('sponsor-image-link') ) {
			collectionId = node.data('collection-id' );
			isLink = node.hasParent('a');
			this.track(Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'collection-sponsor', {'collection-id': collectionId, 'is-link': isLink}, ev);
		}
	},
	preload: function () {
		var i,
			image,
			allWikisInBatch;

		if (typeof this.wikiSetStack[this.wikiSetStackIndex] != 'undefined') {
			allWikisInBatch = this.wikiSetStack[this.wikiSetStackIndex].mediumslots;
			allWikisInBatch = allWikisInBatch.concat(this.wikiSetStack[this.wikiSetStackIndex].smallslots);
			allWikisInBatch = allWikisInBatch.concat(this.wikiSetStack[this.wikiSetStackIndex].bigslots);
			for (i in allWikisInBatch) {
				image = new Image();
				image.src = allWikisInBatch[i].image;
			}
		}
	},
	updateVisualisation: function () {
		if (this.wikiSetStack.length !== this.wikiSetStackIndex) {
			this.remix($('.slot-medium'), this.wikiSetStack[this.wikiSetStackIndex].mediumslots);
			this.remix($('.slot-small'), this.wikiSetStack[this.wikiSetStackIndex].smallslots);
			this.remix($('.slot-big'), this.wikiSetStack[this.wikiSetStackIndex].bigslots);
			if (this.wikiSetStack.length - this.wikiSetStackIndex - this.WIKISETSTACKOFFSET <= 0) {
				this.fetchMoreWikis();
			}
			this.wikiSetStackIndex++;
			this.preload();

			this.showStats();
		} else {
			$('.remix').startThrobbing();
		}
	},
	remix: function (getSlotCurrent, getSlotList) {
		getSlotCurrent.each(function(slotIndex, slot) {
			var listslot = getSlotList[slotIndex],
				currentslot = $(slot ),
				currentlink = currentslot.find('a' ),
				wikinamehtml = $('<span class="hotNew"></span>' ),
				previewDiv = $('<div class="preview-pane"></div>' ),
				previewDivWrapperClass = 'preview-pane-wrapper',
				previewDivWrapper = $('<div class="'+previewDivWrapperClass+'"></div>'),
				previewVisitHtml;

			if (listslot) {
				if (currentlink.is('a')) {
					currentlink.attr('href', listslot.wikiurl);
					currentlink.attr('data-wikiurl', listslot.wikiurl);
				}
				currentslot.find('span').remove().end().find('img').attr('src', listslot.image);
				currentslot.data('wiki-id', listslot.wikiid);
				wikinamehtml.append(listslot.wikiname);

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
			}
		});
	},

	remixHandler: function() {
		var collectionIndex = this.getNextCollectionIndex();
		if (collectionIndex !== undefined) {
			this.displayCollection(collectionIndex);
			this.displaySponsorHeroImage(collectionIndex);

			this.track(Wikia.Tracker.ACTIONS.IMPRESSION, 'collection-remix', {'collection-id': collectionIndex, 'remix-count': this.remixCount});
		} else {
			this.updateVisualisation();
		}
	},

	displayCollection: function(collectionIndex) {
		var selectedCollection,
			container;

		if (typeof collectionIndex === 'undefined' || collectionIndex > this.collections.length ) {
			if (this.collections.length) {
				collectionIndex = 0;
			} else {
				this.updateVisualisation();
				return false;
			}
		}

		this.markCollectionAsShown(collectionIndex);
		
		selectedCollection = this.collections[collectionIndex];

		this.remix($('.slot-medium'), selectedCollection.mediumslots);
		this.remix($('.slot-small'), selectedCollection.smallslots);
		this.remix($('.slot-big'), selectedCollection.bigslots);

		if( 'sponsor_image' in selectedCollection ) {
			container = this.createSponsorImageContainer(selectedCollection);
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

		for (var i = 0; i < this.collections.length; i++) {
			this.collections[i].shown = false;
		}
	},

	icreaseRemixCount: function() {
		this.remixCount++;
	},

	markCollectionAsShown: function(collectionIndex) {
		this.collections[collectionIndex].shown = true;
	},

	getNextCollectionIndex: function() {
		var nextCollectionIndex,
			out,
			i;

		for (i = 0; i < this.collections.length; i++) {
			if ( !this.collections[i].shown) {
				nextCollectionIndex = i;
				break;
			}
		}

		if ( nextCollectionIndex !== undefined && $.inArray(this.remixCount, this.remixesWhenShowCollection) > -1 ) {
			out = nextCollectionIndex;
		}

		this.icreaseRemixCount();
		return out;
	},

	showStats: function() {
		this.statsContainer.show();
		$('#WikiaHomePageSponsorImage').remove();
	},

	createSponsorImageContainer: function(collection) {
		var imgData = collection.sponsor_image,
			img = $('<img />')
				.attr('alt', imgData.title)
				.attr('width', imgData.width)
				.attr('height', imgData.height)
				.attr('src', imgData.url)
				.addClass('sponsor-image-link')
				.data('collection-id', collection.id ),
			container = $('<div />')
				.attr('id', 'WikiaHomePageSponsorImage')
				.addClass('grid-2' ),
			link;

		if ('sponsor_url' in collection) {
			link = $('<a />').attr('href', collection['sponsor_url']);
			link.append(img);
			container.append(link);
		} else {
			container.append(img);
		}
		return container;
	},

	createHeroImageContainer: function() {
		var imgData = this.collections[0].sponsor_hero_image,
			img,
			container;
		
		if( this.heroImage !== null ) {
			img = $(this.heroImage)
				.attr('alt', imgData.title)
				.attr('witdh', imgData.width)
				.attr('witdh', imgData.height);

			container = $('<div />').attr('id', this.SPONSOR_HERO_IMG_CONTAINER_ID);
			container.append(img);
		}
		
		return container;
	},
	
	displaySponsorHeroImage: function(collectionIndex) {
		'use strict';

		if( this.isFirstCollection(collectionIndex) && !this.wasHeroImageDisplayed() ) {
			var heroContainer = this.createHeroImageContainer();
			$('#visualization').append(heroContainer);
			this.markHeroImageAsDisplayed();
		}
	},

	wasHeroImageDisplayed: function() {
		'use strict';

		var date = $.storage.get( this.SPONSOR_HERO_IMAGE_STORAGE_KEY ),
			tmpDate;
		if ( date ) {
			tmpDate = new Date();
			tmpDate.setHours( tmpDate.getHours() - this.SPONSOR_HERO_IMG_VALIDITY );
			if (new Date( date ) > tmpDate) {
				return true;
			}
		}

		return false;
	},

	markHeroImageAsDisplayed: function() {
		'use strict';

		$.storage.set( this.SPONSOR_HERO_IMAGE_STORAGE_KEY, new Date() );
	},

	isFirstCollection: function(collectionIndex) {
		return (collectionIndex === 0);
	},

	fetchMoreWikis: function() {
		$.nirvana.sendRequest({
			type: 'get',
			format: 'json',
			controller: 'WikiaHomePage',
			method: 'getWikiBatchesForVisualization',
			data: {numberOfBatches: this.NUMBEROFBATCHESTODOWNLOAD},
			callback: $.proxy(function(response) {
				this.wikiSetStack = this.wikiSetStack.concat(response.wikis);
				$('.remix').stopThrobbing();
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

