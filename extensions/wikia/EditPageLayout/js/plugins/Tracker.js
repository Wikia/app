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
			this.editor.trackWithEventData = this.proxy( this.trackWithEventData );
		},

		track: function( data ) {
			// Support string as shortcut for label (common use case)
			Wikia.Tracker.track( this.config, typeof data === 'string' ? {
				label: data
			} : data );
		},

		/**
		 * Convenience method for tracking with data stored in a jQuery Event object.
		 *
		 * @param {Object} event
		 *        The event object.
		 *
		 * @param {Function} [condition]
		 *        A function to determine whether or not to send the tracking call.
		 *        Should return a boolean. Gets 'event' as first argument.
		 *
		 */
		trackWithEventData: function( event, condition ) {
			var data;

			if ( typeof event === 'object' &&
					typeof event.data === 'object' &&
					( typeof condition !== 'function' || condition() !== false )
			) {
				data = event.data;
				data.browserEvent = event;

				this.track( data );
			}
		}
	});

	// Proxy tracker methods onto WikiaEditor for static access
	(function() {
		var i,
			l,
			methodNames = [ 'track', 'trackWithEventData' ],
			slice = [].slice;

		for ( i = 0, l = methodNames.length; i < l; i++ ) {
			(function( methodName ) {
				WikiaEditor[ methodName ] = function() {
					var tracker = WikiaEditor.getInstance().plugins.tracker;
					tracker[ methodName ].apply( tracker, slice.call( arguments ) );
				}
			})( methodNames[ i ] );
		}
	})();

	$(function() {
		// Module: Panel Buttons
		$( '#EditPageRail' ).on( 'mousedown', '.module_insert .cke_button', function( e ) {
			var label,
				el = $( e.currentTarget );

			// Primary mouse button only
			if ( e.which !== 1 ) {
				return;
			}

			if ( el.hasClass( 'RTEImageButton' ) ) {
				label = 'add-photo';
			} else if ( el.hasClass( 'RTEGalleryButton' ) ) {
				label = 'add-gallery';
			} else if ( el.hasClass( 'RTESlideshowButton' ) ) {
				label = 'add-slideshow';
			} else if ( el.hasClass( 'RTEVideoButton' ) ) {
				label = 'add-video';
			} else if ( el.hasClass( 'RTEPollButton' ) ) {
				label = 'add-poll';
			} else if ( el.hasClass( 'cke_button_table' ) ) {
				label = 'add-table';
			}

			if ( label !== undefined ) {
				WikiaEditor.track( label );
			}
		});
	});

})( this, jQuery );