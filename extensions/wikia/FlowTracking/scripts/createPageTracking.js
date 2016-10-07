define(
	'ext.wikia.flowTracking.createPageTracking',
	['wikia.flowTracking', 'wikia.querystring', 'mw', 'wikia.document', 'wikia.window'],
	function (flowTrack, QueryString, mw, document, window) {
		'use strict';

		var namespaceId = mw.config.get('wgNamespaceNumber'),
			articleId = mw.config.get('wgArticleId'),
			title = mw.config.get('wgTitle');

		function trackOnEditPageLoad(editor) {
			var qs = new QueryString(),
				// 'flow' is the parameter passed in the url if user has started a flow already
				flowParam = qs.getVal('flow', false),
				tracked = qs.getVal('tracked', false);

			// Do not track if the step was tracked already or article exists
			if (tracked || !(isNewArticle() || isAllowedSpecialPage())) {
				return;
			}

			if (flowParam || document.referrer) {
				flowTrack.trackFlowStep(flowParam, {editor: editor});
			} else if (namespaceId === 0) {
				flowTrack.beginFlow(window.wgFlowTrackingFlows.CREATE_PAGE_DIRECT_URL, {editor: editor});
				qs.setVal('flow', window.wgFlowTrackingFlows.CREATE_PAGE_DIRECT_URL);
			} else if (namespaceId === -1) {
				// TODO: direct-url to Special:CreatePage (WW-351)
			}

			// set 'tracked' query param to prevent tracking the same event when page is reloaded
			qs.setVal('tracked', 'true');
			window.history.replaceState({}, '', qs.toString());
		}

		function isNewArticle() {
			return articleId === 0 && namespaceId === 0;
		}

		function isAllowedSpecialPage() {
			return namespaceId === -1 && title === 'CreatePage';
		}

		function extendUri(veEditUri) {
			return veEditUri.extend( { flow: window.wgFlowTrackingFlows.CREATE_PAGE_CREATE_BUTTON } );
		}

		return {
			extendUri: extendUri,
			trackOnEditPageLoad: trackOnEditPageLoad
		}
	});
