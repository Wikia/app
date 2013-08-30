/*global UserLoginModal*/

var ChatEntryPoint = {
	loading: false,
	chatLaunchModal: null,

	init: function() {
		// check if content was pre-rendered to JS variable
		if (wgWikiaChatModuleContent) {
			ChatEntryPoint.initEntryPoint();
		} else if ( ! ChatEntryPoint.loading ) {
			// if we're not loading yet - start it
			ChatEntryPoint.loading = true;
			ChatEntryPoint.loadEntryPoint();
		}
	},

	loadEntryPoint: function() {
		// load the chat entry point content using Ajax
		//var currentTime = new Date();
		//var minuteTimestamp = currentTime.getFullYear() + currentTime.getMonth() + currentTime.getDate() + currentTime.getHours() + currentTime.getMinutes();
		$.nirvana.sendRequest({
			controller: 'ChatRailController',
			method: 'Contents',
			type: 'GET',
			format: 'html',
			data: {
				//cb: minuteTimestamp
			},
			callback: ChatEntryPoint.entryPointLoaded
		});
	},

	entryPointLoaded: function(content) {
		// cache the result
		wgWikiaChatModuleContent = content;
		ChatEntryPoint.initEntryPoint();
	},

	initEntryPoint: function() {
		// remove the ChatModuleUninitialized so we don't initialize the same element more than once
		$(".ChatModuleUninitialized").html(wgWikiaChatModuleContent).removeClass("ChatModuleUninitialized");

		var chatWhosHere = $('.ChatModule .chat-whos-here'),
			itemsShown = (window.wgOasisResponsive) ? 5 : 6;

		chatWhosHere.find('.carousel-container').carousel({
			nextClass: 'arrow-right',
			prevClass: 'arrow-left',
			itemsShown: itemsShown
		});

		// TODO: abstract this because we use this pattern in a few places: i.e. hovering over popover will not close it
		var popoverTimeout = 0;

		function setPopoverTimeout(elem) {
			popoverTimeout = setTimeout(function() {
				elem.popover('hide');
			}, 300);
		}

		chatWhosHere.find('.chatter').popover({
			trigger: "manual",
			placement: "bottom",
			content: function() {
				var userStatsMenu = $(this).find('.UserStatsMenu');

				return userStatsMenu.clone().wrap('<div>').parent().html();
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
	},

	onClickChatButton: function(isLoggedIn, linkToSpecialChat) {
		if (isLoggedIn) {
			window.open(linkToSpecialChat, 'wikiachat', window.wgWikiaChatWindowFeatures);
		} else {
			UserLoginModal.show({
				persistModal: true,
				callback: ChatEntryPoint.onSuccessfulLogin
			});
		}
	},

	onSuccessfulLogin: function(json) {
		UserLoginModal.dialog.startThrobbing();
		$.nirvana.sendRequest({
			controller: 'ChatRail',
			method: 'AnonLoginSuccess',
			type: 'GET',
			format: 'html',
			callback: ChatEntryPoint.onJoinChatFormLoaded
		});
	},

	onJoinChatFormLoaded: function(html) {
		UserLoginModal.dialog.stopThrobbing();
		UserLoginModal.dialog.closeModal();
		ChatEntryPoint.chatLaunchModal = $(html).makeModal({
			width: 450,
			onClose: ChatEntryPoint.reloadPage
		});
		ChatEntryPoint.chatLaunchModal.bind('click',ChatEntryPoint.launchChatWindow);

	},

	reloadPage: function() {
		Wikia.Querystring().addCb().goTo();
	},

	launchChatWindow: function(event) {
		var pageLink = $('#modal-join-chat-button').data('chat-page');
		window.open(pageLink, 'wikiachat', window.wgWikiaChatWindowFeatures);
		if(ChatEntryPoint.chatLaunchModal) {
			ChatEntryPoint.chatLaunchModal.closeModal();
		}
		ChatEntryPoint.reloadPage();
	}
};

if ( typeof wgWikiaChatModuleContent!=="undefined" ) {
    $(function() {
		ChatEntryPoint.init();
		$('body').on('click', '.WikiaChatLink', function(event) {
			event.preventDefault();
			event.stopPropagation();
			ChatEntryPoint.onClickChatButton(wgUserName !== null, this.href);
		});
    });
}
