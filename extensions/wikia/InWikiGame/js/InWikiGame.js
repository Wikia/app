var InWikiGame = {
	init: function() {
		$().log('inwikigame init');
		var iframeUrl = 'http://wikia.com/';
		$('#InWikiGameWrapper').click(function() {
			var iframe = document.createElement("iframe");
			iframe.setAttribute("src", iframeUrl);
			this.html(iframe);
		});
	}
}

$(function () {
	InWikiGame.init();
});
