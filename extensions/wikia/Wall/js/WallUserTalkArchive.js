$(function() {
	if( typeof(wgUserName) != 'undefined' && wgUserName != null ) {
		$('.wikia-menu-button a[data-id="history"]').trackClick('1_wikia/user/wall/archived_talk_page/history');
		$('.wikia-menu-button a[data-id="edit"]').trackClick('1_wikia/user/wall/archived_talk_page/view_source_button');
	} else {
		$('.wikia-menu-button a[data-id="history"]').trackClick('1_wikia/anon/wall/archived_talk_page/history');
		$('.wikia-menu-button a[data-id="edit"]').trackClick('1_wikia/anon/wall/archived_talk_page/view_source_button');
	}
});