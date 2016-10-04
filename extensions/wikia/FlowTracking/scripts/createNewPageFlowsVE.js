require(['wikia.flowTracking.createPage', 'mw', 'jquery'], function (flowTrackingCreatePage, mw, $) {
	function init() {
		mw.hook('ve.activationComplete').add(function () {
			flowTrackingCreatePage.trackOnEditPageLoad('ve');
		});
	}

	$(init);
});
