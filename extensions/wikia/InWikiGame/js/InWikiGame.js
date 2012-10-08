var InWikiGame = {
	init: function(jsonObject) {
		var iframeUrl = 'http://www.realmofthemadgod.com/';
		$('.InWikiGameWrapper').click(function() {
			var iframe = document.createElement("iframe");
			iframe.setAttribute("src", iframeUrl);
			$(this).html(iframe);
		});
	}
}