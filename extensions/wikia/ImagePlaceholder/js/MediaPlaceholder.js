/*
 * @author Liz Lee
 *
 * Handle video placeholders that are saved in articles
 *
 */

(function ($, window) {

	'use strict';

	// Make global so JSSnippets can pick it up
	window.MediaPlaceholder = {

		init: function () {

			// Don't run more than once
			if (this.loaded) {
				return;
			}

			this.loaded = true;
			this.imageLoaded = false;
			this.WikiaArticle = $('#WikiaArticle');

			// Don't allow editing on history or diff pages
			if ($.getUrlVar('diff') || $.getUrlVar('oldid')) {
				return;
			}

			this.setupVideoPlaceholders();
			this.setupImagePlaceholders();
		},

		setupImagePlaceholders: function () {
			var self = this;

			// Handle clicks on image placeholders (video placeholders are handled differently)
			this.WikiaArticle.on('click', '.wikiaImagePlaceholder a', function (e) {
				var open,
					$this = $(this),
					props = self.getProps($this);

				e.preventDefault();

				open = function () {
					window.WMU_show(window.event, { // jshint ignore:line
						gallery: -2,
						box: props.placeholderIndex,
						align: props.align,
						thumb: props.thumb,
						size: props.width,
						caption: props.caption,
						link: props.link,
						track: {
							action: Wikia.Tracker.ACTIONS.CLICK,
							category: 'image-placeholder',
							label: 'view-mode',
							method: 'analytics'
						}

					});
				};

				// Provide immediate feedback once button is clicked
				$this.startThrobbing();

				if (!self.imageLoaded) {
					// open WMU
					$.when(
						$.getResources([
							$.loadYUI,
							$.loadJQueryAIM,
							$.getSassCommonURL('extensions/wikia/WikiaMiniUpload/css/WMU.scss'),
							window.wgResourceBasePath + '/extensions/wikia/WikiaMiniUpload/js/WMU.js'
						])
					).done(function () {
						self.imageLoaded = true;
						$this.stopThrobbing();
						open();
					});
				} else {
					$this.stopThrobbing();
					open();
				}
			});
		},
		setupVideoPlaceholders: function () {
			var self = this;

			self.WikiaArticle.find('.wikiaVideoPlaceholder a').each(function () {
				var $this = $(this),
					props = self.getProps($this);

				$this.addVideoButton({
					embedPresets: props,
					insertFinalVideoParams: [
						'placeholder=1',
						'box=' + props.placeholderIndex,
						'article=' + encodeURIComponent(window.wgTitle),
						'ns=' + window.wgNamespaceNumber
					],
					callbackAfterEmbed: $.proxy(self.videoEmbedCallback, self),
					track: {
						action: Wikia.Tracker.ACTIONS.CLICK,
						category: 'video-placeholder',
						label: 'view-mode',
						method: 'analytics'
					}
				});
			});
		},

		videoEmbedCallback: function (embedData) {
			var placeholders = this.WikiaArticle.find('.wikiaVideoPlaceholder a'),
				// get placeholder to turn into a video thumbnail
				toUpdate = placeholders.filter('[data-id=' + embedData.placeholderIndex + ']'),
				// get thumbnail code from hidden div in success modal
				html = $('#VideoEmbedCode').html();

			toUpdate.closest('.wikiaVideoPlaceholder').replaceWith(html);

			// update data id so we can match DOM placeholders to parsed wikitext placeholders
			placeholders.each(function () {
				var $this = $(this),
					id = $this.attr('data-id');

				if (id > embedData.placeholderIndex) {
					$this.attr('data-id', id - 1);
				}
			});

			// purge cache of article so video will show up on reload
			$.post(window.wgScript, {
				title: window.wgPageName,
				action: 'purge'
			});

			// re-bind events
			this.setupVideoPlaceholders();
		},

		// Get data for WMU / VET from placeholder element
		getProps: function ($elem) {
			return {
				placeholderIndex: $elem.attr('data-id'),
				align: $elem.attr('data-align'),
				width: $elem.attr('data-width'),
				thumb: $elem.attr('data-thumb'),
				link: $elem.attr('data-link'),
				caption: $elem.attr('data-caption')
			};
		}
	};
})(jQuery, window);
