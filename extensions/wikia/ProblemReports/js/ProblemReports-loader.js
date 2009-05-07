var wikiaProblemReportsDialog = false;

// initialize "report a problem" callbacks
// perform lazy loading of JS/CSS when user clicks "report a problem"
$(function() {
	$('#fe_report_link, #ca-report-problem').click(function() {
		if (wikiaProblemReportsDialog == false) {
			// load JS/CSS
			$().log('ProblemReports: loading JS');
			$.getScript(wgExtensionsPath + '/wikia/ProblemReports/js/ProblemReports.js?' + wgStyleVersion, function() {
				$().log('ProblemReports: JS loaded');
				wikiaProblemReportsDialog = new ProblemReportsDialog();
				wikiaProblemReportsDialog.fire();
			});
			$.get(wgExtensionsPath + '/wikia/ProblemReports/css/ProblemReports.css?' + wgStyleVersion, function() {
				$().log('ProblemReports: CSS loaded');
			});
		}
		else {
			// already loaded, show pop-up
			wikiaProblemReportsDialog.fire();
		}
	});
});
