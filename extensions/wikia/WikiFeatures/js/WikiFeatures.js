var WikiFeatures = {
	lockedFeatures: {},
	init: function() {
		WikiFeatures.feedbackDialogPrototype = $('.FeedbackDialog');
		WikiFeatures.deactivateDialogPrototype = $('.DeactivateDialog');
		WikiFeatures.sliders = $('#WikiFeatures .slider');

		if(!Modernizr.csstransforms) {
			$('.representation').removeClass('promotion');
		}

		WikiFeatures.sliders.click(function(e) {
			var feature = $(this).closest('.feature');
			var featureName = feature.data('name');

			if(!WikiFeatures.lockedFeatures[featureName]) {
				var el = $(this);
				var isEnabled = el.hasClass('on');
				if(isEnabled) {
					var featureHeading = feature.find('h3').contents().eq(0).text().trim();
					var modalClone = WikiFeatures.deactivateDialogPrototype.clone();
					var modalHeading = modalClone.find('h1');
					modalHeading.text(modalHeading.text().replace(/\$1/g, featureHeading));
					var modal = modalClone.makeModal({width:670});
					modal.find('.cancel, .confirm').click(function() {
						if($(this).hasClass('confirm')) {
							WikiFeatures.toggleFeature(featureName, false);
							el.toggleClass('on');
						}
						modal.closeModal();
					});
				} else {
					WikiFeatures.toggleFeature(featureName, true);
					el.toggleClass('on');
				}
			}

		});
		$('#WikiFeatures .feedback').click(function(e) {
			e.preventDefault();
			var feature = $(this).closest('.feature');
			var featureName = feature.data('name');
			var image = feature.find('.representation img');
			var heading = feature.find('.details h3');
			var modalClone = WikiFeatures.feedbackDialogPrototype.clone();
			modalClone.find('.feature-highlight h2').text(heading.text());
			modalClone.find('.feature-highlight img').attr('src', image.attr('src'));
			var modal = modalClone.makeModal({width:670});

			var commentLabel = modal.find('.comment-group label');
			var comment = modal.find('textarea[name=comment]');
			var commentCounter = modal.find('.comment-character-count');
			var submitButton = modal.find('input[type=submit]');
			var statusMsg = modal.find('.status-msg');
			var msgHandle = false;

			modal.find('form').submit(function(e) {
				e.preventDefault();
				submitButton.attr('disabled', 'true');
				$.post(wgScriptPath + '/wikia.php', {
					controller: 'WikiFeaturesSpecial',
					method: 'saveFeedback',
					format: 'json',
					feature: featureName,
					category: modal.find('select[name=feedback] option:selected').val(),
					message: comment.val()
				}, function(res) {
					if(res['result'] == 'ok') {
						clearTimeout(msgHandle);
						statusMsg.removeClass('invalid').text(res['msg']).show();
						setTimeout(function() {
							modal.closeModal();
						}, 3000);
					} else if (res['result'] == 'error') {
						submitButton.removeAttr('disabled');
						statusMsg.addClass('invalid').text(res['error']).show();
						msgHandle = setTimeout(function() {
							statusMsg.fadeOut(1000);
						}, 4000);
					} else {
						// TODO: show error message
						GlobalNotification.show('Something is wrong', 'error');
					}
				});
			});

			comment.bind('keypress keydown keyup paste cut', function(e) {
				setTimeout(function() {
					var chars = comment.val().length;
					commentCounter.text(chars);
					if( chars > 1000 ) {
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
		WikiFeatures.lockedFeatures[featureName] = true;
		$.post(wgScriptPath + '/wikia.php', {
			controller: 'WikiFeaturesSpecial',
			method: 'toggleFeature',
			format: 'json',
			feature: featureName,
			enabled: enable
		}, function(res) {
			if(res['result'] == 'ok') {
				WikiFeatures.lockedFeatures[featureName] = false;
			} else {
				// TODO: show error message
				GlobalNotification.show(res['error'], 'error');
			}
		});
	}
};

$(function() {
	WikiFeatures.init();
});
