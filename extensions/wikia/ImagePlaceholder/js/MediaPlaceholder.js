/* 
 * @author Liz Lee
 * 
 * Handle video placeholders that are saved in articles
 *
 */

/*global VET_show */
 
(function($, window) {
var MediaPlaceholder = {
	init: function() {
		// Don't run more than once
		if(this.loaded) {
			return;
		}
		this.loaded = true;
		
		var self = this;
		
		 $('#WikiaArticle').on('click', '.wikiaPlaceholder a', function(e) {
			e.preventDefault();
			
			var $this = $(this),
				id = $this.data('id'),
				align = $this.data('align'),
				width = $this.data('width') || null,
				thumb = $this.data('thumb'),
				link = $this.data('link'),
				caption = $this.data('caption');
			
			// For now, make this backwards compatible with unpurged saved placholders
			if($this.attr('onclick') != 'undefined') {
				return;
			}
				
			if($this.parent().parent().hasClass('wikiaVideoPlaceholder')) {
				// video - open VET
				$.when(
					$.loadYUI(),
					$.getResources([ 
						$.getSassCommonURL("/extensions/wikia/VideoEmbedTool/css/VET.scss" ),
						$.getSassCommonURL("/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss" ),
						window.wgExtensionsPath + "/wikia/VideoEmbedTool/js/VET.js",
						window.wgExtensionsPath + "/wikia/WikiaStyleGuide/js/Dropdown.js"
					])
				).done(function() {
					VET_show( self.getEvent(), -2, id, align, thumb, width, caption); 
				});
			} else {
				// image - open WMU
				$.when(
					$.loadYUI(),
					$.getResources([ 
						mw.loader.load( wgExtensionsPath + "/wikia/WikiaMiniUpload/css/WMU.css", "text/css" ),
						window.wgExtensionsPath + "/wikia/WikiaMiniUpload/js/WMU.js"
					])
				).done(function() {
					WMU_show( self.getEvent(), -2, id, align, thumb, width, caption, link);
				});
			}
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

window.MediaPlaceholder = MediaPlaceholder;

})(jQuery, this);