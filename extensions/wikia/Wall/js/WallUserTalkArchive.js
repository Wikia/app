$(function() {
	if( typeof(wgUserName) != 'undefined' && wgUserName != null ) {
		$('.wikia-menu-button a[data-id="history"]').trackClick('wall/archived_talk_page/history');
		$('#WikiaPageHeader .back-user-wall').trackClick('wall/archived_talk_page/breadcrumb');
		$('.wikia-menu-button a[data-id="edit"]').click(function(e) {
			var node = $(e.target);
			
			if( node.attr('id') == 'talkArchiveEditButton' ) {
				$.tracker.byStr('wall/archived_talk_page/edit');
			} else {
				$.tracker.byStr('wall/archived_talk_page/view_source_button');
			}
		});
	} else {
		$('.wikia-menu-button a[data-id="history"]').trackClick('wall/archived_talk_page/history');
		$('#WikiaPageHeader .back-user-wall').trackClick('wall/archived_talk_page/breadcrumb');
		$('.wikia-menu-button a[data-id="edit"]').trackClick('wall/archived_talk_page/view_source_button');
	}
});