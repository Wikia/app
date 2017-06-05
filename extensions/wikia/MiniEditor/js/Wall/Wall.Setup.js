/* global require */
require(['jquery', 'wikia.window'], function ($, context) {
	'use strict';

	// Create a namespace for the Wall
	context.MiniEditor.Wall = {};

	// Add Wall styles for inside the iframe
	context.GlobalTriggers.on('MiniEditorReady', function() {
		if (context.MiniEditor.ckeditorEnabled) {
			context.RTE.config.contentsCss.push($.getSassLocalURL('/extensions/wikia/MiniEditor/css/Wall/Wall.content.scss'));
		}
	});

	// Add class to iframe body for different editarea types
	context.GlobalTriggers.on('WikiaEditorReady', function(wikiaEditor) {

		// Check if inside 'new-message'
		if (wikiaEditor.getEditorElement().parentsUntil('.new-message').length) {
			wikiaEditor.getEditbox().addClass('new-message');
		}
	});
});
