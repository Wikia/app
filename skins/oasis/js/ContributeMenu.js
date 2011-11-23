var ContributeMenu = {
	track: function(url) {
		$.tracker.byStr('wikiheader/wikinav/contribute/' + url);
	},

	init: function() {
		var menu = $('nav.contribute');

		menu.bind('click', $.proxy(function(ev) {
			var node = $(ev.target);

			if (node.is('a')) {
				this.track(node.attr("data-id"));
			}
			else if (node.is('nav')) {
				this.track('open');
			}
		}, this));
	}
}

$(function() {
	ContributeMenu.init();
});
