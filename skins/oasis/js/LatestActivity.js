$(window).load(function() {
    LatestActivity.init();
});

var LatestActivity = {
		init: function() {
			LatestActivity.lazyLoadContent();
	},
	
	lazyLoadContent: function() {
		$.post(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=LatestActivity&actionName=Index&outputType=html',
			function(data) {
				// IE would lose styling otherwise
				if ($.browser.msie) {
					$("section.WikiaActivityModule").empty().append(data);
				}
				else {
					$('section.WikiaActivityModule').replaceWith(data);
				}
			
			}
		);
	}
}