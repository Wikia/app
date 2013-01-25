/* VET_loader
 *
 * Final callback should include VET_loader.modal.closeModal() in success case.
 * Sample input json for options:
 *	{
 *		callbackAfterSelect: function() {}, // callback after video is selected (first screen).  If defined, second screen will not show.
 *		callbackAfterEmbed: function() {}, // callback after video formating (second screen).
 *		callbackAfterLoaded: function() {}, // callback after VET assets are loaded
 *		embedPresets: {
 *			align: "right"
 *			caption: ""
 *			thumb: true
 *			width: 335
 *		},
 *		startPoint: 1 | 2, // display first or second screen when VET opens
 *		searchOrder: "newest" // Used in MarketingToolbox
 *	}
 */

(function(window, $) {

	if( window.VET_loader ) {
		return;
	}
	
	var resourcesLoaded = false,
		templateHtml = '',
		VET_loader = {};

	window.VET_load_in_editor = function(event) {
		var mode = 'create';
		var embedPresets = {};
		var exists = false;
		
		// Start on first or second screen of VET
		var startPoint = 1;
		
		var element = false;
		if (event && event.data && event.data.element) {
			element = event.data.element;
		}
		
		var triggeredFromRTE = event && event.type === 'rte';
		if (triggeredFromRTE) {
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
		
		var callback = null;
		
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
					if(element.hasClass('media-placeholder')) {
						wikitext = embedData.wikitext;
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
					}
					if (element) {
						// update existing video
						RTE.mediaEditor.update(element, wikitext, embedData);
						VET_loader.modal.closeModal();
					}
					else {
						// add new video
						RTE.mediaEditor.addVideo(wikitext, embedData);
					}
				}
				
			};
		}
		
		var options = {
			embedPresets: embedPresets,
			callbackAfterEmbed: callback,
			startPoint: startPoint
		};
		
		VET_loader.load(options);
	}
	
	VET_loader.load = function(options) {
		
		var deferredList = [];
		
		if(!resourcesLoaded) {
			var templateDeferred = $.Deferred(),
				deferredMessages = $.Deferred();
				
			// Get modal template HTML
			$.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'modal',
				type: 'get',
				format: 'html',
				callback: function(html) {
					templateHtml = html;
					templateDeferred.resolve();
				}
			});
			deferredList.push(templateDeferred);

			// Get VET i18n messages 
			$.getJSON( 
				window.wgScriptPath + "index.php?action=ajax&rs=VET&method=getMsgVars", 
				function(VETMessages) {
					for (var v in VETMessages) {
						wgMessages[v] = VETMessages[v];
					}
					deferredMessages.resolve();
				}
			);
			deferredList.push(deferredMessages);

			// Get JS and CSS
			var resourcePromise = $.getResources([
				$.loadYUI,
				window.wgExtensionsPath + '/wikia/WikiaStyleGuide/js/Dropdown.js',
				window.wgExtensionsPath + '/wikia/VideoEmbedTool/js/VET.js', 
				$.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss'),
				$.getSassCommonURL('/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss')
			]);
			deferredList.push(resourcePromise);
		}
		
		$.when.apply(this, deferredList).done(function() {
			if($.isFunction(options.callbackAfterLoaded)) {
				options.callbackAfterLoaded();
				delete options.callbackAfterLoaded;
			}
			
			VET_loader.modal = $(templateHtml).makeModal({width:1000});
			VET_show(options);
			//VETExtended.init(); // TODO on 2013: find the place where edit mode needs to call VETExtended.init() and abstract it, you shouldn't need this when startscreen == 2
			resourcesLoaded = true;
		});			
	};

	$.fn.addVideoButton = function(options) {
		$.preloadThrobber();

		return this.each(function() {
			var $this = $(this);
			
			$this.on('click.VETLoader', function(e) {
				e.preventDefault();
				
				// Provide immediate feedback once button is clicked
				$this.startThrobbing();
				
				options.callbackAfterLoaded = function() {
					$this.stopThrobbing();				
				}
				
				VET_loader.load(options);
			});
		});
	
	};
	
	window.VET_loader = VET_loader;
	
})(window, jQuery);