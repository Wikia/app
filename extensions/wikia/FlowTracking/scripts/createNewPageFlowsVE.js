require([
	'wikia.flowTracking.createPage', 'wikia.querystring', 'mw', 'jquery', 'wikia.window'
], function (flowTrackingCreatePage, QueryString, mw, $, window) {
	function init() {
		mw.hook('ve.activationComplete').add(function () {
			flowTrackingCreatePage.trackOnEditPageLoad('visualeditor');
		});

		mw.hook('ve.deactivationComplete').add(function () {
			var qs = new QueryString(),
				flow = qs.getVal('flow');

			if (flow) {
				qs.removeVal('flow');
				window.history.replaceState({}, '', qs.toString())
			}
		});
	}

	$(init);
});
