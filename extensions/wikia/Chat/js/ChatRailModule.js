(function() {
	$(window).load(function() {
		setTimeout(lazyLoadChatModule, 250);
	});
	
	function lazyLoadChatModule() {
		// Modules are cached for a bit, so we add the username to the URL so it ends up being cached on a per-user basis (so that we don't get the wrong user-lang or avatar).
		$(".ChatModule").load(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=Contents&outputType=html&username=' + encodeURIComponent(wgUserName));
	}
})();
