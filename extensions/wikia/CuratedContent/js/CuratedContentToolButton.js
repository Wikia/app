(function () {
		'use strict';

	var $ = require('jquery'),
		curatedContentToolModal = require('curatedContentTool.modal'),
		msg = require('JSMessages');

	$('#CuratedContentTool').click(function () {
		var iframe = '<iframe data-url="/main/edit?useskin=wikiamobile" id="CuratedContentToolIframe"' +
				'class="curated-content-tool" name="curated-content-tool" ></iframe>',
			title = msg('wikiacuratedcontent-modal-title');

		curatedContentToolModal.open(title, iframe);
	});
})();
