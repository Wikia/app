(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	/**
	 * Adds scroll bar to right rail if rail is shorter than the specified minimum
	 */
	WE.plugins.railminimumheight = $.createClass(WE.plugin,{

		requires: ['sizechangedevent'],

		MINIMUM_VIEWPORT_HEIGHT: 775,
		CONTAINER_SELECTOR: '> .rail-auto-height',

		beforeInit: function() {
			this.editor.on('sizeChanged',this.proxy(this.delayedResize));
		},

		delayedResize: function() {
			setTimeout(this.proxy(this.resize),10);
		},

		// get height needed to fit given node into browser's viewport height
		getHeightToFit: function(node) {
			var topOffset = node.offset().top,
				viewportHeight = $(window).height();

			return viewportHeight - topOffset;
		},

		resize: function() {
			var viewportHeight = $(window).height();
			var el, rail = this.editor.getSpace('rail');

			if (rail.exists() && (el = rail.find(this.CONTAINER_SELECTOR)) && el.exists()) {
				if (viewportHeight > this.MINIMUM_VIEWPORT_HEIGHT) {
					el.css({
						'overflow-y': 'hidden',
						'height': 'auto'
					});
				} else {
					var h = viewportHeight - el.offset().top - (el.outerHeight(true) - el.height());
					el.css({
						'overflow-y': 'auto',
						'height' : h
					});
				}
			}
		}


	});

})(this,jQuery);
