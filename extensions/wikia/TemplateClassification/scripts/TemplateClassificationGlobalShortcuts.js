/**
 * TemplateClassification module for adding shortcut key to GlobalShortcuts extension
 */
require(['TemplateClassificationModal', 'GlobalShortcuts', 'PageActions'],
	function (templateClassificationModal, GlobalShortcuts, PageActions) {
		'use strict';

		var actionId = 'page:Classify',
			actionDescription = {
				id: actionId,
				caption: 'Classify page',
				fn: templateClassificationModal.open,
				weight: 120,
				category: 'Current page'
			};

		PageActions.add(actionDescription);
		GlobalShortcuts.add(actionId, 'k');
	}
);
