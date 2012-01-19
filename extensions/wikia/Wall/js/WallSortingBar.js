$(document).ready(function() {
	var wallSortingBar = new WallSortingBar();
});

//var global_hide = 0;

var WallSortingBar = $.createClass(Object, {
	constructor: function() {
		//click tracking
		$('.sortingOption').click(this.proxy(this.trackClick));
		
		// sorting menu
		$('.SortingSelected').click( function(e) {
			var menu = $(e.target).closest('.SortingMenu').children('.SortingList');
			menu.show();
			var ofs = menu.find('li.current').offset().top - menu.find('li').first().offset().top;
			menu.css('top',-ofs -4);
		} );
		
		$('.SortingList').mouseleave( function(e) {
			$(e.target).closest('.SortingList').hide();
		} );
	},
	
	track: function(url) {
		if( typeof($.tracker) != 'undefined' ) {
			$.tracker.byStr(url);
		} else {
			WET.byStr(url);
		}
	},
	
	trackClick: function(event) {
		var node = $(event.target),
			parent = node.parent();
		
		if( node.hasClass('sortingOption') && parent.hasClass('nt') ) {
			this.track('wall/sort/newest-thread');
		} else if( node.hasClass('sortingOption') && parent.hasClass('ot') ) {
			this.track('wall/sort/oldest-thread');
		} else if( node.hasClass('sortingOption') && parent.hasClass('nr') ) {
			this.track('wall/sort/newest-reply');
		} else if( node.hasClass('sortingOption') && parent.hasClass('ma') ) {
			this.track('wall/sort/most-active');
		} else if( node.hasClass('sortingOption') && parent.hasClass('a') ) {
			this.track('wall/sort/archive');
		}
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
	}
});