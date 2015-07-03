/**
 * This file is executed on view of a page in a template namespace
 */
require(
	[
		'ext.wikia.templateDraft.rightRailModule',
		'ext.wikia.templateDraft.tracking'
	],
	function (rightRailModule, templateDraftTracking) {
		'use strict';
		rightRailModule.init();
		templateDraftTracking.init();
});
