/* global GlobalNotification, Modernizr */

var WikiFeatures = {
	lockedFeatures: {},
	init: function() {
		'use strict';

		WikiFeatures.feedbackDialogPrototype = $( '.FeedbackDialog' );
		WikiFeatures.sliders = $( '#WikiFeatures .slider' );
		
		if( !Modernizr.csstransforms ) {
			$( '.representation' ).removeClass( 'promotion' );
		}
		
		WikiFeatures.sliders.click( function( ) {
			var el = $( this ),
				feature = el.closest( '.feature' ),
				featureName = feature.data( 'name' ),
				isEnabled,
				modalTitle;
			
			if( !WikiFeatures.lockedFeatures[ featureName ] ) {
				isEnabled = el.hasClass( 'on' );

				if( isEnabled ) {
					modalTitle = $.msg( 'wikifeatures-deactivate-heading', feature.find( 'h3' ).text().trim() );

					require( [ 'wikia.ui.factory' ], function( uiFactory ) {
						uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
							var deactivateModalConfig = {
								vars: {
									id: 'DeactivateDialog',
									size: 'small',
									title: modalTitle,
									content: [
										'<p>',
										$.msg( 'wikifeatures-deactivate-description' ),
										'</p><p>',
										$.msg( 'wikifeatures-deactivate-notification' ),
										'</p>'
									].join(''),
									buttons: [
										{
											vars: {
												value: $.msg( 'wikifeatures-deactivate-confirm-button' ),
												classes: [ 'normal', 'primary' ],
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

							uiModal.createComponent( deactivateModalConfig, function ( deactivateModal ) {
								deactivateModal.bind( 'confirm', function ( event ) {
									event.preventDefault();
									WikiFeatures.toggleFeature( featureName, false );
									el.toggleClass( 'on' );
									deactivateModal.trigger( 'close' );
								});
								deactivateModal.show();
							});
						});
					});
				} else {
					WikiFeatures.toggleFeature( featureName, true );
					el.toggleClass( 'on' );
				}
			}
		});

		$('body' ).on('input propertychange', '#feedbackDialogModal [name=comment]', function( ) {
			var $this = $(this),
				chars = this.value.length,
				elemParent = $this.closest('#feedbackDialogModal'),
				$counter = elemParent.find('.comment-character-count' ),
				$label = elemParent.find('.comment-group label' );

			$counter.html(chars + ' / 1000');

			// Force re-paint
			$counter.css('display', 'none').height();
			$counter.css('display', 'block');

			if( chars > 1000 ) {
				$this.addClass('invalid');
				$label.addClass('invalid');
			} else {
				$this.removeClass('invalid');
				$label.removeClass('invalid');
			}
		});

		$('#WikiFeatures .feedback').click(function( e ) {
			e.preventDefault();

			var feature = $(this).closest('.feature');

			$.nirvana.sendRequest( {
				type: 'get',
				format: 'json',
				controller: 'WikiFeaturesSpecial',
				method: 'getFeedbackModal',
				data: {
					featureName: feature.data('heading'),
					featureImageUrl: feature.find('.representation img').attr('src')
				},
				callback: function( data ) {
					WikiFeatures.openFeedbackModal( feature, data );
				}
			} );
		});
	},

	openFeedbackModal: function( featureElem, data ) {
		'use strict';

		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				var feedbackModalConfig = {
					vars: {
						id: 'feedbackDialogModal',
						size: 'medium',
						title: data.title,
						content: data.html,
						buttons: [
							{
								vars: {
									value: data.labelSubmit,
									classes: [ 'normal', 'primary' ],
									data: [
										{
											key: 'event',
											value: 'submit'
										}
									]
								}
							}
						]
					}
				};

				uiModal.createComponent( feedbackModalConfig, function ( feedbackModal ) {
					WikiFeatures.feedbackModal = feedbackModal;

					var modal = feedbackModal.$element,
						//commentLabel = modal.find('.comment-group label' ),
						comment = modal.find('textarea[name=comment]' ),
						//commentCounter = modal.find('.comment-character-count' ),
						submitButton = modal.find('[data-event=submit]' ),
						statusMsg = modal.find('.status-msg'),
						msgHandle = false;

//					comment.bind('keypress keydown keyup paste cut', function() {
//						setTimeout(function() {
//							var chars = comment.val().length,
//								n;
//							commentCounter.html(chars + ' / 1000');
//
////							n = document.createTextNode(' ');
////							commentCounter.appendChild(n);
////							(function(){ n.parentNode.removeChild(n); }).defer();
//
//							commentCounter.style.display = 'none';
//							n = commentCounter.offsetHeight;
//							commentCounter.style.display = 'block';
//
//							if( chars > 1000 ) {
//								comment.addClass('invalid');
//								commentLabel.addClass('invalid');
//							} else {
//								comment.removeClass('invalid');
//								commentLabel.removeClass('invalid');
//							}
//						}, 50);
//					});

					feedbackModal.bind( 'submit', function ( event ) {
						event.preventDefault();
						submitButton.attr('disabled', 'true');
						$.post(window.wgScriptPath + '/wikia.php', {
							controller: 'WikiFeaturesSpecial',
							method: 'saveFeedback',
							format: 'json',
							feature: featureElem.data('name'),
							category: modal.find('select[name=feedback] option:selected').val(),
							message: comment.val()
						}, function(res) {
							if(res.result === 'ok') {
								clearTimeout(msgHandle);
								statusMsg.removeClass('invalid').text(res.msg).show();
								setTimeout(function() {
									feedbackModal.trigger('close');
								}, 3000);
							} else if (res.result === 'error') {
								submitButton.removeAttr('disabled');
								statusMsg.addClass('invalid').text(res.error).show();
								msgHandle = setTimeout(function() {
									statusMsg.fadeOut(1000);
								}, 4000);
							} else {
								// TODO: show error message
								GlobalNotification.show('Something is wrong', 'error');
							}
						});
					});

					feedbackModal.show();
				});
			});
		});
	},

	toggleFeature: function(featureName, enable) {
		'use strict';

		WikiFeatures.lockedFeatures[featureName] = true;
		$.post(window.wgScriptPath + '/wikia.php', {
			controller: 'WikiFeaturesSpecial',
			method: 'toggleFeature',
			format: 'json',
			feature: featureName,
			enabled: enable
		}, function(res) {
			if(res.result === 'ok') {
				WikiFeatures.lockedFeatures[featureName] = false;
			} else {
				// TODO: show error message
				GlobalNotification.show(res.error, 'error');
			}
		});
	}
};

$(function() {
	'use strict';

	WikiFeatures.init();
});
