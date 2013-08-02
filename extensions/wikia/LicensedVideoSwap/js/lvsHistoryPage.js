/**
 * AJAX interrupter for Licensed Video Swap undo workflow
 * @author Kenneth Kouot <kenneth@wikia-inc.com>
 */
require([
		'jquery',
		'lvs.commonajax'
], function($, commonAjax) {

	function LVSHistoryPage(opts) {
		this.location = window.location.href;

		this.$el = $(opts.el);

		this.init();
	}

	LVSHistoryPage.prototype = {
		init: function() {
			this.redirectUrl = this.buildRedirectUrl();
			this.bindUndoEvents();
			this.bindListAnchors();
		},
		buildRedirectUrl: function() {
			// redirect back to main LVS page
			return this.location.replace('/History', '');
		},
		bindUndoEvents: function() {
			var events,
					that;

			that = this;
			events = [
				'undo.clicked',
				'undo.failed'
			];
			
			this.$el.on( events.join(' '), function(evt) {
				// build function name from namespace and evoke
				var state = evt.namespace;
				if (state === 'clicked') {
					return that.handleUndoClick();
				} else {
					return that.handleUndoFail();
				}
			});
		},
		bindListAnchors: function() {
			var that = this;

			this.$el.on('click', '.undo-link', function(evt) {
				var url = evt.target.href;
				evt.preventDefault();

				that.$el.trigger('undo.clicked');

				that.undoSwap(url)
					.success(function() {
						window.location = that.redirectUrl;
					})
					.error(function() {
						that.$el.trigger('undo.failed');
					});
			});
		},
		undoSwap: function(url) {
			// returns the promise
			return $.get(url);
		},
		handleUndoClick: function() {
			commonAjax.startLoadingGraphic();
		},
		handleUndoFail: function() {
			commonAjax.stopLoadingGraphic();
		},
		// restore clobbered constructor
		constructor: LVSHistoryPage
	};

	return new LVSHistoryPage({
		el: '.lvs-undo-list'
	});
});
