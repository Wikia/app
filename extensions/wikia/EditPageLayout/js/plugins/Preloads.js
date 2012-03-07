(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.preloads = $.createClass(WE.plugin, {
		MIN_HEIGHT: 80,
		EXPANDED_CLASS: 'expanded',

		preloads: [],

		// find and setup preload areas
		init: function() {
			this.preloads = this.editor.element.find('.editpage-intro');
			this.preloads.each(this.proxy(this.setupPreloadArea));
		},

		// bind events to a given preload area
		setupPreloadArea: function(i, area) {
			area = $(area);
			area.data('expanded', false);

			var content = area.find('.editpage-intro-wrapper > div'),
				contentHeight = content.height(),
				expandLink = area.children('.expand');

			if (contentHeight > this.MIN_HEIGHT) {
				expandLink.
					bind('click', this.proxy(this.expand)).
					show();
			}
		},

		// expand / collapse given preload area
		expand: function(ev) {
			var expandLink = $(ev.target).closest('.expand'), 
				area = expandLink.parent(),
				isExpanded = !!area.data('expanded');

			area.
				toggleClass(this.EXPANDED_CLASS).
				data('expanded', !isExpanded);

			// resize edit window
			$(window).trigger('resize');

			// update expand link
			expandLink.children('label').
				text($.msg('editpagelayout-' + (!isExpanded ? 'less' : 'more')));

			expandLink.children('span').
				text(!isExpanded ? '-' : '+');
		}
	});

})(this,jQuery);