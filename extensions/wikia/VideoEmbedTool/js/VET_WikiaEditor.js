
(function(window, $) {

	var VET_WikiaEditor = function(event) {
		var mode = 'create',
			embedPresets = {},
			exists = false,
			// Start on first or second screen of VET
			startPoint = 1,
			element = false,
			onClose = null,
			triggeredFromRTE = event && event.type === 'rte',
			callback = null;

		if (event && event.data && event.data.element) {
			// Video or Placeholder element was clicked in RTE
			element = event.data.element;
		}

		if (triggeredFromRTE) {
			var wikiaEditor = WikiaEditor.getInstance();

			// Handle MiniEditor focus
			if (wikiaEditor.config.isMiniEditor) {
				wikiaEditor.plugins.MiniEditor.hasFocus = true;

				onClose = function() {
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

		if(mode === 'create') {
			callback = function(embedData) {
				var wikitag = $('#VideoEmbedTag').val();
				if(!triggeredFromRTE) {
					// I don't know what this is for - hyun
					if (typeof RTE !== 'undefined') {
						RTE.getInstanceEditor().getEditbox().focus();
					} // end of I don't know
					var editorTextArea = WikiaEditor.getInstance().getEditbox()[0];
					editorTextArea.focus();
					insertTags( wikitag, '', '', editorTextArea);
				}
				else if (element && element.hasClass('media-placeholder')) {
					// replace "Add Video" placeholder
					RTE.mediaEditor.update(element, wikitag, embedData);
				}
				else {
					RTE.mediaEditor.addVideo(wikitag, embedData);
				}

			};
		} else if(mode === 'edit') {
			callback = function (embedData) {
				if (element != 'undefined') {
					var wikitext = '';

					// Handle video placeholders in the editor [[File:Placeholder|video]]
					if(element.hasClass('media-placeholder')) {
						wikitext = embedData.wikitext;
						RTE.mediaEditor.update(element, wikitext, embedData);
					} else {
						// generate wikitext
						wikitext = '[[' + embedData.href;

						if (embedData.thumb) {
							wikitext += '|thumb';
						}

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
							//
							require(['wikia.vet'], function(vet) {
								vet.close();
							});
						} else {
							// add new video
							RTE.mediaEditor.addVideo(wikitext, embedData);
						}
					}
				}
			};
		}

		var options = {
			callbackAfterEmbed: callback,
			embedPresets: embedPresets,
			onClose: onClose,
			startPoint: startPoint
		};

		VET_loader.load(options);
	}

	window.VET_WikiaEditor = VET_WikiaEditor;

})(this, jQuery);