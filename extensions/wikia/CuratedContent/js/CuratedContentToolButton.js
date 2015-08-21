require(['jquery', 'curatedContentTool.modal'], function ($, curatedContentToolModal) {
		$('#CuratedContentTool').click(function () {
			//@TODO CONCF-1077 it should be useskin=mercury not useskin=wikiamobile
			var iframe = '<iframe data-url="/main/edit?useskin=mercury" id="CuratedContentToolIframe" name="curated-content-tool" width="100%" height="500"></iframe>',
				title = 'Mobile Main Page';

			curatedContentToolModal.open(title, iframe);
		});
	}
);
