/**
 * Tracking for the editor.
 */

(function( window, $ ) {
	var	Wikia = window.Wikia,
		WikiaEditor = window.WikiaEditor;

	WikiaEditor.plugins.tracker = $.createClass( WikiaEditor.plugin, {
		config: {
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'editor',
			trackingMethod: 'ga'
		},

		init: function() {
			var	isMiniEditor = this.editor.config.isMiniEditor,
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

			// Add the tracking functions to the editor object for easy reference elsewhere
			this.editor.track = this.proxy( this.track );
			this.editor.trackWithEventData = this.proxy( this.trackWithEventData );
			this.editor.on( 'ckInstanceCreated', this.proxy( this.onCkInstanceCreated ) );
		},

		// CKEditor only events
		onCkInstanceCreated: function( ck ) {
			ck.on( 'dialogCancel', this.proxy( this.onCkDialogCancel ) );
			ck.on( 'dialogOk', this.proxy( this.onCkDialogOk ) );
			ck.on( 'dialogShow', this.proxy( this.onCkDialogShow ) );
			ck.on( 'panelClick', this.proxy( this.onCkPanelClick ) );
			ck.on( 'panelShow', this.proxy( this.onCkPanelShow ) );
		},

		onCkDialogCancel: function( event ) {
			var label = event.data._.name.toLowerCase();

			if ( label ) {
				this.track( 'dialog-' + label + '-cancel' );
			}
		},

		onCkDialogOk: function( event ) {
			var label = event.data._.name.toLowerCase();

			if ( label ) {
				this.track( 'dialog-' + label + '-ok' );
			}
		},

		onCkDialogShow: function( event ) {
			var label = event.data._.name.toLowerCase();

			if ( label ) {
				this.track( 'dialog-' + label + '-open' );
			}
		},

		onCkPanelClick: function( event ) {
			var	label = event.data.me.label.toLowerCase(),
				title = event.data.value;

			if ( label && title ) {
				this.track( 'panel-' + label + '-item-' + title );
			}
		},

		onCkPanelShow: function( event ) {
			var label = event.data.me.label.toLowerCase();

			if ( label ) {
				this.track( 'panel-' + label + '-open' );
			}
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
		 *        The event object which should contain tracking data. A function to
		 *        determine whether or not the tracking call should be sent can be provided
		 *        in the key 'condition.'
		 *
		 * @example
		 *     $( '.element' ).on( 'mousedown', 'a', {
		 *         category: category,
		 *         condition: function( event ) { ... },
		 *         label: 'related-pages'
		 *     }, WikiaEditor.trackWithEventData );
		 */
		trackWithEventData: function( event ) {
			var data;

			if ( typeof event === 'object' &&
					typeof event.data === 'object' &&
					// If the condition function returns false, tracking will be canceled
					( typeof event.condition !== 'function' || event.condition() !== false )
			) {
				data = event.data;
				data.browserEvent = event;

				this.track( data );
			}
		}
	});

	// Proxy tracker methods onto WikiaEditor for static access
	(function() {
		var	i,
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

	// Edit page tracking. Anything that is always visible on the edit page should be
	// tracked here. Other tracking will have to be embedded into code outside of this file.
	$(function() {
		var rCkButtonTitle = /cke_button_(\w+)/;

		function getCkButtonTitle( element ) {
			var matches = element.className.match( rCkButtonTitle );
			return matches && matches[ 1 ];
		}

		// Module: Panel Buttons
		$( '#EditPageRail' ).on( 'mousedown', '.module_insert .cke_button', function( e ) {
			var	label,
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

		// Module: CKEditor Tabs
		$( '#EditPageTabs' ).on( 'mousedown', '.cke_button a', function( e ) {
			var title = getCkButtonTitle( e.currentTarget );

			if ( title ) {
				WikiaEditor.track( 'tab-' + title.toLowerCase() );
			}
		});

		// Module: CKEditor Toolbar
		(function() {

			// Blacklisted items are tracked elsewhere
			var blacklist = [
					'link'
				],
				label = 'toolbar-';

			$( '#EditPageToolbar' )
				.on( 'mousedown', '.cke_button a', function( e ) {
					var title = getCkButtonTitle( e.currentTarget );

					if ( title && !~$.inArray( title, blacklist ) ) {
						WikiaEditor.track( label + 'button-' + title.toLowerCase() );
					}
				})
				.on( 'mousedown', '.cke_toolbar_expand', function( e ) {
					var title = $( e.currentTarget ).find( '.expand' ).is( ':visible' ) ? 'more' : 'less';
					WikiaEditor.track( label + title );
				});
		})();
	});

})( this, jQuery );