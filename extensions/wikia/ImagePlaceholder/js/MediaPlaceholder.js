/* 
 * @author Liz Lee
 * 
 * Handle video placeholders that are saved in articles
 *
 */

/*global VET_show, WMU_show */
 
(function($, window) {
var MediaPlaceholder = {

	init: function() {

		// Don't run more than once
		if(this.loaded) {
			return;
		}

		this.loaded = true;

		// Don't allow editing on history or diff pages
		this.disabled = ( $.getUrlVar('diff') || $.getUrlVar('oldid') );

		var self = this;

		 $('#WikiaArticle').on('click', '.wikiaPlaceholder a', function(e) {
			e.preventDefault();

			// cache jquery object
			var $this = $(this);

			// For now, make this somewhat backwards compatible with unpurged saved placholders
			if($this.prop('onclick')) {
				return;
			}

			if($this.parent().parent().hasClass('wikiaVideoPlaceholder')) {
				// handle video placeholder

				if(self.disabled) {
					GlobalNotification.show( $.msg('imgplc-notinhistory-video'), 'warn' );
					return;
				}

				var props = self.getProps($this);

				// open VET
				$.when(
					$.loadYUI(),
					$.getResources([ 
						$.getSassCommonURL("/extensions/wikia/VideoEmbedTool/css/VET.scss" ),
						$.getSassCommonURL("/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss" ),
						window.wgExtensionsPath + "/wikia/VideoEmbedTool/js/VET.js",
						window.wgExtensionsPath + "/wikia/WikiaStyleGuide/js/Dropdown.js"
					])
				).done(function() {
					VET_show( self.getEvent(), -2, props.id, props.align, props.thumb, props.width, props.caption); 
				});
			} else {
				// handle image placeholder
				if(self.disabled) {
					GlobalNotification.show( $.msg('imgplc-notinhistory'), 'warn' );			
					return;
				}

				var props = self.getProps($this);

				// open WMU
				$.when(
					$.loadYUI(),
					$.getResources([ 
						window.wgExtensionsPath + "/wikia/WikiaMiniUpload/js/WMU.js",
						window.wgExtensionsPath + "/wikia/WikiaMiniUpload/css/WMU.css"
					])
				).done(function() {
					WMU_show( self.getEvent(), -2, props.id, props.align, props.thumb, props.width, props.caption, props.link);
				});
			}
		});
	},

	// Get data for WMU / VET from placeholder element
	getProps: function(elem) {
		return {
			id: elem.data('id'),
			align: elem.data('align'),
			width: elem.data('width') || null,
			thumb: elem.data('thumb'),
			link: elem.data('link'),
			caption: elem.data('caption')
		}
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