/**
 * This file is executed on view of a page in a template namespace
 */
(function () {
	'use strict';

	var rightRailModule = require('ext.wikia.templateDraft.rightRailModule'),
		templateDraftTracking = require('ext.wikia.templateDraft.tracking');

	rightRailModule.init();
	templateDraftTracking.init();
})();
