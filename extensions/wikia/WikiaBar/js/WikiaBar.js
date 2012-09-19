var WikiaBar = {
	WIKIA_BAR_BOXAD_NAME: 'WIKIA_BAR_BOXAD_1',
	WIKIA_BAR_STATE_ANON_ML_KEY: 'AnonMainLangWikiaBar_0.0001',
	WIKIA_BAR_STATE_ANON_NML_KEY: 'AnonNotMainLangWikiaBar_0.0001',
	WIKIA_BAR_HIDDEN_ANON_ML_TTL: 24 * 60 * 1000, //millieseconds
	WIKIA_BAR_HIDDEN_ANON_NML_TTL: 180 * 24 * 60 * 1000, //millieseconds
	WIKIA_BAR_STATE_USER_KEY: 'UserWikiaBar_0.0001',
	WIKIA_BAR_HIDDEN_USER_TTL: 180 * 24 * 60 * 1000, //millieseconds
	messageConfig: {
		index: 0,
		container: null,
		content: null,
		speed: 500,
		delay: 10000,
		prevMsgNumber: -1, //this is only needed for tracking impressions in messageFadeOut()
		doTrackImpression: false //this is only needed for tracking impressions in messageFadeIn()
	},
	init: function() {
		//clicktracking
		$('#WikiaBarWrapper').click($.proxy(this.clickTrackingHandler, this));
		$('.WikiaBarCollapseWrapper').click($.proxy(this.clickTrackingHandler, this));

		//hidding/showing the bar events
		$('.WikiaBarWrapper').on('click', '.arrow', $.proxy(this.onShownClick, this));
		$('.WikiaBarCollapseWrapper').on('click', '.wikia-bar-collapse', $.proxy(this.onHiddenClick, this));

		//tooltips
		$('#WikiaBarWrapper .arrow, .wikia-bar-collapse').popover({
			placement: "wikiaBar",
			content: $('#WikiaBarWrapper .arrow').data('tooltip')
		});

		if( this.isBarHidden() === false ) {
			//show bar (depends on user's local storage data)
			this.show();

			//getting the ad
			if( window.wgEnableWikiaBarAds ) {
				this.getAd();
			}

			//messages animation
			if ($('#WikiaBarWrapper .message').exists()) {
				this.startSlideShow();
			}
		}

		return true;
	},
	getAd: function() {
		var weeboBoxAd = $(this.WIKIA_BAR_BOXAD_NAME);
		if( weeboBoxAd.hasClass('wikia-ad') == false ) {
			document.getElementById(this.WIKIA_BAR_BOXAD_NAME + "_iframe");
			window.adslots2.push([this.WIKIA_BAR_BOXAD_NAME, null, 'Liftium2', null]);
			weeboBoxAd.addClass('wikia-ad');
		}
		return true;
	},
	cutMessageIntoSmallPieces: function(messageArray, container) {
		var returnArray = new Array(),
			currentMessageArray,
			originalMessageArray,
			originalCurrentDiffArray,
			messageArrayText;

		for(var i = 0, length = messageArray.length; i < length; i++) {
			messageArrayText = messageArray[i].text;
			if (typeof messageArrayText == 'string') {
				originalMessageArray = messageArrayText.split(' ');
				do {
					currentMessageArray = this.checkMessageWidth(originalMessageArray, container);
					originalCurrentDiffArray = originalMessageArray.slice(
						currentMessageArray.length,
						originalMessageArray.length
					);
					returnArray.push({'anchor': currentMessageArray.join(' '), 'href': messageArray[i].href, 'messageNumber': i});
					originalMessageArray = originalCurrentDiffArray;
				}
				while (originalCurrentDiffArray.length > 0);
			}
		}
		container.text('');
		return returnArray;
	},
	checkMessageWidth: function(messageArray, container) {
		var tempMessage = '',
			lastMessage = new Array(),
			tempMessageObject;

		for(var i = 0, length = messageArray.length; i < length; i++) {
			tempMessage = tempMessage + ' ' + messageArray[i];
			tempMessageObject = $('<span></span>').text(tempMessage);
			container.html(tempMessageObject);
			if(tempMessageObject.width() >= this.messageConfig.container.width()) {
				break;
			} else {
				lastMessage.push(messageArray[i]);
			}
		}
		return lastMessage;
	},
	messageFadeIn: function () {
		var currentMsgIndex = this.messageConfig.index,
			messageConfig = this.messageConfig;

		//tracking impressions of the message (not chunk of a long message)
		if( messageConfig.doTrackImpression ) {
			var GALabel = 'message-' + messageConfig.content[currentMsgIndex].messageNumber + '-appears';
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.IMPRESSION, GALabel, null, {});
		}

		if( currentMsgIndex == (messageConfig.content.length - 1) ) { //indexes are counted starting with 0 and length() counts items starting with 1
			this.messageConfig.index = 0;
		} else {
			this.messageConfig.index++;
		}

		setTimeout($.proxy(this.messageSlideShow, this), messageConfig.delay);
		return true;
	},
	messageSlideShow: function() {
		var messageData = this.messageConfig.content[this.messageConfig.index],
			messageContainer = this.messageConfig.container,
			link = $('<a></a>')
				.attr('href', messageData.href)
				.data('index', messageData.messageNumber)
				.text(messageData.anchor);

		messageContainer.fadeOut(this.messageConfig.speed, $.proxy(function () {
			messageContainer.html(link);

			//this is only needed for tracking impressions in messageFadeIn()
			if( this.messageConfig.prevMsgNumber != messageData.messageNumber ) {
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
	startSlideShow: function() {
		this.messageConfig.container = $('.message');

		this.messageConfig.content = this.cutMessageIntoSmallPieces(
			this.messageConfig.container.data('content'),
			this.messageConfig.container
		);

		if (typeof this.messageConfig.content == 'object') {
			this.messageSlideShow();
		}
	},
	show: function() {
		$('.WikiaBarWrapper').removeClass('hidden');
		$('.WikiaBarCollapseWrapper').addClass('hidden');
	},
	hide: function() {
		$('.WikiaBarWrapper').addClass('hidden');
		$('.WikiaBarCollapseWrapper').removeClass('hidden');
	},
	onShownClick: function(e) {
		this.hide();
		this.changeLocalStorageData();
		e.preventDefault();
	},
	onHiddenClick: function(e) {
		this.show();
		this.changeLocalStorageData();
		e.preventDefault();
	},
	changeLocalStorageData: function() {
		var isHidden = this.isBarHidden();

		if( isHidden === false ) {
			this.setStorageData(true);
		} else {
			this.setStorageData(false);
		}
	},
	isBarHidden: function() {
		return this.getStorageData();
	},
	getStorageData: function() {
		var key = this.getStorageKey(),
			data = $.cookie(key),
			hidden = null;

		if( data === null && !this.isMainWikiaBarLang() ) {
		//first time and data storage is empty let's hide the bar if it IS NOT a main language wiki
			hidden = true;
		} else if ( data === null && this.isMainWikiaBarLang() ) {
		//first time and data storage is empty let's hide the bar if it IS a main language wiki
			hidden = false;
		} else {
			hidden = (data === 'true') ? true : false; //all data in cookies is saved as strings
		}

		return hidden;
	},
	setStorageData: function(hiddenState) {
		var key = this.getStorageKey(),
			now = new Date(),
			expireDate = new Date(now.getTime() + this.WIKIA_BAR_HIDDEN_ANON_ML_TTL),
			cookieData = {
				expires: expireDate,
				path: '/',
				domain: 'wikia.com'
			};

		if( this.isUserAnon() && !this.isMainWikiaBarLang() ) {
			cookieData.expires = this.WIKIA_BAR_HIDDEN_ANON_NML_TTL;
		} else if( !this.isUserAnon ) {
			cookieData.expires = this.WIKIA_BAR_STATE_USER_KEY;
		}

		if( window.wgDevelEnvironment ) {
			cookieData.domain = 'wikia-dev.com';
		}

		$.cookie(key, hiddenState, cookieData);
	},
	getStorageKey: function() {
		var key = this.WIKIA_BAR_STATE_ANON_NML_KEY;
		if( this.isUserAnon() && this.isMainWikiaBarLang() ) {
			key = this.WIKIA_BAR_STATE_ANON_ML_KEY;
		} else if( !this.isUserAnon ) {
			key = this.WIKIA_BAR_STATE_USER_KEY;
		}

		return key;
	},
	isUserAnon: function() {
		return (window.wgUserName === null);
	},
	isMainWikiaBarLang: function() {
		var result = -1;
		if( window.wgContentLanguage && window.wgWikiaBarMainLanguages ) {
			result = window.wgWikiaBarMainLanguages.indexOf(window.wgContentLanguage);
		}

		return (result >= 0) ? true : false;
	},
	//todo: extract class
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
			parent = node.parent(),
			startTime = new Date();

		if( node.hasClass('arrow') ) {
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'arrow-hide', null, {});
		} else if ( node.hasClass('wikia-bar-collapse') ) {
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'arrow-show', null, {});
		} else if( parent.hasClass('wikiabar-button') ) {
			var buttonIdx = parent.data('index');
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'wikiabar-button-' + buttonIdx, null, {});
		} else if( parent.hasClass('message') ) {
			var messageIdx = node.data('index');
			this.trackClick('wikia-bar', WikiaTracker.ACTIONS.CLICK_LINK_TEXT, 'message-' + messageIdx + '-clicked', null, {});
		}

		$().log('tracking took ' + (new Date() - startTime) + ' ms');
	}
};

$(function() {
	WikiaBar.init();
});
