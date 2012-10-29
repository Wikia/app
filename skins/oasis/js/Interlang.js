(function($) {

var Interlang = {
	node: false,

	init: function() {
		this.node = $('.WikiaArticleInterlang');
		$('.more-link', this.node).click($.proxy(this.showAll, this));
	},

	showAll: function(ev) {
		ev.preventDefault();

		$('.more-link', this.node).hide();
		$('.more', this.node).show();
	}
};

$(function() {
	Interlang.init();
});

}(jQuery));
