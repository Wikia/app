require(['jquery', 'curatedContentTool.modal'], function ($, curatedContentToolModal) {
		'use strict';
		$('#CuratedContentTool').click(function () {
			var iframe = '<iframe data-url="/main/edit?useskin=mercury" id="CuratedContentToolIframe"' +
					'class="curated-content-tool" name="curated-content-tool" ></iframe>',
				title = 'Mobile Main Page';

			curatedContentToolModal.open(title, iframe);
		});
	}
);
