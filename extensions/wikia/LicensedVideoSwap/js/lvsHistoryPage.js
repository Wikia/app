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

		this.el = opts.el;
		this.$el = $(this.el);

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
			var that = this;
			this.$el.on('undo.clicked undo.failed', function(evt) {
				// build function name from namespace and evoke
				that['handleUndo' + evt.namespace.charAt(0)
					.toUpperCase() + evt.namespace.slice(1)]();
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
						that.redirectToLvs();
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
		handleUndoClicked: function() {
			commonAjax.startLoadingGraphic();
		},
		handleUndoFailed: function() {
			commonAjax.stopLoadingGraphic();
		},
		redirectToLvs: function() {
			window.location = this.redirectUrl;
		},
		constructor: LVSHistoryPage
	};

	return new LVSHistoryPage({
		el: '.lvs-undo-list'
	});
});
