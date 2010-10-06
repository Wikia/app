$(function() {
	Interlang.init();
});

var Interlang = {
	init: function() {
		$('.WikiaArticleInterlang .more-link').click(Interlang.showAll);
	},
	
	showAll: function() {
		$('.WikiaArticleInterlang .more-link').hide();
		$('.WikiaArticleInterlang .more').show();
		 return false;
	}
}