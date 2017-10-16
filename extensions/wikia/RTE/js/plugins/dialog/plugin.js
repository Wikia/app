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
			var self = this,
				fieldId = field._.inputId,
				node = $('#' + fieldId),
				promise = $.Deferred();

			if (!node.exists() || node.data('suggestSetUp')) {
				if (node.exists()) {
					promise.resolveWith(this, [node]);
				}
				return promise.promise();
			}

			RTE.log('enabling MW suggest on #' + fieldId);

			mw.loader.using( 'jquery.ui.autocomplete' ).then( function( ) {

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
								namespace: namespaces ? namespaces.join('|') : ''
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
					},
					// bugid: 43228 -- default jquery ui can't calculate the correct z-index in this context;
					// this is the lowest order of magnitude decimal value we could get away with.
					open: function(event, ui) { $(this).autocomplete('widget').css('z-index', 100000000);  }
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

				promise.resolveWith(self, [node]);
			});

			return promise.promise();
		};

		// set loading state of current dialog
		CKEDITOR.dialog.prototype.setLoading = function(loading) {
			var wrapper = this.getElement();

			wrapper.removeClass('wikiaEditorLoading');

			if (loading) {
				wrapper.addClass('wikiaEditorLoading');
			}
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
