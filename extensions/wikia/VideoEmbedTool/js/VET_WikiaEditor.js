/* global WikiaEditor, RTE, insertTags */
(function (window, $) {
	'use strict';

	var editorVET = function (event) {
		var mode = 'create',
			embedPresets = {},
			startPoint = 1, // Start on first or second screen of VET
			element = false,
			onClose = null,
			triggeredFromRTE = event && event.type === 'rte',
			callback = null,
			wikiaEditor,
			track = null,
			options;

		if (event && event.data ) {
			if (event.data.element) {
				// Video or Placeholder element was clicked in RTE
				element = event.data.element;
			}
			if (event.data.track) {
				// extra tracking info sent from extension
				track = event.data.track;
			}
		}

		if (triggeredFromRTE) {
			wikiaEditor = WikiaEditor.getInstance();

			// Handle MiniEditor focus
			if (wikiaEditor.config.isMiniEditor) {
				wikiaEditor.plugins.MiniEditor.hasFocus = true;

				onClose = function () {
					wikiaEditor.editorFocus();
					wikiaEditor.plugins.MiniEditor.hasFocus = false;
				};
			}

			// get video from event data
			if (element) {
				// edit a video
				mode = 'edit';
				embedPresets = element.getData();

				if (!event.data.isPlaceholder) {
					// "regular" video
					$.extend(embedPresets, embedPresets.params);
					delete embedPresets.params;

					startPoint = 2;
				}
			}
		}

		if (mode === 'create') {
			callback = function (embedData) {
				var wikitag = $('#VideoEmbedTag').val();
				if (!triggeredFromRTE) {
					window.WikiaEditor.getInstance().getEditbox().focus();
					// VID-1177 IE11 execution order was inserting tags before switching focus
					setTimeout(function () {
						insertTags(wikitag, '', '');
					}, 0);
				} else if (element && element.hasClass('media-placeholder')) {
					// replace "Add Video" placeholder
					RTE.mediaEditor.update(element, wikitag, embedData);
				} else {
					RTE.mediaEditor.addVideo(wikitag, embedData);
				}

			};
		} else if (mode === 'edit' && element) {
			callback = function (embedData) {
				var wikitext = '';

				// Handle video placeholders in the editor [[File:Placeholder|video]]
				if (element.hasClass('media-placeholder')) {
					wikitext = embedData.wikitext;
					RTE.mediaEditor.update(element, wikitext, embedData);
				} else {
					// generate wikitext
					wikitext = '[[' + embedData.href + '|thumb';

					if (embedData.align) {
						wikitext += '|' + embedData.align;
					}

					if (embedData.width) {
						wikitext += '|' + embedData.width + 'px';
					}

					if (embedData.caption) {
						wikitext += '|' + embedData.caption;
					}

					wikitext += ']]';

					if (element) {
						// update existing video
						RTE.mediaEditor.update(element, wikitext, embedData);

						require(['wikia.vet'], function (vet) {
							vet.close();
						});
					} else {
						// add new video
						RTE.mediaEditor.addVideo(wikitext, embedData);
					}
				}
			};
		}

		options = {
			callbackAfterEmbed: callback,
			embedPresets: embedPresets,
			onClose: onClose,
			startPoint: startPoint,
			track: track
		};

		window.vetLoader.load(options);
	};

	window.vetWikiaEditor = editorVET;

})(window, jQuery);
