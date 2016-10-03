CKEDITOR.plugins.add('rte-flowtracking', {

	init : function( editor ) {
		GlobalTriggers.bind('rteinit', function() {
			require(['wikia.flowTracking'], function(flowTrack) {
				flowTrack.beginFlow('direct-url');
			})
		});
	}

});