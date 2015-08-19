require(['jquery'], function ($) {
	$('#CuratedContentTool').click(function () {
		var iframe = '<iframe data-url="/main/edit?useskin=mercury" id="CuratedContentToolIframe" name="curated-content-tool" width="100%" height="500"></iframe>';

		require(['wikia.ui.factory'], function (uiFactory) {
			uiFactory.init(['modal']).then(function (uiModal) {
				var modalConfig = {
					vars: {
						id: 'CuratedContentToolModal',
						size: 'medium',
						title: 'Curated Content Tool',
						content: iframe
					}
				};

				uiModal.createComponent(modalConfig, function (mercuryModal) {
					mercuryModal.show();

					require(['curatedContentTool.pontoBridge'], function (pontoBridge) {
						pontoBridge.init(mercuryModal.$content.find('#CuratedContentToolIframe')[0]);
					});
				});
			});
		});
	});
});
