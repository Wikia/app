require(['jquery', 'curatedContentTool.modal'], function ($, curatedContentToolModal) {
		'use strict';
		$('#CuratedContentTool').click(function () {
			//@TODO CONCF-1077 it should be useskin=mercury not useskin=wikiamobile
			var iframe = '<iframe data-url="/main/edit?useskin=mercury" id="CuratedContentToolIframe"' +
					'class="curated-content-tool" name="curated-content-tool" ></iframe>',
				title = 'Mobile Main Page';

			curatedContentToolModal.open(title, iframe);
		});
	}
);
