(function(window, $) {

	var resourcesLoaded = false;

	$.fn.addVideoButton = function(options) {
	
		return this.each(function() {
			var $el = $(this);
			$el.on('click.VideoUploadLoader', function(e) {
				e.preventDefault();
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
			});
		});
	
	};
	
})(window, jQuery);