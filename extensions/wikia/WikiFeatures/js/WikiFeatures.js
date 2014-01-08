( function( window, $ ) {
	'use strict';

	var lockedFeatures = {};

	function init() {
		var $sliders = $( '#WikiFeatures .slider' ),
			$feedbackDialogPrototype = $( '.FeedbackDialog' );

		if( !window.Modernizr.csstransforms ) {
			$( '.representation' ).removeClass( 'promotion' );
		}

		$sliders.click( function( event ) {
			var $el = $( this ),
				feature = $el.closest( '.feature' ),
				featureName = feature.data( 'name' ),
				isEnabled;

			event.preventDefault();

			if( !lockedFeatures[featureName] ) {
				isEnabled = $el.hasClass( 'on' );

				if( isEnabled ) {
					require( ['wikia.ui.factory'], function( uiFactory ) {
						uiFactory.init( ['modal'] ).then( function( uiModal ) {
							var modalTitle = $.msg( 'wikifeatures-deactivate-heading', feature.data( 'title' ) ),
								deactivateModalConfig = {
								vars: {
									id: 'DeactivateDialog',
									size: 'small',
									title: modalTitle,
									classes: ['WikiaArticle'],
									content: [
										'<p>',
										$.msg( 'wikifeatures-deactivate-description' ),
										'</p><p>',
										$.msg( 'wikifeatures-deactivate-notification' ),
										'</p>'
									].join( '' ),
									buttons: [
										{
											vars: {
												value: $.msg( 'wikifeatures-deactivate-confirm-button' ),
												classes: ['normal', 'primary'],
												data: [
													{
														key: 'event',
														value: 'confirm'
													}
												]
											}
										},
										{
											vars: {
												value: $.msg( 'wikifeatures-deactivate-cancel-button' ),
												data: [
													{
														key: 'event',
														value: 'close'
													}
												]
											}
										}
									]
								}
							};

							uiModal.createComponent( deactivateModalConfig, function( deactivateModal ) {
								deactivateModal.bind( 'confirm', function( event ) {
									event.preventDefault();
									toggleFeature( featureName, false );
									$el.toggleClass( 'on' );
									deactivateModal.trigger( 'close' );
								} );
								deactivateModal.show();
							} );
						} );
					} );
				} else {
					toggleFeature( featureName, true );
					$el.toggleClass( 'on' );
				}
			}
		} );

		$('#WikiFeatures .feedback').click(function(e) {
			e.preventDefault();
			var feature = $(this).closest('.feature');
			var featureName = feature.data('name');
			var image = feature.find('.representation img');
			var heading = feature.find('.details h3');
			var modalClone = $feedbackDialogPrototype.clone();
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
						window.GlobalNotification.show('Something is wrong', 'error');
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
	}

	function toggleFeature( featureName, enable ) {
		lockedFeatures[featureName] = true;
		$.post( window.wgScriptPath + '/wikia.php', {
			controller: 'WikiFeaturesSpecial',
			method: 'toggleFeature',
			format: 'json',
			feature: featureName,
			enabled: enable
		}, function( response ) {
			if( response.result === 'ok' ) {
				lockedFeatures[featureName] = false;
			} else {
				window.GlobalNotification.show( response.error, 'error' );
			}
		} );
	}

	$( function() {
		init();
	} );

} )( window, jQuery );

