var InWikiGame = {
	init: function(jsonObject) {
		var iframeUrl = 'http://www.realmofthemadgod.com/';
		$('.InWikiGameWrapper').click(function() {
			var iframe = $(
				'<iframe></iframe>',
				{
					'src': iframeUrl,
					'width': '800px',
					'height': '600px'
				}
			);
			$(this).html(iframe);
		});
	}
}
