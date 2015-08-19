require(
	[
		'jquery'
	],
	function ($) {
		$('#CuratedContentTool').click(function () {
			var iframe = '<iframe data-url="/main/edit?useskin=mercury" id="CuratedContentToolIframe" name="curated-content-tool" width="100%" height="500"></iframe>',
				title = 'Mobile Main Page';

			require(['curatedContentTool.modal'], function (curatedContentToolModal) {
				curatedContentToolModal.open(title, iframe);
			});
		});
	}
);
