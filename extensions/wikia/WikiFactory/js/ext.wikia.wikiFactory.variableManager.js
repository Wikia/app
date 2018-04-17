/* global define */
define('ext.wikia.wikiFactory.variableManager', [
	'ext.wikia.wikiFactory.variableService'
], function (variableService) {
	'use strict';

	return function () {
		var varManagerForms = document.getElementsByClassName('wf-variable-form'),
			formCount = varManagerForms.length;

		for (var i = 0; i < formCount; i++) {
			varManagerForms[i].querySelector('.wk-submit').addEventListener('click', variableService.saveVariable);
			varManagerForms[i].querySelector('.wk-submit-remove').addEventListener('click', variableService.removeVariable);
		}
	};
});
