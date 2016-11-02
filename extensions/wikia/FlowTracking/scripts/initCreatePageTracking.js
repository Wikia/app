require([
	'wikia.flowTracking',
	'ext.wikia.flowTracking.createPageTracking',
	'wikia.querystring',
	'mw',
	'jquery',
	'wikia.window'
], function (flowTracking, flowTrackingCreatePage, QueryString, mw, $, window) {
	var redLinkFlow = mw.config.get('wgNamespaceNumber') === -1 ?
			window.wgFlowTrackingFlows.CREATE_PAGE_SPECIAL_REDLINK :
			window.wgFlowTrackingFlows.CREATE_PAGE_ARTICLE_REDLINK,
		createButtonFlow = window.wgFlowTrackingFlows.CREATE_PAGE_CREATE_BUTTON,
		createboxFlow = window.wgFlowTrackingFlows.CREATE_PAGE_CREATE_BOX,
		inputBoxFlow = window.wgFlowTrackingFlows.CREATE_PAGE_INPUT_BOX;

	function init() {
		var $wikiaArticle = $('#WikiaArticle');

		// Create Page flow tracking, adding flow param in redlinks href.
		// This parameter is added here to avoid reparsing all articles.
		$wikiaArticle.find('a.new').each(function (index, redlink) {
			var qs = QueryString(redlink.href);

			qs.setVal('flow', redLinkFlow);
			redlink.href = qs.toString();
		});

		$wikiaArticle.on('mousedown', 'a.new', function (e) {
			// Don't track on mouse right click
			if (e.which === 3) {
				return;
			}

			flowTracking.beginFlow(redLinkFlow, {});
		});

		$('form.createboxForm .createboxButton').click(function () {
			flowTracking.beginFlow(createboxFlow, {});
		});

		$('form.createbox').submit(function () {
			var flowInput = document.createElement('input');

			flowInput.setAttribute('type', 'hidden');
			flowInput.setAttribute('name', 'flow');
			flowInput.setAttribute('value', inputBoxFlow);
			this.appendChild(flowInput);

			flowTracking.beginFlow(inputBoxFlow, {});
		});

		$('#ca-edit').on('mousedown', function () {
			if (isNewArticle() && isMainNamespace()) {
				flowTracking.beginFlow(createButtonFlow, {});
			}
		});

		$('#ca-ve-edit').click(function () {
			if (isNewArticle() && isMainNamespace()) {
				var qs = new QueryString();

				flowTracking.beginFlow(createButtonFlow, {});
				qs.removeVal('tracked');
				window.history.replaceState({}, '', qs.toString());
			}
		});
	}

	function initVEHooks() {
		mw.hook('ve.activationComplete').add(function () {
			flowTrackingCreatePage.trackOnEditPageLoad('visualeditor');
		});

		mw.hook('ve.deactivationComplete').add(function () {
			var qs = new QueryString(),
				flow = qs.getVal('flow');

			if (flow) {
				qs.removeVal('flow');
				qs.removeVal('tracked');
				window.history.replaceState({}, '', qs.toString())
			}
		});

		mw.hook('ve.afterVEInit').add(function (veEditUri) {
			if (!mw.config.get('wgArticleId')) {
				veEditUri.extend({ flow: createButtonFlow });
			}
		});
	}

	function isNewArticle() {
		return mw.config.get('wgArticleId') === 0;
	}

	function isMainNamespace() {
		return mw.config.get('wgNamespaceNumber') === 0;
	}

	$(function () {
		init();
		initVEHooks();
	});
});
