/**
 * TemplateClassification module for adding shortcut key to GlobalShortcuts extension
 */
require(['TemplateClassificationModal', 'GlobalShortcuts', 'PageActions', 'mw', 'wikia.loader'],
	function (templateClassificationModal, GlobalShortcuts, PageActions, mw, loader) {
		'use strict';

		function init() {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'TemplateClassificationGlobalShortcuts,GlobalShortcuts'
					}
				})
			).done(function (res) {
				mw.messages.set(res.messages);
				addShortcuts();
			});
		}

		function addShortcuts() {
			var actionId = 'page:Classify',
				actionDescription = {
					id: actionId,
					caption: mw.message('template-classification-global-shortcuts-caption-classify-page').escaped(),
					fn: templateClassificationModal.open,
					weight: 120,
					category: mw.message('global-shortcuts-category-current-page').escaped()
				};

			PageActions.add(actionDescription);
			GlobalShortcuts.add(actionId, 'k');
		}

		init();

	}
);
