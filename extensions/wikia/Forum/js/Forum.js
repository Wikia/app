(function(window, $) {
		var showPoliciesModal = function() {
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
			$('.ForumPolicies').stopThrobbing();
			
			return false;
		};
		
	$(function() { 
		$('.policies-link').click(showPoliciesModal);
	});
// Just the namespace, for now.
window.Forum = {};

})(window, jQuery);