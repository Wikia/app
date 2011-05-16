(function() {
	$(window).load(function() {
		setTimeout(lazyLoadChatModule, 250);
	});
	
	function lazyLoadChatModule() {
		// Modules are cached for a bit, so we add the username to the URL so it ends up being cached on a per-user basis (so that we don't get the wrong user-lang or avatar).
		// Since caching of modules is not ironed out yet (currently I think they all cache for 24 hours), make a cb based on the minute:
		var currentTime = new Date();
		var minuteTimestamp = currentTime.getFullYear() + currentTime.getMonth() + currentTime.getDate() + currentTime.getHours() + currentTime.getMinutes();
		$(".ChatModule").load(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=Contents&outputType=html&username=' + encodeURIComponent(wgUserName) + '&cb=' + minuteTimestamp);
	}
})();
