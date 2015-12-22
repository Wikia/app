define(
	'ext.wikia.templateDraft.rightRailModule',
	[
		'jquery',
		'mw',
	],
	function ($, mw) {
		'use strict';

		function bindCloseModuleLink() {
			$('.templatedraft-module-closelink-link')
				.on('click', closeModule);
		}

		function closeModule() {
			$('.templatedraft-module').hide();

			$.nirvana.sendRequest({
				controller: 'TemplateClassificationApiController',
				method: 'classifyTemplate',
				data: {
					pageId: mw.config.get('wgArticleId'),
					type: 'unknown',
					editToken: mw.user.tokens.get('editToken')
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
