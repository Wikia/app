define(
	'wikia.flowTracking.createPage',
	['wikia.flowTracking', 'wikia.querystring', 'mw', 'wikia.document'],
	function (flowTrack, QueryString, mw, document) {
		var namespaceId = mw.config.get('wgNamespaceNumber'),
			articleId = mw.config.get('wgArticleId');

		function trackOnEditPageLoad(editor) {
			var qs = new QueryString(),
				// 'flow' is the parameter passed in the url if user has started a flow already
				flowParam = qs.getVal('flow', false);

			// Track only creating articles (wgArticleId=0) from namespace 0 (Main)
			// IMPORTANT: on Special:CreatePage even after providing article title the namespace is set to -1 (Special Page)
			if (namespaceId === 0 && articleId === 0) {
				if (flowParam || document.referrer) {
					flowTrack.trackFlowStep(flowParam, {editor: editor});
				} else {
					flowTrack.beginFlow(flowTrack.flows.CREATE_PAGE_DIRECT_URL, {editor: editor});
				}
			}

			// For Special:CreatePage
			if (namespaceId === -1 && articleId === 0) {
				if (flowParam || document.referrer) {
					flowTrack.trackFlowStep(flowParam, {editor: editor});
				} else {
					// TODO: direct-url to Special:CreatePage (WW-351)
				}
			}
		}

		return {
			trackOnEditPageLoad: trackOnEditPageLoad
		}
	});
