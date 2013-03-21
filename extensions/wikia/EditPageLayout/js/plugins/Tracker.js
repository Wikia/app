/**
 * Tracking for the editor.
 */

(function( window, $ ) {
	var Wikia = window.Wikia,
		WikiaEditor = window.WikiaEditor;

	WikiaEditor.plugins.tracker = $.createClass( WikiaEditor.plugin, {
		category: 'editor',

		init: function() {
			var editPageType;

			// Differentiate mini editor from main editor
			if ( this.editor.config.isMiniEditor ) {
				this.category += '-mini';

			// Track edit page views and page type
			} else {
				switch( window.wgCanonicalSpecialPageName ) {
					case 'CreatePage': {
						editPageType = 2;
						break;
					}
					case 'CreateBlogPage': {
						editPageType = 3;
						break;
					}
					default: {
						editPageType = window.wgIsMainpage ? 1 : 0;
					}
				}

				this.track({
					action: Wikia.Tracker.ACTIONS.VIEW,
					category: 'edit-' + this.editor.mode,
					label: 'edit-page',
					value: editPageType
				});
			}

			// Add the tracking function to the editor object for easy reference elsewhere
			this.editor.track = this.proxy( this.track );
		},

		track: function( data ) {

			// Support string as shortcut for label (common use case)
			if ( typeof data === 'string' ) {
				data = {
					label: data
				};
			}

			Wikia.Tracker.track({
				action: Wikia.Tracker.ACTIONS.CLICK,
				category: this.category + '-' + this.editor.mode,
				trackingMethod: 'ga'
			}, data );
		}
	});

})( this, jQuery );