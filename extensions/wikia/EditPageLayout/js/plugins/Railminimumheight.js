(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

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
					// Use body height not window height because if below min viewport height, page scrolls (BugId: 11282)
					var h = $('body').height() - el.offset().top - (el.outerHeight(true) - el.height()) - $('#WikiaFooter').outerHeight();
					el.css({
						'overflow-y': 'auto',
						'height' : h
					});
				}
			}
		}


	});

})(this,jQuery);
