var WikiFeatures = {
	lockedFeatures: {},
	init: function() {
		WikiFeatures.feedbackDialogPrototype = $('.FeedbackDialog');
		WikiFeatures.sliders = $('#WikiFeatures .slider');
		WikiFeatures.sliders.find('.button').click(function(e) {
			var feature = $(this).closest('.feature');
			var featureName = feature.data('name');
			
			if(!WikiFeatures.lockedFeatures[featureName]) {
				WikiFeatures.lockedFeatures[featureName] = true;				
				var el = $(this).closest('.slider');
				var isEnabled = el.hasClass('on');
				WikiFeatures.toggleFeature(featureName, !isEnabled);
				el.toggleClass('on');
			}
			
		});
		$('#WikiFeatures .feedback').click(function(e) {
			e.preventDefault();
			var feature = $(this).closest('.feature');
			var image = feature.find('.representation');
			var heading = feature.find('.details h3');
			var modal = WikiFeatures.feedbackDialogPrototype.clone();
			modal.find('.feature-highlight h2').text(heading.text());
			modal.find('.feature-highlight img').attr('src', image.attr('src'));
			modal.makeModal({width:670});
			modal.find('form').submit(function(e) {
				e.preventDefault();
				$().log('form submitted');
			});
		});
	},
	toggleFeature: function(featureName, enable) {
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'WikiFeaturesSpecial',
			method: 'toggleFeature',
			format: 'json',
			feature: featureName,
			enabled: enable
		}, function(res) {
			$().log(res);
			if(res['result'] == 'ok') {
				WikiFeatures.lockedFeatures[featureName] = false;
			} else {
				// TODO: show error message
				GlobalNotification.warn(res['error']);
			}
		});
	}
};

$(function() {
	WikiFeatures.init();
});
