(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.flowtracking = $.createClass(WE.plugin,{

		initEditor: function( editor ) {
			require(['wikia.flowTracking', 'wikia.querystring', 'mw'], function(flowTrack, QueryString, mw) {

				// Track only creating articles from namespace 0
				// IMPORTANT: on Special:CreatePage even after providing article title the namespace is set to -1
				if (mw.config.get('wgNamespaceNumber') === 0 && mw.config.get('wgArticleId') === 0) {
					var qs = new QueryString(window.location.href);

					// 'flow' is the parameter passed in the url if user has started a flow already
					var flowParam = qs.getVal('flow', false);

					if (!flowParam && !document.referrer) {
						flowTrack.beginFlow('direct-url');
					} else {
						//TODO: track middle step for other flows
						console.log('flow='+flowParam);
					}
				}

			})
		}
	});
})(this,jQuery);
