/*global UserLoginModal*/

var ChatEntryPoint = {
	loading: false,
	chatLaunchModal: null,
	bindComplete: false,

	init: function () {
		if (!ChatEntryPoint.bindComplete) {
			$('body').on('click', '.WikiaChatLink', function (event) {
				event.preventDefault();
				event.stopPropagation();
				ChatEntryPoint.onClickChatButton(this.href);
			});
			ChatEntryPoint.bindComplete = true;
		}
		// check if content was pre-rendered to JS variable
		if (window.wgWikiaChatUsers) {
			ChatEntryPoint.initEntryPoint();
		} else if (!ChatEntryPoint.loading) {
			// if we're not loading yet - start it
			ChatEntryPoint.loading = true;
			ChatEntryPoint.loadChatUsers();
		}
	},

	loadChatUsers: function () {
		// load the chat users info using Ajax
		$.nirvana.sendRequest({
			controller: 'ChatRailController',
			method: 'GetUsers',
			type: 'GET',
			format: 'json',
			callback: function (content) {
				// cache the result
				window.wgWikiaChatUsers = content.users;
				ChatEntryPoint.initEntryPoint();
			}
		});
	},

	initEntryPoint: function () {
		if (typeof window.wgWikiaChatUsers === 'string') {
			// for logged-in users the information about chat users is serialized into JS global variable
			window.wgWikiaChatUsers = window.wgWikiaChatUsers.length ? JSON.parse(window.wgWikiaChatUsers) : [];
		}
		// in case the module is embedded in the article, we can have several modules on the page. work on them one by one
		$('.ChatModuleUninitialized').each(function () {
			ChatEntryPoint.processModuleTemplate($(this));
			$(this).removeClass('ChatModuleUninitialized');
		});
	},

	/**
	 * Creates carousel of users and fills in some of fields with translated messages
	 * @param $t chat module element
	 */
	processModuleTemplate: function ($t) {
		ChatEntryPoint.initCarousel($t.find('.chat-whos-here'));

		// process i18n the messages
		$t.find('[data-msg-id]').each(function () {
			var $e = $(this);
			$e.text($.msg($e.data('msg-id'), $e.data('msg-param')));
		});
	},

	/**
	 * change the user list into the carousel
	 * @param $el chat who is here element
	 */
	initCarousel: function ($el) {
		var popoverTimeout = 0,
			// differ number of users on chat according to it's width
			isWideChat = $el.width() > 260;

		$el.find('.carousel-container').carousel({
			nextClass: 'arrow-right',
			prevClass: 'arrow-left',
			itemsShown: isWideChat ? 6 : 5
		});

		function setPopoverTimeout(elem) {
			popoverTimeout = setTimeout(function () {
				elem.popover('hide');
			}, 300);
		}

		$el.find('.chatter').popover({
			trigger: 'manual',
			placement: 'bottom',
			content: function () {
				var userStatsMenu = $(this).find('.UserStatsMenu');

				return userStatsMenu.clone().wrap('<div>').parent().html();
			}
		}).on('mouseenter', function () {
			clearTimeout(popoverTimeout);
			$('.popover').remove();
			$(this).popover('show');

		}).on('mouseleave', function () {
			var $this = $(this);

			setPopoverTimeout($this);
			$('.popover')
				.mouseenter(function () {
					clearTimeout(popoverTimeout);
				})
				.mouseleave(function () {
					setPopoverTimeout($this);
				});
		});
	},

	onClickChatButton: function (linkToSpecialChat) {
		'use strict';

		if (window.wgUserName) {
			window.open(linkToSpecialChat, 'wikiachat', window.wgWikiaChatWindowFeatures);
		} else {
			require(['AuthModal'], function (authModal) {
				authModal.load({
					url: '/signin?redirect=' + encodeURIComponent(window.location.href),
					origin: 'chat',
					onAuthSuccess: ChatEntryPoint.onSuccessfulLogin
				});
			});
		}
	},

	onSuccessfulLogin: function () {
		$.nirvana.sendRequest({
			controller: 'ChatRail',
			method: 'AnonLoginSuccess',
			type: 'GET',
			format: 'html',
			callback: ChatEntryPoint.onJoinChatFormLoaded
		});
	},

	onJoinChatFormLoaded: function (html) {

		require(['wikia.ui.factory'], function (uiFactory) {
			uiFactory.init('modal').then(function (uiModal) {
				var joinModalConfig = {
					vars: {
						id: 'JoinChatModal',
						size: 'small',
						content: html,
						title: mw.html.escape($.msg('chat-start-a-chat'))
					}
				};
				uiModal.createComponent(joinModalConfig, function (joinModal) {
					joinModal.bind('chat', function (event) {
						ChatEntryPoint.launchChatWindow(event, joinModal);
					});
					joinModal.bind('close', function () {
						ChatEntryPoint.reloadPage();
					});
					joinModal.show();

				});
			});
		});
	},

	reloadPage: function () {
		Wikia.Querystring().addCb().goTo();
	},

	launchChatWindow: function (event, chatLaunchModal) {
		var pageLink = $('#modal-join-chat-button').data('chat-page');

		window.open(pageLink, 'wikiachat', window.wgWikiaChatWindowFeatures);
		if (chatLaunchModal) {
			chatLaunchModal.trigger('close');
		}
		ChatEntryPoint.reloadPage();
	}
};

if (typeof wgWikiaChatUsers !== 'undefined') {
	$(function () {
		ChatEntryPoint.init();
	});
}
