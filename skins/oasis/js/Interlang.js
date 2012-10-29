(function($) {

var Interlang = {
	init: function() {
		$('.WikiaArticleInterlang .more-link').click(Interlang.showAll);
	},

	showAll: function(ev) {
		ev.preventDefault();

		$('.WikiaArticleInterlang .more-link').hide();
		$('.WikiaArticleInterlang .more').show();
	}
};

$(function() {
	Interlang.init();
});

}(jQuery));
