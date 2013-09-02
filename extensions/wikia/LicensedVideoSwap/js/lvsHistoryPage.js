/**
 * AJAX interrupter for Licensed Video Swap undo workflow
 * @author Kenneth Kouot <kenneth@wikia-inc.com>
 */
require([
	'jquery',
	'lvs.commonajax'
], function($, commonAjax) {

	function LVSHistoryPage(opts) {
		var that = this;

		// wait for DOM ready
		$(function() {
			that.$el = $(opts.el);
			that.init();
		});

	}

	LVSHistoryPage.prototype = {
		init: function() {
			// bind click event on undo links
			this.$el.on( 'click', '.undo-link', $.proxy( this.handleUndoClick, this ) );
		},
		undoSwap: function(url) {
			// returns the promise
			return $.get(url);
		},
		handleUndoClick: function( evt ) {
			evt.preventDefault();

			var target = evt.target,
				url = target.href,
				that = this;

			commonAjax.startLoadingGraphic();

			this.undoSwap(url)
				.success(function( data ) {
					if ( data.result === "error" ) {
						that.handleUndoFail( data.msg );
					} else {
						that.handleUndoSuccess( data.msg, target );
					}
				})
				.error(function() {
					that.handleUndoFail( $.msg( 'oasis-generic-error' ) );
				});
		},
		handleUndoFail: function( msg ) {
			commonAjax.stopLoadingGraphic();
			GlobalNotification.show( msg, 'error' );
		},
		handleUndoSuccess: function( msg, target ) {
			$( target ).closest( 'li' ).remove();
			commonAjax.stopLoadingGraphic();
			GlobalNotification.show( msg, 'confirm' );
		},
		// restore clobbered constructor
		constructor: LVSHistoryPage
	};

	return new LVSHistoryPage({
		el: '.lvs-undo-list'
	});
});
