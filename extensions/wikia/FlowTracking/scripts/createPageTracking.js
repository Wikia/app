define(
	'ext.wikia.flowTracking.createPageTracking',
	['wikia.flowTracking', 'wikia.querystring', 'mw', 'wikia.document', 'wikia.window'],
	function (flowTrack, QueryString, mw, document, window) {
		'use strict';

		var namespaceId = mw.config.get('wgNamespaceNumber'),
			articleId = mw.config.get('wgArticleId'),
			title = mw.config.get('wgTitle');

		function trackOnEditPageLoad(editor) {
			var qs = new QueryString(window.location),
			// 'flow' is the parameter passed in the url if user has started a flow already
				flowParam = qs.getVal('flow', false),
				tracked = qs.getVal('tracked', false);

			if (tracked || !isNewArticle() || !isMainNamespace()) {
				return;
			}

			if (flowParam || document.referrer) {
				flowTrack.trackFlowStep(flowParam, {editor: editor});
			} else {
				flowTrack.beginFlow(window.wgFlowTrackingFlows.CREATE_PAGE_DIRECT_URL, {editor: editor});
				qs.setVal('flow', window.wgFlowTrackingFlows.CREATE_PAGE_DIRECT_URL);
			}

			setTrackedQueryParam(qs);
		}

		function trackOnSpecialCreatePageLoad(editor, title) {
			var qs = new QueryString(window.location),
			// 'flow' is the parameter passed in the url if user has started a flow already
				flowParam = qs.getVal('flow', false),
				tracked = qs.getVal('tracked', false);

			if (tracked || !isAllowedSpecialPage() || !isTitleInMainNamespace(title)) {
				return;
			}

			if (flowParam) {
				flowTrack.trackFlowStep(flowParam, {editor: editor});
			} else {
				flowTrack.beginFlow(window.wgFlowTrackingFlows.CREATE_PAGE_SPECIAL_CREATE_PAGE, {editor: editor});
				qs.setVal('flow', window.wgFlowTrackingFlows.CREATE_PAGE_SPECIAL_CREATE_PAGE);
			}

			setTrackedQueryParam(qs);
		}

		/**
		 * Set 'tracked' query param to prevent tracking the same event when page is reloaded
		 */
		function setTrackedQueryParam(qs) {
			qs.setVal('tracked', 'true');
			window.history.replaceState({}, '', qs.toString());
		}

		function isNewArticle() {
			return articleId === 0;
		}

		function isAllowedSpecialPage() {
			return namespaceId === -1 && title === 'CreatePage';
		}

		function isMainNamespace() {
			return namespaceId === 0;
		}

		function isTitleInMainNamespace(title) {
			var namespace;

			title = title || '';

			if (title.indexOf(':')) {
				namespace = title.split(':')[0].toLowerCase();
				if (window.wgNamespaceIds[namespace]) {
					return false;
				}
			}

			return true;
		}

		return {
			trackOnEditPageLoad: trackOnEditPageLoad,
			trackOnSpecialCreatePageLoad: trackOnSpecialCreatePageLoad
		}
	});
