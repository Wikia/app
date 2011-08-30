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

			var commentLabel = modal.find('.comment-group label');
			var comment = modal.find('textarea[name=comment]');
			var commentCounter = modal.find('.comment-character-count');
			
			modal.find('form').submit(function(e) {
				e.preventDefault();
				ratingInput.val(rating);
				// post somewhere
				$().log('form submitted');
				modal.find('.error-msg').text('this is an error/debug message: ' + rating).show().delay(4000).fadeOut(1000);
			});
			
			comment.bind('keypress keydown keyup paste cut', function(e) {
				setTimeout(function() {
					var chars = comment.val().length;
					commentCounter.text(chars);
					if( chars >= 1000 ) {
						comment.addClass('invalid');
						commentLabel.addClass('invalid');
					} else {
						comment.removeClass('invalid');
						commentLabel.removeClass('invalid');
					}
				}, 50);
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
