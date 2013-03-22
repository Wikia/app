/**
 * Tracking for the editor.
 */

(function( window, $ ) {
	var Wikia = window.Wikia,
		WikiaEditor = window.WikiaEditor;

	WikiaEditor.plugins.tracker = $.createClass( WikiaEditor.plugin, {
		config: {
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'editor',
			trackingMethod: 'ga'
		},

		init: function() {
			var isMiniEditor = this.editor.config.isMiniEditor,
				editorType = ( isMiniEditor ? '-mini-' : '-' ) +
					( ( window.RTE !== undefined && !window.RTEEdgeCase ) ? 'ck' : 'mw' );

			// Track edit page views and page type
			if ( !isMiniEditor ) {
				this.track({
					action: Wikia.Tracker.ACTIONS.VIEW,
					category: 'edit' + editorType,
					label: 'edit-page'
				});
			}

			// Add editor type to config category
			this.config.category += editorType;

			// Add the tracking function to the editor object for easy reference elsewhere
			this.editor.track = this.proxy( this.track );
		},

		track: function( data ) {
			// Support string as shortcut for label (common use case)
			Wikia.Tracker.track( this.config, typeof data === 'string' ? {
				label: data
			} : data );
		}
	});

})( this, jQuery );