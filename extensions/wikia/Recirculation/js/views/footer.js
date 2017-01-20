define('ext.wikia.recirculation.views.footer', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, tracker, utils) {
	'use strict';

	function render(data) {

		return utils.prepareFooter()
			.then(function() {
				return utils.renderTemplate('client/footer.mustache', data)
			})
			.then(function($html) {
				$('#recirculation-footer-container').html($html);

				return $html;
			});
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'footer');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'footer'));
			});
		};
	}

	return function() {
		return {
			render: render,
			setupTracking: setupTracking
		};
	};
});
