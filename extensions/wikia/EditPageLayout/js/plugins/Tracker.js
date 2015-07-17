/**
 * Tracking for the editor.
 */

(function( window, $ ) {
	var	slice = [].slice,
		Wikia = window.Wikia,
		WikiaEditor = window.WikiaEditor;

	// Depends on Wikia.Tracker
	if ( !( Wikia || Wikia.Tracker ) ) {
		return;
	}

	WikiaEditor.plugins.tracker = $.createClass( WikiaEditor.plugin, {
		config: {
			action: Wikia.Tracker.ACTIONS.CLICK,
			trackingMethod: 'analytics'
		},

		init: function() {
			var	isMiniEditor = this.editor.config.isMiniEditor,
				editorType = ( isMiniEditor ? '-mini-' : '-' ) +
					( ( window.RTE !== undefined && !window.RTEEdgeCase ) ? 'ck' : 'mw' );

			// Add editor type to category
			this.config.category = 'editor' + editorType;

			// Track edit page views and page type
			if ( !isMiniEditor ) {
				if ( window.veTrack ) {
					veTrack( { action: 'ck-edit-page-start' } );
				}
				this.track({
					action: Wikia.Tracker.ACTIONS.IMPRESSION,
					label: 'edit-page'
				});
			}

			// Add the tracking functions to the editor object for easy reference elsewhere
			this.editor.track = this.proxy( this.track );
			this.editor.trackWithEventData = this.proxy( this.trackWithEventData );
			this.editor.on( 'ckInstanceCreated', this.proxy( this.onCkInstanceCreated ) );
		},

		// CKEditor only events
		onCkInstanceCreated: function( ck ) {
			ck.on( 'buttonClick', this.proxy( this.onCkButtonClick ) );
			ck.on( 'dialogCancel', this.proxy( this.onCkDialogCancel ) );
			ck.on( 'dialogClose', this.proxy( this.onCkDialogClose ) );
			ck.on( 'dialogOk', this.proxy( this.onCkDialogOk ) );
			ck.on( 'dialogShow', this.proxy( this.onCkDialogShow ) );
			ck.on( 'panelClick', this.proxy( this.onCkPanelClick ) );
			ck.on( 'panelShow', this.proxy( this.onCkPanelShow ) );
		},

		onCkButtonClick: function( event ) {
			var label = event.data.button.label.toLowerCase();
			this.track( 'button-' + label );
		},

		onCkDialogCancel: function( event ) {
			var label = event.data._.name.toLowerCase();
			this.track( 'dialog-' + label + '-button-cancel' );
		},

		onCkDialogClose: function( event ) {
			var label = event.data._.name.toLowerCase();
			this.track( 'dialog-' + label + '-button-close' );
		},

		onCkDialogOk: function( event ) {
			var label = event.data._.name.toLowerCase();
			this.track( 'dialog-' + label + '-button-ok' );
		},

		onCkDialogShow: function( event ) {
			var label = event.data._.name.toLowerCase();

			this.track({
				action:  Wikia.Tracker.ACTIONS.OPEN,
				label: 'dialog-' + label
			});
		},

		onCkPanelClick: function( event ) {
			var	label = event.data.me.label.toLowerCase(),
				value = event.data.value;

			this.track( 'panel-' + label + '-item-' + value );
		},

		onCkPanelShow: function( event ) {
			var label = event.data.me.label.toLowerCase();

			this.track({
				action:  Wikia.Tracker.ACTIONS.OPEN,
				label: 'panel-' + label
			});
		},

		// Wrapper for Wikia.Tracker so we can perform some magic
		track: function() {
			var	args = slice.call( arguments ),
				data = {},
				labelParts = [];

			// Merge arguments left
			$.each( args, function( i, arg ) {

				// Support string arguments as shorthand for { label: 'label' }
				if ( typeof arg === 'string' ) {
					arg = {
						label: arg
					};

				// Append category information to label and remove it from
				// the dataset so it won't override the editor category.
				} else if ( arg.category ) {
					labelParts.push( arg.category );
				}

				$.extend( data, arg );
			});

			// Remove category
			delete data.category;

			// Update label
			if ( data.label != undefined && data.label != '' ) {
				labelParts.push( data.label );
			}

			data.label = labelParts.join( '-' );

			Wikia.Tracker.track( this.config, data );
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
			methodNames = [ 'track', 'trackWithEventData' ];

		for ( i = 0, l = methodNames.length; i < l; i++ ) {
			(function( methodName ) {
				WikiaEditor[ methodName ] = function() {
					var tracker = WikiaEditor.getInstance().plugins.tracker;
					tracker[ methodName ].apply( tracker, slice.call( arguments ) );
				}
			})( methodNames[ i ] );
		}
	})();

	// Anything that is shared across the main editor and MiniEditor should be
	// tracked above, the stuff down here is just for edit page chrome that can't
	// be tracked through CKEditor events.
	$(function() {

		// Module: Page Controls
		(function() {
			var label = 'toolbar-';

			$( '#EditPageToolbar' )
				.on( 'mousedown', '.cke_toolbar_expand', function( e ) {
					var title = $( e.currentTarget ).find( '.expand' ).is( ':visible' ) ? 'more' : 'less';
					WikiaEditor.track( label + title );
				});
		})();
	});

})( this, jQuery );
