function WidgetCommunity_init(id, widget) {

	// my user page / talk page / widgets
	if (wgUserName) {
		$('#widget_' + id + '-my-menu').children('a').each( function(n) {
			$(this).click( function(e) {
				url = (['MyHome'])[n];
				WET.byStr('widget/WidgetCommunity/' + url);
			});
		});

		// user page link in Welcome back...
		$('#widget_' + id + '-my-name').click( function(e) {
                	WET.byStr('widget/WidgetCommunity/MyPage');
        	});
	}

	$('#widget_' + id + '-more').click( function(e) {
                WET.byStr('widget/WidgetCommunity/more');
        });

	// Latest Activity links
	// ignore "more..." link
	$('#widget_' + id + '-recently-edited').find('a').slice(0, -1).each(function(n) {
		$(this).click( function(e) {
			url = (n%2 == 0 ? 'RAlink/' : 'RAuser/') + parseInt(Math.floor(n/2) + 1);
			WET.byStr('widget/WidgetCommunity/' + url);
		});
	});
}

function WidgetCommunityDetailsToggle(node) {
	$(node).siblings("ul").toggle();
}
