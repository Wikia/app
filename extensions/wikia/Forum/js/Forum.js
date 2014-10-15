(function (window, $) {
	'use strict';
	var bucky = window.Bucky('Forum'),
		showPoliciesModal = function () {
			bucky.timer.start('showPoliciesModal');
			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(function (uiModal) {
					var buttons = [{
						vars: {
							value: $.msg('back'),
							data: [{
								key: 'event',
								value: 'close'
							}]
						}
						}],
						modalConfig = {
						vars: {
							id: 'ForumPoliciesModal',
							size: 'medium',
							content: '<div class="ForumPolicies"><div class="WikiaArticle"></div></div>',
							title: $.msg('forum-specialpage-policies'),
							buttons: buttons
						}
					};

					if (window.wgCanEditPolicies) {
						var vars = {
							value: $.msg('forum-specialpage-policies-edit'),
							data: [{
								key: 'event',
								value: 'edit'
							}]
						};
						modalConfig.vars.buttons.unshift({
							vars: vars
						});
					}

					uiModal.createComponent(modalConfig, function (policiesModal) {

						policiesModal.bind('edit', function (event) {
							event.preventDefault();
							window.location = window.wgPoliciesEditURL;
						});

						policiesModal.show();
						policiesModal.deactivate();
						$.nirvana.sendRequest({
							controller: 'ForumExternalController',
							type: 'GET',
							method: 'policies',
							format: 'json',
							data: {
								'rev': window.wgPoliciesRev
							},
							callback: function (data) {
								policiesModal.activate();
								policiesModal.$content.find('.ForumPolicies .WikiaArticle').html(data.body);
								bucky.timer.stop('showPoliciesModal');
							}
						});
					});
				});
			});
		return false;
	};

	$(function () {
		$('.policies-link').click(showPoliciesModal);
	});

	// Just the namespace, for now.
	window.Forum = {};

})(window, jQuery);
