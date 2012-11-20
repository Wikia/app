/*global UserLoginModal*/

var ChatEntryPoint = {
	loading: false,

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

		var chatWhosHere = $('.ChatModule .chat-whos-here');

		chatWhosHere.find('.carousel-container').carousel({
			nextClass: 'arrow-right',
			prevClass: 'arrow-left',
			itemsShown: 6
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
			window.open(linkToSpecialChat, 'wikiachat', wgWikiaChatWindowFeatures);
		} else {
			UserLoginModal.show({
				persistModal: true,
				callback: function() {
					$('.modalWrapper').children().not('.close').not('.modalContent').not('h1').remove();
					$.nirvana.sendRequest({
						controller: 'ChatRail',
						method: 'AnonLoginSuccess',
						type: 'GET',
						format: 'html',
						callback: function(html) {
							$('.modalContent').html(html);
						}
					});
				}
			});
		}
	}
};

$(function() {
	if ( typeof wgWikiaChatModuleContent!=="undefined" ) {
		ChatEntryPoint.init();
		$('body').on('click', '.WikiaChatLink', function(event) {
			event.preventDefault();
			event.stopPropagation();
			ChatEntryPoint.onClickChatButton(wgUserName !== null, this.href);
		});
	}
});