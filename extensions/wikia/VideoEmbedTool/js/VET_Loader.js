(function(window, $) {

	var resourcesLoaded = false;
	
	var VET_loader = {};
	
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
		}
	}
	*/
	
	VET_loader.load = function(options) {
		$.nirvana.sendRequest({
			controller: 'VideoEmbedToolController',
			method: 'modal',
			type: 'get',
			format: 'html',
			callback: function(html) {
				$(html).makeModal({width:1000});
				if(!resourcesLoaded) {
					var resourcePromise = $.getResources([
						$.loadYUI,
						window.wgExtensionsPath + '/wikia/WikiaStyleGuide/js/Dropdown.js',
						window.wgExtensionsPath + '/wikia/VideoEmbedTool/js/VET.js', 
						$.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss')
					]);
					
					$.when(resourcePromise).then(function() {
						VETExtended.init();
						resourcesLoaded = true;
					});
				} else {
					VETExtended.init();
				}
				
			}
		});
	};

	$.fn.addVideoButton = function(options) {
	
		return this.each(function() {
			var $el = $(this);
			$el.on('click.VETLoader', function(e) {
				e.preventDefault();
				VET_loader.load(options);
			});
		});
	
	};
	
	window.VET_loader = VET_loader;
	
})(window, jQuery);