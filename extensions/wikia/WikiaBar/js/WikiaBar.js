var WikiaBar = {
	WIKIA_BAR_BOXAD_NAME: 'WIKIA_BAR_BOXAD_1',
	WIKIA_BAR_STATE_ANON_ML_KEY: 'AnonMainLangWikiaBar_0.0001',
	WIKIA_BAR_STATE_ANON_NML_KEY: 'AnonNotMainLangWikiaBar_0.0001',
	WIKIA_BAR_HIDDEN_ANON_ML_TTL: 24 * 60 * 1000, //millieseconds
	WIKIA_BAR_HIDDEN_ANON_NML_TTL: 180 * 24 * 60 * 1000, //millieseconds
	WIKIA_BAR_STATE_USER_KEY_SUFFIX: 'UserWikiaBar_1.0002',
	WIKIA_BAR_MAX_MESSAGE_PARTS: 5,
	WIKIA_BAR_SAMPLING_RATIO: 10, // integer (0-100): 0 - no tracking, 100 - track everything */
	messageConfig: {
		index: 0,
		container: null,
		attributeName: 'wikiabarcontent',
		content: null,
		speed: 500,
		delay: 10000,
		prevMsgNumber: -1, //this is only needed for tracking impressions in messageFadeOut()
		doTrackImpression: false //this is only needed for tracking impressions in messageFadeIn()
	},
	wikiaBarHidden: true,
	wikiaBarWrapperObj: null,
	isSampledEvent: function () {
		return this.WIKIA_BAR_SAMPLING_RATIO >= Math.floor((Math.random() * 100 + 1));
	},
	bindTracking: function () {
		this.wikiaBarWrapperObj.click($.proxy(this.clickTrackingHandler, this));
		$('.WikiaBarCollapseWrapper').click($.proxy(this.clickTrackingHandler, this));
	},
	init: function () {
		this.wikiaBarWrapperObj = $('#WikiaBarWrapper');
		this.bindTracking();

		var WikiaBarWrapperArrow = this.wikiaBarWrapperObj.find('.arrow');

		//hidding/showing the bar events
		WikiaBarWrapperArrow.click($.proxy(this.onShownClick, this));
		$('.WikiaBarCollapseWrapper .wikia-bar-collapse').click($.proxy(this.onHiddenClick, this));

		if (!this.isUserAnon()) {
			this.handleLoggedInUsersWikiaBar();
		} else if (this.isUserAnon() && this.hasAnonHiddenWikiaBar() === false) {
			this.handleLoggedOutUsersWikiaBar();
		}

		//tooltips
		WikiaBarWrapperArrow.popover({
			placement: "wikiaBar",
			content: WikiaBarWrapperArrow.data('tooltip')
		});
		$('.wikia-bar-collapse').popover({
			placement: "wikiaBar",
			content: WikiaBarWrapperArrow.data('tooltipshow')
		});

		return true;
	},
	getAdIfNeeded: function () {
		var WikiaBarBoxAd = $('#' + this.WIKIA_BAR_BOXAD_NAME);
		if( WikiaBarBoxAd.hasClass('wikia-ad') == false && window.wgShowAds && window.wgAdsShowableOnPage && window.wgEnableWikiaBarAds ) {
			window.adslots2.push([this.WIKIA_BAR_BOXAD_NAME, null, 'AdEngine2', null]);
			WikiaBarBoxAd.addClass('wikia-ad');
		}
	},
	cutMessageIntoSmallPieces: function (messageArray, container) {
		var returnArray = [],
			currentMessageArray,
			originalMessageArray,
			originalCurrentDiffArray,
			messageArrayText,
			messageLoops = 0;

		for (var i = 0, length = messageArray.length ; i < length ; i++) {
			messageArrayText = messageArray[i].text;
			if (typeof messageArrayText == 'string') {
				originalMessageArray = messageArrayText.split('');
				do {
					currentMessageArray = this.checkMessageWidth(originalMessageArray, container);
					originalCurrentDiffArray = originalMessageArray.slice(
						currentMessageArray.length,
						originalMessageArray.length
					);
					returnArray.push({'anchor': $.trim(currentMessageArray.join('')), 'href': messageArray[i].href, 'messageNumber': i});
					originalMessageArray = originalCurrentDiffArray;
					messageLoops++;
				} while (originalCurrentDiffArray.length > 0 && messageLoops < this.WIKIA_BAR_MAX_MESSAGE_PARTS);
			}
		}
		container.text('');
		return returnArray;
	},
	checkMessageWidth: function (messageArray, container) {
		var tempMessage = '',
			tempMessageObject,
			lastSpaceIndex = -1,
			cutIndex = -1;

		for (var j = 0, length = messageArray.length ; j < length ; j++) {
			if (messageArray[j] == ' ') {
				lastSpaceIndex = j;
			}
			tempMessage = tempMessage + messageArray[j];
			tempMessageObject = $('<span></span>').text(tempMessage);
			container.html(tempMessageObject);
			if (tempMessageObject.width() >= this.messageConfig.container.width()) {
				if (lastSpaceIndex == -1) {
					cutIndex = j;
				} else {
					cutIndex = ((lastSpaceIndex + 1) < length) ? (lastSpaceIndex + 1) : lastSpaceIndex;
				}
				break;
			}
		}

		return ((cutIndex == -1) ? messageArray : messageArray.slice(0, cutIndex));
	},
	messageFadeIn: function () {
		var currentMsgIndex = this.messageConfig.index,
			messageConfig = this.messageConfig;

		//tracking impressions of the message (not chunk of a long message)
		if (messageConfig.doTrackImpression && !this.isWikiaBarHidden()) {
			var GALabel = 'message-' + messageConfig.content[currentMsgIndex].messageNumber + '-appears';
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.IMPRESSION, GALabel, null, {});
		}

		if (currentMsgIndex == (messageConfig.content.length - 1)) { //indexes are counted starting with 0 and length() counts items starting with 1
			this.messageConfig.index = 0;
		} else {
			this.messageConfig.index++;
		}

		setTimeout($.proxy(this.messageSlideShow, this), messageConfig.delay);
		return true;
	},
	messageSlideShow: function () {
		var messageData = this.messageConfig.content[this.messageConfig.index],
			messageContainer = this.messageConfig.container,
			link = $('<a></a>')
				.attr('href', messageData.href)
				.data('index', messageData.messageNumber)
				.text(messageData.anchor);

		messageContainer.fadeOut(this.messageConfig.speed, $.proxy(function () {
			messageContainer.html(link);

			//this is only needed for tracking impressions in messageFadeIn()
			if (this.messageConfig.prevMsgNumber != messageData.messageNumber) {
				this.messageConfig.prevMsgNumber = messageData.messageNumber;
				this.messageConfig.doTrackImpression = true;
			} else {
				this.messageConfig.doTrackImpression = false;
			}

			messageContainer.fadeIn(
				this.messageConfig.speed,
				$.proxy(this.messageFadeIn, this)
			);
		}, this));
		return true;
	},
	startSlideShow: function () {
		this.messageConfig.content = this.cutMessageIntoSmallPieces(
			this.messageConfig.container.data(this.messageConfig.attributeName),
			this.messageConfig.container
		);

		if (typeof this.messageConfig.content == 'object') {
			this.messageConfig.container.popover({
				placement: "wikiaBarMessage",
				content: this.messageConfig.container.data('messagetooltip')
			});
			this.messageSlideShow();
		}
	},
	show: function () {
		$('#WikiaNotifications').removeClass('hidden');
		$('.WikiaBarCollapseWrapper').addClass('hidden');
		this.wikiaBarWrapperObj.removeClass('hidden');
		this.wikiaBarHidden = false;
	},
	hide: function () {
		$('#WikiaNotifications').addClass('hidden');
		$('.WikiaBarCollapseWrapper').removeClass('hidden');
		this.wikiaBarWrapperObj.addClass('hidden');
		this.wikiaBarHidden = true;
	},
	isWikiaBarHidden: function () {
		return this.wikiaBarHidden;
	},
	onShownClick: function (e) {
		this.changeBarStateData();
		e.preventDefault();
	},
	onHiddenClick: function (e) {
		this.changeBarStateData();
		e.preventDefault();
	},
	changeBarStateData: function () {
		if (this.isUserAnon()) {
			this.changeAnonBarStateData();
		} else {
			this.changeLoggedInUserStateBar();
		}
	},
	changeAnonBarStateData: function () {
		var isHidden = this.hasAnonHiddenWikiaBar();

		if (isHidden === false) {
			this.setCookieData(true);
			this.hide();
		} else {
			this.setCookieData(false);
			this.getAdIfNeeded();
			this.show();
		}
	},
	hasAnonHiddenWikiaBar: function () {
		return this.getAnonData();
	},
	handleLoggedOutUsersWikiaBar: function () {
		this.show();

		//messages animation
		this.messageConfig.container = this.wikiaBarWrapperObj.find('.message');
		var dataContent = this.messageConfig.container.data(this.messageConfig.attributeName);
		if (
			this.messageConfig.container.exists()
			&& dataContent
			&& (typeof dataContent == 'object')
			&& (dataContent.length > 0)
		) {
			this.startSlideShow();
		}

		this.getAdIfNeeded();
	},
	handleLoggedInUsersWikiaBar: function () {
		var cachedState = this.getLocalStorageData();

		if (cachedState === null) {
			this.changeLoggedInUserStateBar();
			this.getLoggedInUserStateBarAndChangeLocalStorage();
		} else {
			this.doWikiaBarAnimationDependingOnState(cachedState);
		}
	},
	getLoggedInUserStateBarAndChangeLocalStorage: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaBarController',
			method: 'changeUserStateBar',
			type: 'post',
			format: 'json',
			callback: $.proxy(this.onGetLoggedInUserStateBarAndChangeLocalStorage, this),
			onErrorCallback: $.proxy(this.onGetLoggedInUserStateBarAndChangeLocalStorageError, this)
		});
	},
	changeLoggedInUserStateBar: function () {
		var changeState = this.isWikiaBarHidden() ? 'shown' : 'hidden';

		this.doWikiaBarAnimationDependingOnState(changeState);
		this.setLocalStorageData(changeState);

		$.nirvana.sendRequest({
			controller: 'WikiaBarController',
			method: 'changeUserStateBar',
			type: 'post',
			format: 'json'
		});
	},
	onGetLoggedInUserStateBarAndChangeLocalStorage: function (response) {
		var state = response.results.wikiaBarState || 'shown';
		this.setLocalStorageData(state);
	},
	onGetLoggedInUserStateBarAndChangeLocalStorageError: function () {
	},
	doWikiaBarAnimationDependingOnState: function (state) {
		if (state === 'shown') {
			this.show();
		} else {
			this.hide();
		}

		if (window.wgAction == 'edit') {
			var WE = window.WikiaEditor = window.WikiaEditor || (new Observable()),
				editorInstance = WE.getInstance();

			//quick fix for fb#49383
			if (typeof(editorInstance) !== 'undefined') {
				editorInstance.fire('sizeChanged');
			}
		}
	},
	getLocalStorageDataKey: function () {
		var key = undefined;
		if (window.wgUserName) {
			key = window.wgUserName + '_' + this.WIKIA_BAR_STATE_USER_KEY_SUFFIX;
		} else {
			$().log('WikiaBar notice: No user name found');
		}
		return key;
	},
	getLocalStorageData: function () {
		return $.storage.get(this.getLocalStorageDataKey());
	},
	setLocalStorageData: function (state) {
		$.storage.set(this.getLocalStorageDataKey(), state);
	},
	getAnonData: function () {
		var key = this.getCookieKey(),
			data = $.cookie(key),
			hidden = null;

		if (data === null && !this.isMainWikiaBarLang()) {
			//first time and data storage is empty let's hide the bar if it IS NOT a main language wiki
			hidden = true;
		} else if (data === null && this.isMainWikiaBarLang()) {
			//first time and data storage is empty let's hide the bar if it IS a main language wiki
			hidden = false;
		} else {
			hidden = (data === 'true'); //all data in cookies is saved as strings
		}

		return hidden;
	},
	setCookieData: function (hiddenState) {
		var key = this.getCookieKey(),
			now = new Date(),
			expireDate = new Date(now.getTime() + this.WIKIA_BAR_HIDDEN_ANON_ML_TTL),
			cookieData = {
				expires: expireDate,
				path: '/',
				domain: window.wgCookieDomain
			};

		if (this.isUserAnon() && !this.isMainWikiaBarLang()) {
			cookieData.expires = this.WIKIA_BAR_HIDDEN_ANON_NML_TTL;
		} else if (!this.isUserAnon) {
			cookieData.expires = this.WIKIA_BAR_HIDDEN_USER_TTL;
		}

		$.cookie(key, hiddenState, cookieData);
	},
	getCookieKey: function () {
		var key = this.WIKIA_BAR_STATE_ANON_ML_KEY;
		if (this.isUserAnon() && !this.isMainWikiaBarLang()) {
			key = this.WIKIA_BAR_STATE_ANON_NML_KEY;
		}

		return key;
	},
	isUserAnon: function () {
		return (window.wgUserName === null);
	},
	isMainWikiaBarLang: function () {
		var result = -1;
		if (window.wgContentLanguage && window.wgWikiaBarMainLanguages) {
			result = $.inArray(window.wgContentLanguage, window.wgWikiaBarMainLanguages);
		}

		return (result >= 0);
	},
	getWikiaBarOffset: function () {
		//this method is being used in our RTE plugin therefore we don't use here cached jQuery object this.WikiaBarWrapperObj
		var wikiaBarHeight = $("#WikiaBarWrapper").outerHeight() || 0;
		return (this.wikiaBarHidden) ? 0 : wikiaBarHeight;
	},
	//todo: extract class
	trackClick: function (category, action, label, value, params) {
		if (this.isSampledEvent()) {
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
				'ga'
			);
		}
	},
	clickTrackingHandler: function (e) {
		var node = $(e.target),
			parent = node.parent(),
			startTime = new Date();

		if (node.hasClass('arrow')) {
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'arrow-hide', null, {});
		} else if (node.hasClass('wikia-bar-collapse')) {
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'arrow-show', null, {});
		} else if (parent.hasClass('wikiabar-button')) {
			var buttonIdx = parent.data('index');
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'wikiabar-button-' + buttonIdx, null, {});
		} else if (parent.hasClass('message')) {
			var messageIdx = node.data('index');
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'message-' + messageIdx + '-clicked', null, {});
		}

		$().log('tracking took ' + (new Date() - startTime) + ' ms');
	}
};

$(function () {
	if (window.wgEnableWikiaBarExt) {
		WikiaBar.init();
	}
});
