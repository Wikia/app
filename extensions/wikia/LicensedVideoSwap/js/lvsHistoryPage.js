/**
 * AJAX interrupter for Licensed Video Swap undo workflow
 * @author Kenneth Kouot <kenneth@wikia-inc.com>
 */
(function () {
	'use strict';

	var $ = require('jquery'),
		commonAjax = require('lvs.commonajax'),
		BannerNotification = require('BannerNotification');

	function LVSHistoryPage(opts) {
		var self = this;

		// wait for DOM ready
		$(function () {
			self.$el = $(opts.el);
			self.init();
		});

	}

	LVSHistoryPage.prototype = {
		init: function () {
			// bind click event on undo links
			this.$el.on('click', '.undo-link', $.proxy(this.handleUndoClick, this));
		},
		undoSwap: function (url) {
			// returns the promise
			return $.get(url);
		},
		handleUndoClick: function (evt) {
			var target = evt.target,
				url = target.href,
				self = this;

			evt.preventDefault();

			commonAjax.startLoadingGraphic();

			this.undoSwap(url)
				.success(function (data) {
					if (data.result === 'error') {
						self.handleUndoFail(data.msg);
					} else {
						self.handleUndoSuccess(data.msg, target);
					}
				})
				.error(function () {
					self.handleUndoFail($.msg('oasis-generic-error'));
				});
		},
		handleUndoFail: function (msg) {
			commonAjax.stopLoadingGraphic();
			new BannerNotification(msg, 'error').show();
		},
		handleUndoSuccess: function (msg, target) {
			$(target).closest('li').remove();
			commonAjax.stopLoadingGraphic();
			new BannerNotification(msg, 'confirm').show();
		},
		// restore clobbered constructor
		constructor: LVSHistoryPage
	};

	return new LVSHistoryPage({
		el: '.lvs-undo-list'
	});
})();
