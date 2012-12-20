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
		this.videoLoaded = false;
		this.imageLoaded = false;

		// Don't allow editing on history or diff pages
		this.disabled = ( $.getUrlVar('diff') || $.getUrlVar('oldid') );

		var self = this;

		 $('#WikiaArticle').on('click', '.wikiaPlaceholder a', function(e) {
			e.preventDefault();

			// cache jquery object
			var $this = $(this),
				props;

			// For now, make this somewhat backwards compatible with unpurged saved placholders
			if($this.prop('onclick')) {
				return;
			}
			
			// Provide immediate feedback once button is clicked
			var oText = $this.text();
			$this.startThrobbing();

			if($this.parent().parent().hasClass('wikiaVideoPlaceholder')) {
				// handle video placeholder
				if(self.disabled) {
					GlobalNotification.show( $.msg('imgplc-notinhistory-video'), 'warn' );
					return;
				}

				props = self.getProps($this);

				if(!self.videoLoaded) {
					// open VET
					$.when(
						$.getJSON( window.wgScriptPath + "index.php?action=ajax&rs=VET&method=getMsgVars"), // leave this in first position
						$.loadYUI(),
						$.getResources([ 
							$.getSassCommonURL("/extensions/wikia/VideoEmbedTool/css/VET.scss" ),
							$.getSassCommonURL("/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss" ),
							window.wgExtensionsPath + "/wikia/VideoEmbedTool/js/VET.js",
							window.wgExtensionsPath + "/wikia/WikiaStyleGuide/js/Dropdown.js"
						])
					).done(function(VETMessages) {
						// VET i18n messages 
						for (var v in VETMessages) {
							wgMessages[v] = VETMessages[v];
						}
						
						self.videoLoaded = true;
	
						$this.text(oText);
						VET_show( self.getEvent(), -2, props.id, props.align, props.thumb, props.width, props.caption); 
					});
				} else {
					$this.text(oText);
					VET_show( self.getEvent(), -2, props.id, props.align, props.thumb, props.width, props.caption); 				
				}
			} else {
				// handle image placeholder
				if(self.disabled) {
					GlobalNotification.show( $.msg('imgplc-notinhistory'), 'warn' );			
					return;
				}

				props = self.getProps($this);

				if(!self.imageLoaded) {
					// open WMU
					$.when(
						$.loadYUI(),
						$.getResources([ 
							window.wgExtensionsPath + "/wikia/WikiaMiniUpload/js/WMU.js",
							window.wgExtensionsPath + "/wikia/WikiaMiniUpload/css/WMU.css"
						])
					).done(function() {
						self.imageLoaded = true;
						
						$this.text(oText);
						WMU_show( self.getEvent(), -2, props.id, props.align, props.thumb, props.width, props.caption, props.link);
					});
				} else {
					$this.text(oText);
					WMU_show( self.getEvent(), -2, props.id, props.align, props.thumb, props.width, props.caption, props.link);				
				}
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