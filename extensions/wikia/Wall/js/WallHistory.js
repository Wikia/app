/* global require */
require(['jquery', 'wikia.window'], function ($, context) {
	'use strict';

	context.WallHistory = $.createClass(context.Wall, {
		constructor: function () {
			var sortingBar = new context.Wall.settings.classBindings.sortingBar();
			$('#WallHistory .message-restore, #WallThreadHistory .message-restore').click(this.proxy(this.confirmAction));
			var timeout = null;
			$('#WallHistory tr').hover(
				function () {
					var self = this;
					timeout = setTimeout(function () {
						$(self).find('.threadHistory').css('visibility', 'visible');
					}, 500);
				},
				function () {
					$('.threadHistory').css('visibility', 'hidden');
					clearTimeout(timeout);
				}
			);
		},
		afterRestore: function () {
			window.location.reload();
		}
	});

	$(function () {
		context.wallHistory = new context.WallHistory();
	});
});
