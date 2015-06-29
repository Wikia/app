define(
	'ext.wikia.templateDraft.rightRailModule',
	[
		'jquery',
		'wikia.window',
		'wikia.tracker'
	],
	function ($, w) {
		'use strict';

		function bindCloseModuleLink() {
			$('.templatedraft-module-closelink-link')
				.on('click', closeModule);
		}

		function closeModule() {
			$('.templatedraft-module').hide();

			$.nirvana.sendRequest({
				controller: 'TemplateDraftController',
				method: 'markTemplateAsNotInfobox',
				data: {
					'pageId': w.wgArticleId
				}
			});
		}

		function init() {
			bindCloseModuleLink();
		}

		return {
			init: init
		};
	}
);
