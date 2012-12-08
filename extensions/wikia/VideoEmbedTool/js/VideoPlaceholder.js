/* 
 * @author Liz Lee
 * 
 * Handle video placeholders that are saved in articles
 *
 */

/*global VET_show */
 
(function($, window) {

var VideoPlaceholder = {
	init: function() {
		// Don't run more than once
		if(this.loaded) {
			return;
		}
		this.loaded = true;
		
		var self = this;
		
		 $('#WikiaArticle').on('click', '.wikiaVideoPlaceholder a', function(e) {
			e.preventDefault();
			
			var $this = $(this),
				id = $this.data('id'),
				align = $this.data('align'),
				thumb = $this.data('thumb'),
				caption = $this.data('caption');

			$.loadYUI( function() {
				$.getScript(wgExtensionsPath + "/wikia/VideoEmbedTool/js/VET.js", function() { 
					VET_show( self.getEvent(), -2, id, align, thumb, null, caption); 
					$.getResources([ 
						$.getSassCommonURL("/extensions/wikia/VideoEmbedTool/css/VET.scss" ),
						window.wgExtensionsPath + "/wikia/WikiaStyleGuide/js/Dropdown.js",
						$.getSassCommonURL("/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss" )
					]);
				});
			});
		});
	},

	/**
	 * Finds the event in the window object, the caller's arguments, or
	 * in the arguments of another method in the callstack.  This is
	 * executed automatically for events registered through the event
	 * manager, so the implementer should not normally need to execute
	 * this function at all.
	 * @method getEvent
	 * @param {Event} e the event parameter from the handler
	 * @param {HTMLElement} boundEl the element the listener is attached to
	 * @return {Event} the event
	 * @static
	 *
	 * @deprecated - used by WMU and VET only
	 */
	getEvent: function(e, boundEl) {
		var ev = e || window.event;
	
		if (!ev) {
			var c = this.getEvent.caller;
			while (c) {
				ev = c.arguments[0]; /* JSlint ignore */
				if (ev && Event == ev.constructor) { /* JSlint ignore */
					break;
				}
				c = c.caller;
			}
		}
	
		return ev;
	}

};

window.VideoPlaceholder = VideoPlaceholder;

})(jQuery, this);