CKEDITOR.plugins.add('rte-dialog',
{
        init: function(editor) {
		// extend CK dialog class

		// get ID of active dialog tab
		CKEDITOR.dialog.prototype.getActiveTab = function() {
			return this._.currentTabId;
		};

		// setup MW suggest on given dialog field
		CKEDITOR.dialog.prototype.enableSuggesionsOn = function(field, namespaces) {
			var fieldId = field._.inputId,
				node = $('#' + fieldId);

			if (!node.exists() || node.data('suggestSetUp')) {
				return;
			}

			RTE.log('enabling MW suggest on #' + fieldId);

			$.when( mw.loader.use( ['jquery.ui.autocomplete'] ) ).then( function( ) {

				// @see http://www.mediawiki.org/wiki/ResourceLoader/JavaScript_Deprecations#mwsuggest.js
				// uses CSS rules from 'wikia.jquery.ui' module
			
				node.autocomplete({
					minLength: 2,
					source: function( request, response ) {
						$.getJSON(
							mw.util.wikiScript( 'api' ),
							{
								format: 'json',
								action: 'opensearch',
								search: request.term,
								namespace: namespaces.join('|')
								// WARNING: Regardless what the API documentation says, MediaWiki's
								// PrefixSearch::defaultSearchBackend() supports only one namespace
								// and falls back to NS_MAIN when multiple namespaces given.
							},
							function( arr ) {
								if ( arr && arr.length > 1 ) {
									response( arr[1] );
								}
								else {
									response( [] );
								}
							}
						);
					}
				});
				node.data('suggestSetUp', true);

				// Prevent some keys from bubbling up. (#4269)
				var element = new CKEDITOR.dom.element(node[0]),
					ev;

				for (ev in { keyup :1, keydown :1, keypress :1}) {
					element.on(ev, function(e) {
						// ESC, ENTER
						var preventKeyBubblingKeys = { 27 :1, 13 :1 };
						if (e.data.getKeystroke() in preventKeyBubblingKeys) {
							e.data.stopPropagation();
						}
					});
				}
			});
		};

		// set loading state of current dialog
		CKEDITOR.dialog.prototype.setLoading = function(loading) {
			var wrapper = this.getElement();

			wrapper.removeClass('wikiaEditorLoading');

			if (loading) {
				wrapper.addClass('wikiaEditorLoading');
			}
		};

		// setup click tracking when dialog is about to be shown
		if(!CKEDITOR.dialog.prototype.showOriginal){
			CKEDITOR.dialog.prototype.showOriginal = CKEDITOR.dialog.prototype.show;
			CKEDITOR.dialog.prototype.show = function() {
				this.showOriginal();

				if(!this._.trackingSetUp) {
					this.initTracking();

					// run this just once per dialog's instance
					this._.trackingSetUp = true;
				}
			};
		}

		// setup tracking for given dialog
		CKEDITOR.dialog.prototype.initTracking = function() {
			this.on('show', $.proxy(this.track, this));
			this.on('close', $.proxy(this.track, this));

			// dialog field did not pass validation
			this.on('notvalid', $.proxy(this.track, this));

			// handle clicks on OK button - set a flag (to be read by "onHide" event)
			this.on('ok', $.proxy(function(ev) {
				this._.okClicked = true;
			}, this));

			// when dialog is being closed check whether if was caused by clicking "Ok" button
			this.on('hide', $.proxy(function() {
				if (this._.okClicked) {
					this.track({name: 'ok'});

					delete this._.okClicked;
				}
			}, this));
		};

		// report "<dialogName>/dialog/<eventName>" events
		CKEDITOR.dialog.prototype.track = function(ev) {
			RTE.track(this._.name, 'dialog', ev.name);
		};

		// always show body's scrollbars when modal is shown (BugId:7498)
		editor.on('dialogShow', function(ev) {
			$(document.body).addClass('modalShown');
		});

		editor.on('dialogHide', function(ev) {
			$(document.body).removeClass('modalShown');
		});
	}
});
