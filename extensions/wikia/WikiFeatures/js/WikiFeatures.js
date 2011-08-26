var WikiFeatures = {
	lockedFeatures: {},
	init: function() {
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
