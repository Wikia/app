/*global UserLoginModal*/

var ChatWidget = {
	loading: false,
	chatLaunchModal: null,
	bindComplete: false,
	isWideChat: null,
	widgetUserElementTemplate: '',
	wideChatThreshold: 280,
	resizeDebounceTime: 1000,

	init: function () {
		if (!ChatWidget.bindComplete) {
			$('body').on('click', '.WikiaChatLink', function (event) {
				event.preventDefault();
				event.stopPropagation();
				ChatWidget.onClickChatButton(this.href);
			});
			ChatWidget.bindComplete = true;
		}

		// make sure we start processing after ChatModule templates is loaded
		if ($('.ChatModule').length) {
			if (!ChatWidget.loading) {
				// if we're not loading yet - start it
				ChatWidget.loading = true;
				ChatWidget.loadDataAndInitializeModules();
			}
		}
	},

	/**
	 * Make request for actual users list and fetch mustache template.
	 * Then init chat entrypoint.
	 */
	loadDataAndInitializeModules: function() {
		$.when(
			ChatWidget.loadChatUsers(),
			ChatWidget.loadWidgetUserElementTemplate()
		).then(function(usersData, templateData) {
			if (usersData[1] === 'success' && templateData[1] === 'success') {
				var users = usersData[0].users;

				ChatWidget.widgetUserElementTemplate = templateData[0].mustache[0];

				if (users.length) {
					ChatWidget.updateUsersList(users);
				}

				// cache result
				ChatWidget.users = users;
			}

			ChatWidget.initializeChatModules();
		});
	},

	loadChatUsers: function () {
		// load the chat users info using Ajax
		return $.nirvana.sendRequest({
			controller: 'ChatRailController',
			method: 'GetUsers',
			type: 'GET',
			format: 'json'
		});
	},

	/**
	 * Fetch template responsible for displaying users in right rail module.
	 */
	loadWidgetUserElementTemplate: function() {
		return Wikia.getMultiTypePackage({
			mustache: 'extensions/wikia/Chat2/templates/widgetUserElement.mustache'
		});
	},

	/**
	 * As we have updated list of users on chat, rerender part of the template responsible for
	 * displaying users avatars list.
	 *
	 * @param users array of users on chat
	 */
	updateUsersList: function(users) {
		var output = Mustache.render(ChatWidget.widgetUserElementTemplate, {
			users: users,
			blankImageUrl: window.wgBlankImageUrl
		});

		$('.chat-contents.chat-room-empty').each(function () {
			$(this).get(0)
				.removeClass('chat-room-empty')
				.addClass('chat-room-active');
		});

		$('.chatCarousel').each(function () {
			$(this).get(0).innerHTML = output;
		});

		// update number of users
		$('.chat-total').innerHTML = users.length;
	},

	initializeChatModules: function () {
		// in case the module is embedded in the article, we can have several modules on the page.
		// Process them one by one
		$('.ChatModuleUninitialized').each(function () {
			var $module = $(this);
			ChatWidget.isWideChat = ChatWidget.computeIsWideChat($module.width());

			ChatWidget.processModuleTemplate($module);
			$module.removeClass('ChatModuleUninitialized');

			// let's keep number of avatars up do date
			$(window).resize($.debounce(ChatWidget.resizeDebounceTime, function() {
				ChatWidget.afterResize($module);
			}));
		});
	},

	/**
	 * Called after window resize.
	 * By comparing current chat entrypoint width and the previous one, decides if carousel
	 * with users should be updated.
	 *
	 * @param $module chat module element
	 */
	afterResize: function($module) {
		var wideAfterResize = ChatWidget.computeIsWideChat($module.width());

		if (wideAfterResize !== ChatWidget.isWideChat) {
			ChatWidget.isWideChat = wideAfterResize;
			ChatWidget.processModuleTemplate($module);
		}
	},

	/**
	 * Determines if chat is in its wide version
	 *
	 * @param width int width of chat module
	 */
	computeIsWideChat: function(width) {
		return width > ChatWidget.wideChatThreshold;
	},

	/**
	 * Creates carousel of users and fills in some of fields with translated messages
	 *
	 * @param $t chat module element
	 */
	processModuleTemplate: function ($t) {
		ChatWidget.initCarousel($t.find('.chat-whos-here'));

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
		var popoverTimeout = 0;

		$el.find('.carousel-container').carousel({
			nextClass: 'arrow-right',
			prevClass: 'arrow-left',
			// differ number of users on chat according to it's width
			itemsShown: ChatWidget.isWideChat ? 6 : 5
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
					forceLogin: true,
					url: '/signin?redirect=' + encodeURIComponent(window.location.href),
					origin: 'chat',
					onAuthSuccess: ChatWidget.onSuccessfulLogin
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
			callback: ChatWidget.onJoinChatFormLoaded
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
						ChatWidget.launchChatWindow(event, joinModal);
					});
					joinModal.bind('close', function () {
						ChatWidget.reloadPage();
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
		ChatWidget.reloadPage();
	}
};

if (typeof wgWikiaChatUsers !== 'undefined') {
	$(function () {
		ChatWidget.init();
	});
}
