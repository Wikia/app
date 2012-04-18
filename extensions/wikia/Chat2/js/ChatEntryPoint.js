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
		var currentTime = new Date();
		var minuteTimestamp = currentTime.getFullYear() + currentTime.getMonth() + currentTime.getDate() + currentTime.getHours() + currentTime.getMinutes();
		$.get(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=Contents&outputType=html&cb=' + minuteTimestamp, ChatEntryPoint.entryPointLoaded);
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

		// Bound before slideshow is called so we can capture the first event
		chatWhosHere.bind('slide', function(e, data) {
			chatWhosHere.find('.arrow-left').toggleClass('inactive', data.currentSlideId == 0);
			chatWhosHere.find('.arrow-right').toggleClass('inactive', data.currentSlideId == (data.totalSlides - 1));
		});

		chatWhosHere.slideshow({
			fadeDuration: 0,
			nextClass: 'arrow-right',
			prevClass: 'arrow-left',
			slidesClass: 'slider',
			stayOn: 1
		});

		// Hovering on avatar opens user stats menu
		chatWhosHere.find('.chatter').hover(function(event) {
			$('.UserStatsMenu').hide();
			$(this).find('.UserStatsMenu').show();
		}, function() {
			$(this).find('.UserStatsMenu').hide();		
		});
	},

	onClickChatButton: function(isLoggedIn, linkToSpecialChat) {
		if (isLoggedIn) {
			window.open(linkToSpecialChat, 'wikiachat', wgWikiaChatWindowFeatures);
			$('.modalWrapper').closeModal();
		} else {
			UserLoginModal.show({
				persistModal: true,
				callback: function() {
					$('.modalWrapper').children().not('.close').not('.modalContent').not('h1').remove();
					$('.modalContent').load(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=AnonLoginSuccess&outputType=html');						
				}
			});
		}
	}
};

$(function() {
	if ( typeof wgWikiaChatModuleContent!=="undefined" ) {
		ChatEntryPoint.init();
		$('body').on('click', '.WikiaChatLink', function(event) {event.preventDefault();event.stopPropagation();ChatEntryPoint.onClickChatButton(wgUserName !== null, this.href);});
	}
});