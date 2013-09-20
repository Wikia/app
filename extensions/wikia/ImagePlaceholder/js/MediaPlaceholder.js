/*
 * @author Liz Lee
 *
 * Handle video placeholders that are saved in articles
 *
 */

(function($, window) {
var MediaPlaceholder = {

	init: function() {

		// Don't run more than once
		if(this.loaded) {
			return;
		}

		this.loaded = true;
		this.imageLoaded = false;
		this.WikiaArticle = $('#WikiaArticle');

		// Don't allow editing on history or diff pages
		if( $.getUrlVar('diff') || $.getUrlVar('oldid') ){
			return false;
		}

		var self = this;

		this.setupVideoPlaceholders();

		// TODO: use .wikiaImagePlaceholder instead of .wikiaPlaceholder after
		// all articles have purged (after 14 days)
		// Then we can remove wikiaVideoPlaceholder check below
		$('#WikiaArticle').on('click', '.wikiaPlaceholder a', function(e) {
			var $this = $(this);

			// video placeholders handled differently
			if($this.parent().parent().hasClass('wikiaVideoPlaceholder')) {
				return;
			}

			e.preventDefault();

			// Provide immediate feedback once button is clicked
			var oText = $this.text();
			$this.startThrobbing();

			var props = self.getProps($this);

			if(!self.imageLoaded) {
				// open WMU
				$.when(
					$.getResources([
						$.loadYUI,
						$.loadJQueryAIM,
						$.getSassCommonURL( 'extensions/wikia/WikiaMiniUpload/css/WMU.scss'),
						wgResourceBasePath + '/extensions/wikia/WikiaMiniUpload/js/WMU.js'
					])
				).done(function() {
					self.imageLoaded = true;

					$this.text(oText);
					window.WMU_show( self.getEvent(), -2, props.placeholderIndex, props.align, props.thumb, props.width, props.caption, props.link);
				});
			} else {
				$this.text(oText);
				window.WMU_show( self.getEvent(), -2, props.placeholderIndex, props.align, props.thumb, props.width, props.caption, props.link);
			}
		});
	},

	setupVideoPlaceholders: function() {
		var self = this;

		self.WikiaArticle.find('.wikiaVideoPlaceholder a').each(function() {

			var $this = $(this),
				props = self.getProps($this);

			$this.addVideoButton({
				embedPresets: props,
				insertFinalVideoParams: ['placeholder=1', 'box=' + props.placeholderIndex, 'article='+encodeURIComponent( wgTitle ), 'ns='+wgNamespaceNumber],
				callbackAfterEmbed: self.videoEmbedCallback
			});
		});
	},

	videoEmbedCallback: function(embedData) {
		var placeholders = MediaPlaceholder.WikiaArticle.find('.wikiaVideoPlaceholder a'),
			// get placeholder to turn into a video thumbnail
			to_update = placeholders.filter('[data-id='+embedData.placeholderIndex+']'),
			// get thumbnail code from hidden div in success modal
			html = $('#VideoEmbedCode').html();

		to_update.parent().parent().replaceWith(html);

		// update data id so we can match DOM placeholders to parsed wikitext placeholders
		placeholders.each(function() {
			var $this = $(this),
				id = $this.attr('data-id');

			if(id > embedData.placeholderIndex) {
				$this.attr('data-id', id-1);
			}
		});

		// purge cache of article so video will show up on reload
		$.post(wgScript, {title: wgPageName, action: 'purge'});

		// re-bind events
		MediaPlaceholder.setupVideoPlaceholders();


	},


	// Get data for WMU / VET from placeholder element
	getProps: function(elem) {
		return {
			placeholderIndex: elem.attr('data-id'),
			align: elem.attr('data-align'),
			width: elem.attr('data-width'),
			thumb: elem.attr('data-thumb'),
			link: elem.attr('data-link'),
			caption: elem.attr('data-caption')
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