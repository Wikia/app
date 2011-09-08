var ChatRailModule = {
	init: function() {
		// Lazy load module contents
		$(window).load(function() {
			setTimeout(ChatRailModule.lazyLoadChatModule, 250);
		});			
	},
	
	lazyLoadChatModule: function() {
		// Modules are cached for a bit, so we add the username to the URL so it ends up being cached on a per-user basis (so that we don't get the wrong user-lang or avatar).
		// Since caching of modules is not ironed out yet (currently I think they all cache for 24 hours), make a cb based on the minute:
		var currentTime = new Date();
		var minuteTimestamp = currentTime.getFullYear() + currentTime.getMonth() + currentTime.getDate() + currentTime.getHours() + currentTime.getMinutes();
		$(".ChatModule").load(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=Contents&outputType=html&username=' + encodeURIComponent(wgUserName) + '&cb=' + minuteTimestamp, ChatRailModule.userStatsMenuInit);
	},
	
	userStatsMenuInit: function() {
		// Hovering on avatar opens user stats menu
		$('.ChatModule .chat-whos-here > ul > li').hover(function(event) {
			$('.UserStatsMenu').hide();
			$(this).find('.UserStatsMenu').show();
		}, function() {
			$(this).find('.UserStatsMenu').hide();		
		});
	}
};

$(function() {
	ChatRailModule.init();
});