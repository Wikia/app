(function() {
	$(window).load(function() {
		setTimeout(lazyLoadChatModule, 250);
	});
	
	function lazyLoadChatModule() {
		$(".ChatModule").load(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ChatRail&actionName=Contents&outputType=html');
	}
})();