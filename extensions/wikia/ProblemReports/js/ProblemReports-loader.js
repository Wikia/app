var wikiaProblemReportsDialog = false;

// initialize "report a problem" callbacks
// perform lazy loading of JS when user clicks "report a problem"
YAHOO.util.Event.onDOMReady( function () {

	var links = ["fe_report_link", "ca-report-problem"];

	YAHOO.util.Event.addListener(links, "click", function() {
		if (wikiaProblemReportsDialog == false) {
			YAHOO.log('ProblemReports: loading JS');
			YAHOO.util.Get.script(wgExtensionsPath + '/wikia/ProblemReports/js/ProblemReports.js?' + wgStyleVersion, {
				onSuccess: function() {
					YAHOO.log('ProblemReports: JS loaded');
					wikiaProblemReportsDialog = new YAHOO.wikia.ProblemReportsDialog();
					wikiaProblemReportsDialog.fire();
				}
			});
			YAHOO.util.Get.css(wgExtensionsPath + '/wikia/ProblemReports/css/ProblemReports.css?' + wgStyleVersion, {
				onSuccess: function() {
					YAHOO.log('ProblemReports: CSS loaded');
				}
			});
		}
		else {
			wikiaProblemReportsDialog.fire();
		}
	});
});
