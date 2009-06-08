var wikiaProblemReportsDialog = false;

// initialize "report a problem" callbacks
// perform lazy loading of JS/CSS when user clicks "report a problem"
$(function() {
	$('#fe_report_link, #ca-report-problem').click(function() {
		if (wikiaProblemReportsDialog == false) {
			$().log('ProblemReports: loading CSS & JS');

			// load CSS
			importStylesheetURI(wgExtensionsPath + '/wikia/ProblemReports/css/ProblemReports.css?' + wgStyleVersion);

			// load JS
			$.getScript(wgExtensionsPath + '/wikia/ProblemReports/js/ProblemReports.js?' + wgStyleVersion, function() {
				$().log('ProblemReports: JS loaded');
				wikiaProblemReportsDialog = new ProblemReportsDialog();
				wikiaProblemReportsDialog.open();
			});
		}
		else {
			// already loaded, show pop-up
			wikiaProblemReportsDialog.open();
		}
	});
});
