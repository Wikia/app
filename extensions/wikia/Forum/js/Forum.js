(function(window, $) {
		var showPoliciesModal = function() {
			require( [ 'wikia.ui.factory' ], function( uiFactory ) {
				uiFactory.init( [ 'button', 'modal' ] ).then( function( uiComponents ) {
					var button = uiComponents[0],
						uiModal = uiComponents[1],
						modalId = 'ForumPoliciesModal',
						policiesModal = uiModal.render( {
							type: 'default',
							vars: {
								id: modalId,
								size: 'medium',
								content: '<div class="ForumPolicies"><div class="WikiaArticle"></div></div>',
								title: $.msg('forum-specialpage-policies')
							}
						} );

					require( [ 'wikia.ui.modal' ], function( modal ) {
						policiesModal = modal.init( modalId, policiesModal );
						policiesModal.show();
						policiesModal.$element.find( '.ForumPolicies' ).startThrobbing();
						$.nirvana.sendRequest({
							controller: 'ForumExternalController',
							type: 'GET',
							method: 'policies',
							format: 'json',
							data: {
								'rev': window.wgPoliciesRev
							},
							callback: function(data) {
								policiesModal.$element.find( '.ForumPolicies' ).stopThrobbing();
								policiesModal.$element.find( '.ForumPolicies .WikiaArticle' ).html(data.body);
							}
						});
					} );
				} );
			} );
			return;
			var buttons = [];
			
			buttons.push({
				id: 'close',
				message:  $.msg('back'),
				handler: function() {
					modal.closeModal();
				}
			});
			
			if(wgCanEditPolicies) {
				buttons.push({
					id: 'edit',
					message:  $.msg('forum-specialpage-policies-edit'),
					handler: function() {
						window.location = wgPoliciesEditURL;
					}
				});		
			}
			
			var modal;
			var options = {
				buttons: buttons,
				width: 'auto',
				className: 'policies',
				callback: function() {
					$.nirvana.sendRequest({
						controller: 'ForumExternalController',
						type: 'GET',
						method: 'policies',
						format: 'json',
						data: {
							'rev': wgPoliciesRev
						},
						callback: function(data) {
							$('.ForumPolicies').stopThrobbing();
							$('.ForumPolicies .WikiaArticle').html(data.body);
						}
					});
				}
			};
			
			// use loading indicator before real content will be fetched	
			var content = $('<div class="ForumPolicies"><div class="WikiaArticle"></div></div>');
			content.find('.WikiaArticle').css('width', 800);
			var modal = $.showCustomModal($.msg('forum-specialpage-policies'), content, options);
			$('.ForumPolicies').startThrobbing();
			return false;
		};
		
	$(function() { 
		$('.policies-link').click(showPoliciesModal);
	});
// Just the namespace, for now.
window.Forum = {};

})(window, jQuery);
