$(function() {
	var wallUserTalkArchive = new WallUserTalkArchive();
});

var WallUserTalkArchive = $.createClass(Object, {
	constructor: function() {
		$('.back-user-wall').click(this.proxy(function(){
			this.track('wall/archived_talk_page/breadcrumb');
		}));
		//oasis
		$('.wikia-menu-button a[data-id="history"]').click(this.proxy(function(){
			this.track('wall/archived_talk_page/history');
		}));
		$('.wikia-menu-button a[data-id="edit"]').click(this.proxy(function(){
			var node = $(this);
			
			if( node.attr('id') == 'talkArchiveEditButton' ) {
				this.track('wall/archived_talk_page/edit');
			} else {
				this.track('wall/archived_talk_page/view_source_button');
			}
		}));
		//monobook
		$('#ca-history').click(this.proxy(function(){
			this.track('wall/archived_talk_page/history');
		}));
		$('#ca-view-source').click(this.proxy(function(){
			this.track('wall/archived_talk_page/view_source_button');
		}));
	},
	
	track: function(url) {
		if( typeof($.tracker) != 'undefined' ) {
		//oasis
			$.tracker.byStr(url);
		} else {
		//monobook
			WET.byStr(url);
		}
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
	}
});