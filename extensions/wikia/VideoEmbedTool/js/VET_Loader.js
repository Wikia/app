(function(window, $) {

	var resourcesLoaded = false,
		templateHtml = '',
		VET_loader = {};
	
	/* Sample input json for options
	{
		callbackAfterSelect: function() {},
		callbackAfterEmbed: function() {},
		embedPresets: {
			align: "right"
			caption: ""
			thumbnail: true
			thumb: true
			width: 335
		},
		startPoint: 1 | 2
	}
	*/
	
	VET_load_in_editor = function(event, mode) {
		var embedPresets = {};
		var exists = false;
		var element = false;
		var startPoint = 1;
		
		if (event && event.type === 'rte') {
			// get video from event data
			element = event.data.element;
			if (element) {
				// edit a video
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
				if (typeof window.VET_RTEVideo != 'undefined') {
					if (window.VET_RTEVideo && window.VET_RTEVideo.hasClass('media-placeholder')) {
						// replace "Add Video" placeholder
						RTE.mediaEditor.update(window.VET_RTEVideo, wikitag, embedData);
					}
					else {
						RTE.mediaEditor.addVideo(wikitag, embedData);
					}
				}

			};
		} else if (mode === 'edit') {

			callback = function (embedData) {
				// generate wikitext
				var wikitext = '[[' + embedData.href;
			
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
				if (typeof window.VET_RTEVideo != 'undefined') {
					if (window.VET_RTEVideo) {
						// update existing video
						RTE.mediaEditor.update(window.VET_RTEVideo, wikitext, embedData);
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
		debugger;
		
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
			VET_loader.modal = $(templateHtml).makeModal({width:1000});
			VET_show(options);
			resourcesLoaded = true;
		});			
	};

	$.fn.addVideoButton = function(options) {
	
		return this.each(function() {
			$(this).on('click.VETLoader', function(e) {
				e.preventDefault();
				VET_loader.load(options);
			});
		});
	
	};
	
	window.VET_loader = VET_loader;
	
})(window, jQuery);