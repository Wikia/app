/*global UserLoginModal*/

var ChatEntryPoint = {
	loading: false,
	chatLaunchModal: null,
	bindComplete: false,

	init: function() {
		if ( !ChatEntryPoint.bindComplete ) {
			$('body').on('click', '.WikiaChatLink', function(event) {
				event.preventDefault();
				event.stopPropagation();
				ChatEntryPoint.onClickChatButton(this.href);
			});
			ChatEntryPoint.bindComplete = true;
		}
		// check if content was pre-rendered to JS variable
		if (window.wgWikiaChatUsers) {
			ChatEntryPoint.initEntryPoint();
		} else if ( ! ChatEntryPoint.loading ) {
			// if we're not loading yet - start it
			ChatEntryPoint.loading = true;
			ChatEntryPoint.loadChatUsers();
		}
	},

	loadChatUsers: function() {
		// load the chat users info using Ajax
		//var currentTime = new Date();
		//var minuteTimestamp = currentTime.getFullYear() + currentTime.getMonth() + currentTime.getDate() + currentTime.getHours() + currentTime.getMinutes();
		$.nirvana.sendRequest({
			controller: 'ChatRailController',
			method: 'GetUsers',
			type: 'GET',
			format: 'json',
			/*data: {
				cb: minuteTimestamp
			},*/
			callback: function(content) {
				// cache the result
				window.wgWikiaChatUsers = content.users;
				ChatEntryPoint.initEntryPoint();
			}
		});
	},

	initEntryPoint: function() {
		if (typeof window.wgWikiaChatUsers === 'string') {
			// for logged-in users the information about chat users is serialized into JS global variable
			window.wgWikiaChatUsers = window.wgWikiaChatUsers.length ? JSON.parse(window.wgWikiaChatUsers) : [];
		}
		// in case the module is embedded in the article, we can have several modules on the page. work on them one by one
		$('.ChatModuleUninitialized').each(function() {
			ChatEntryPoint.processModuleTemplate($(this));
			$(this).removeClass('ChatModuleUninitialized');
		});
	},

	// fill-in the whole module template
	processModuleTemplate: function($t) {
		// @todo - right now it's a custom html-based template, all the logic for inserting variables is here
		// once the mustache is loaded on every page, rewrite the template and remove most of the code below
		var items = [], i, cnt = window.wgWikiaChatUsers.length, img = window.wgWikiaChatProfileAvatarUrl;
		$t.find('.chat-contents').
			addClass((cnt) ? 'chat-room-active' :  'chat-room-empty').
			addClass((window.wgUserName) ? 'chat-user-logged-in' :  'chat-user-anonymous');
		$t.find('.chat-total').html(cnt);
		$t.find('p.chat-name').html(window.wgSiteName);
		if (!window.wgUserName) {
			$t.find('div.chat-join button').addClass('loginToChat');
		}
		// we use attr instead of data because we want it to be present in dom (needed for css selector)
		$t.find('div.chat-join button').attr('data-msg-id', cnt ? 'chat-join-the-chat' : 'chat-start-a-chat');

		if (cnt) {
			var $carousel = $t.find('ul.carousel');
			var $u = $carousel.find('>li');
			for( i=0 ; i < cnt ; i++ ) {
				items.push(ChatEntryPoint.fillUserTemplate($u.clone(),window.wgWikiaChatUsers[i]));
			}
			$carousel.html(items);
			ChatEntryPoint.initCarousel($t.find('.chat-whos-here'));
		} else {
			$t.find('ul.carousel').remove();
		}
		if (img) {
			$t.find('.carousel-container img.avatar.currentUser').attr('src', img);
		} else {
			$t.find('.carousel-container img.avatar.currentUser').remove();
		}
		// process i18n the messages
		$t.find('[data-msg-id]').each(function() {
			var $e = $(this);
			$e.html($.msg($e.data('msg-id'), $e.data('msg-param')));
		});
	},

	// based on the template and user information, return a filled-in element
	fillUserTemplate: function($t, user) {
		if (user.showSince) {
			var months = window.wgWikiaChatMonts || window.wgMonthNamesShort;
			user.since = months[user.since_month] + ' ' + user.since_year;
		}
		$t.find('[data-user-prop]').each(function() {
			var $e = $(this), attr = $e.data('user-attr'), p = $e.data('user-prop'), v = user[p];
			if (typeof v === "undefined") {
				$e.remove();
			} else
			if (attr) {
				$e.attr(attr, v);
			} else {
				$e.html(v);
			}
		});
		return $t;
	},

	// change the user list into the carousel
	initCarousel: function($el) {
		$el.find('.carousel-container').carousel({
			nextClass: 'arrow-right',
			prevClass: 'arrow-left',
			itemsShown: (window.wgOasisResponsive) ? 5 : 6
		});

		// TODO: abstract this because we use this pattern in a few places: i.e. hovering over popover will not close it
		var popoverTimeout = 0;

		function setPopoverTimeout(elem) {
			popoverTimeout = setTimeout(function() {
				elem.popover('hide');
			}, 300);
		}

		$el.find('.chatter').popover({
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

	onClickChatButton: function(linkToSpecialChat) {
		if (window.wgUserName) {
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

if ( typeof wgWikiaChatUsers !== "undefined" ) {
	$(function() {
		ChatEntryPoint.init();
	});
}
