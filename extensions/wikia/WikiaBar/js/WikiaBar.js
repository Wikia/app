var WikiaBar = {
	WIKIA_BAR_STATE_ANON_ML_KEY: 'AnonMainLangWikiaBar_0.0001',
	WIKIA_BAR_STATE_ANON_NML_KEY: 'AnonNotMainLangWikiaBar_0.0001',
	WIKIA_BAR_HIDDEN_ANON_ML_TTL: 24 * 60 * 1000, //millieseconds
	WIKIA_BAR_HIDDEN_ANON_NML_TTL: 180 * 24 * 60 * 1000, //millieseconds
	WIKIA_BAR_STATE_USER_KEY_SUFFIX: 'UserWikiaBar_1.0004',
	WIKIA_BAR_MAX_MESSAGE_PARTS: 5,
	WIKIA_BAR_SAMPLING_RATIO: 10, // integer (0-100): 0 - no tracking, 100 - track everything */
	WIKIA_BAR_SHOWN_STATE_VALUE: 'shown',
	WIKIA_BAR_HIDDEN_STATE_VALUE: 'hidden',
	cutMessagePrecision: 20, // integer: 1 - best precision but low performance, 20 - low precision but high performance
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
	wikiaBarCollapseWrapperObj: null,
	isSampledEvent: function () {
		return this.WIKIA_BAR_SAMPLING_RATIO >= Math.floor((Math.random() * 100 + 1));
	},
	bindTracking: function () {
		this.wikiaBarWrapperObj.click($.proxy(this.clickTrackingHandler, this));
		this.wikiaBarCollapseWrapperObj.click($.proxy(this.clickTrackingHandler, this));
	},
	init: function () {
		this.$window = $(window);
		this.wikiaBarWrapperObj = $('#WikiaBarWrapper');
		this.wikiaBarCollapseWrapperObj = $('.WikiaBarCollapseWrapper');
		this.bindTracking();

		var wikiaBarWrapperArrow = this.wikiaBarWrapperObj.find('.arrow');
		//hidding/showing the bar events
		wikiaBarWrapperArrow.click($.proxy(this.onShownClick, this));
		this.wikiaBarCollapseWrapperObj.find('.wikia-bar-collapse').click($.proxy(this.onHiddenClick, this));

		if (!this.isUserAnon()) {
			this.handleLoggedInUsersWikiaBar();
		} else if (this.isUserAnon() && this.hasAnonHiddenWikiaBar() === false) {
			this.handleLoggedOutUsersWikiaBar();
		}

		//tooltips
		wikiaBarWrapperArrow.popover({
			placement: "wikiaBar",
			content: wikiaBarWrapperArrow.data('tooltip')
		});
		$('.wikia-bar-collapse').popover({
			placement: "wikiaBar",
			content: wikiaBarWrapperArrow.data('tooltipshow')
		});

		this.$window.triggerHandler( 'WikiaBarReady' );

		return true;
	},
	getAdIfNeeded: function () {
		function isEnabled() {
			return window.ads &&
				window.ads.context &&
				window.ads.context.opts &&
				window.ads.context.opts.showAds &&
				window.wgEnableWikiaBarAds &&
				window.Wikia.reviveQueue;
		}

		if (isEnabled()) {
			window.Wikia.reviveQueue.push({
				zoneId: 28,
				slotName: 'WIKIA_BAR_BOXAD_1'
			});
		}
	},
	cutMessageIntoSmallPieces: function (messageArray, container, cutMessagePrecision) {
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
					currentMessageArray = this.checkMessageWidth(originalMessageArray, container, cutMessagePrecision);
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
	checkMessageWidth: function (messageArray, container, cutMessagePrecision) {
		var tempMessage = '',
			tempMessageObject,
			tempMessageArray,
			cutIndex = -1;

		for (var j = 0, length = messageArray.length ; j < length ; j+=cutMessagePrecision) {
			tempMessage = tempMessage + messageArray.join("").substr(
				j,
				cutMessagePrecision
			);
			tempMessageObject = $('<span></span>').text(tempMessage);
			container.html(tempMessageObject);
			if (tempMessageObject.width() >= this.messageConfig.container.width()) {
				cutIndex = j - cutMessagePrecision;
				break;
			}
		}

		if (cutIndex == -1) {
			tempMessageArray = messageArray;
		}
		else {
			tempMessageArray = messageArray.slice(0, cutIndex);
			var lastIndexOfSpace = tempMessageArray.lastIndexOf(" ");
			if ( (lastIndexOfSpace > -1) && (lastIndexOfSpace < cutIndex) ) {
				tempMessageArray = messageArray.slice(0, lastIndexOfSpace);
			}
		}

		return tempMessageArray;
	},
	messageFadeIn: function () {
		var currentMsgIndex = this.messageConfig.index,
			messageConfig = this.messageConfig;

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
			this.messageConfig.container,
			this.cutMessagePrecision
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
		this.wikiaBarCollapseWrapperObj.addClass('hidden');
		this.wikiaBarWrapperObj.removeClass('hidden');
		this.wikiaBarHidden = false;
	},
	hide: function () {
		$('#WikiaNotifications').addClass('hidden');
		this.wikiaBarCollapseWrapperObj.removeClass('hidden');
		this.wikiaBarWrapperObj.addClass('hidden');
		this.wikiaBarHidden = true;
	},
	isWikiaBarHidden: function () {
		return this.wikiaBarHidden;
	},
	showContainer: function() {
		$('#WikiaBar').show();
	},
	hideContainer: function() {
		$('#WikiaBar').hide();
	},
	isContainerHidden: function() {
		return $('#WikiaBar').is(":visible");
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

		this.$window.triggerHandler( 'WikiaBarStateChanged' );
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
			this.getLoggedInUserStateBarAndChangeLocalStorage();
		} else {
			this.doWikiaBarAnimationDependingOnState(cachedState);
		}
	},
	getLoggedInUserStateBarAndChangeLocalStorage: function () {
		$.nirvana.sendRequest({
			controller: 'WikiaUserPropertiesController',
			method: 'performPropertyOperation',
			data: {
				handlerName: 'WikiaBarUserPropertiesHandler',
				methodName: 'getWikiaBarState'
			},
			type: 'get',
			format: 'json',
			callback: $.proxy(this.onGetLoggedInUserStateBarAndChangeLocalStorage, this),
			onErrorCallback: $.proxy(this.onGetLoggedInUserStateBarAndChangeLocalStorageError, this)
		});
	},
	changeLoggedInUserStateBar: function () {
		var changeState = this.isWikiaBarHidden() ? this.WIKIA_BAR_SHOWN_STATE_VALUE : this.WIKIA_BAR_HIDDEN_STATE_VALUE;
		this.doWikiaBarAnimationDependingOnState(changeState);
		this.setLocalStorageData(changeState);

		$.nirvana.sendRequest({
			controller: 'WikiaUserPropertiesController',
			method: 'performPropertyOperation',
			data: {
				handlerName: 'WikiaBarUserPropertiesHandler',
				methodName: 'changeWikiaBarState',
				callParams: {
					changeTo: changeState
				}
			},
			type: 'post',
			format: 'json'
		});
	},
	onGetLoggedInUserStateBarAndChangeLocalStorage: function (response) {
		var state = response.results.propertyValue || this.WIKIA_BAR_SHOWN_STATE_VALUE;
		this.setLocalStorageData(state);
		this.doWikiaBarAnimationDependingOnState(state);
	},
	onGetLoggedInUserStateBarAndChangeLocalStorageError: function () {
	},
	doWikiaBarAnimationDependingOnState: function (state) {
		if (state === this.WIKIA_BAR_SHOWN_STATE_VALUE) {
			this.show();
		} else {
			this.hide();
		}

		if (window.wgAction == 'edit' && !window.wgEnableCodePageEditor) {
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
    // defaultState - default state for anon's bar (hidden|shown); if null, it's dynamic
	getAnonData: function ( defaultState ) {
		var key = this.getCookieKey(),
			data = $.cookie(key),
			hidden = null;

		if (data === null && !this.isMainWikiaBarLang()) {
			//first time and data storage is empty let's hide the bar if it IS NOT a main language wiki
			hidden = (typeof defaultState !== 'undefined') ? defaultState : true ;
		} else if (data === null && this.isMainWikiaBarLang()) {
			//first time and data storage is empty let's hide the bar if it IS a main language wiki
            hidden = (typeof defaultState !== 'undefined') ? defaultState : false ;
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
	getWikiaBarOffset: function() {
	//this method is being used in our RTE plugin therefore we don't use here cached jQuery object this.WikiaBarWrapperObj
		var wikiaBarHeight = $("#WikiaBarWrapper").outerHeight(true) || 0;
		return (this.wikiaBarHidden) ? 0 : wikiaBarHeight;
	},
	//todo: extract class
	trackClick: function (category, action, label, value, params, event) {
		if (this.isSampledEvent()) {
			Wikia.Tracker.track({
				action: action,
				category: category,
				label: label,
				trackingMethod: 'analytics',
				value: value
			}, params);
		}
	},
	clickTrackingHandler: function (e) {
		var node = $(e.target),
			parent = node.parent(),
			startTime = new Date();

		if (node.hasClass('arrow')) {
			this.trackClick('wikia-bar', Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'arrow-hide', null, {}, e);
		} else if (node.hasClass('wikia-bar-collapse')) {
			this.trackClick('wikia-bar', Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'arrow-show', null, {}, e);
		} else if (parent.hasClass('wikiabar-button')) {
			var buttonIdx = parent.data('index');
			this.trackClick('wikia-bar', Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON, 'wikiabar-button-' + buttonIdx, null, {}, e);
		} else if (parent.hasClass('message')) {
			var messageIdx = node.data('index');
			this.trackClick('wikia-bar', Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT, 'message-' + messageIdx + '-clicked', null, {}, e);
		}

		$().log('tracking took ' + (new Date() - startTime) + ' ms');
	}
};

if (window.wgEnableWikiaBarExt) {
	$(function () {
		WikiaBar.init();
	});
}
