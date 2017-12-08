(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Adds a custom event "sizeChanged"
	 * when editor area is resized
	 */
	WE.plugins.sizechangedevent = $.createClass(WE.plugin,{

		initDom: function() {
			var self = this, editor = this.editor;

			this.fireResizeEvent();

			$(window).bind('resize', function() {
				self.fireResizeEvent();
			});

			// trigger this event to recalculate top offset
			this.editor.element.bind('resize', function() {
				self.fireResizeEvent();
			});

			// dirty trick to allow toolbar / right rail to be fully initialized
			//setTimeout(this.proxy(this.fireResizeEvent),10);
		},

		fireResizeEvent: function() {
			this.editor.fire('sizeChanged',this.editor);
		}

	});

})(this,jQuery);
