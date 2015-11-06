(function () {
	'use strict';

	var $ = require('jquery'),
		callout = require('lvs.callout'),
		commonAjax = require('lvs.commonajax'),
		ellipses = require('lvs.ellipses'),
		swapKeep = require('lvs.swapkeep'),
		undo = require('lvs.undo'),
		videoControls = require('lvs.videocontrols'),
		suggestions = require('lvs.suggestions'),
		tracker = require('lvs.tracker');

	$(function () {
		var $container = $('#LVSGrid');

		// track impression
		tracker.track({
			action: tracker.actions.IMPRESSION
		});

		callout.init();
		commonAjax.init($container);
		ellipses.init($container);
		swapKeep.init($container);
		undo.init($container);
		videoControls.init($container);
		suggestions.init($container);
	});
})();
