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
			if (typeof window.os_enableSuggestionsOn == 'function') {
				var fieldId = field._.inputId;

				// prevent submittion of fake RTE form
				document.getElementById('RTEFakeForm').submit = function() {};

				// use provided list of namespaces
				namespaces = (typeof namespaces != 'undefined' && namespaces.length) ? namespaces : [];
				// FIXME: dirty hack
				window.wgSearchNamespaces = namespaces;

				// setup MW suggest just once
				if (typeof window.os_map[fieldId] == 'undefined') {
					RTE.log('enabling MW suggest on "' + fieldId + '"...');

					window.os_enableSuggestionsOn(fieldId, 'RTEFakeForm');

					// create results container ...
					var container = $(window.os_createContainer(os_map[fieldId]));
					var fieldElem = $('#' + fieldId);

					// ... and move it to CK dialog
					// so it scrolls together with dialog and is positioned within field container
					fieldElem.parent().css('position', 'relative').append(container);

					// hide results container
					container.css('visibility', 'hidden');

					// store MW suggest container node
					this._.suggestContainer = container;

					// Prevent some keys from bubbling up. (#4269)
					var element = new CKEDITOR.dom.element(fieldElem[0]);

					// fix for RT #37023
					// Prevent some keys from bubbling up. (#4269)
					var self = this;
					for (var ev in { keyup :1, keydown :1, keypress :1}) {
						element.on(ev, function(e) {
							// ESC, ENTER
							var preventKeyBubblingKeys = { 27 :1, 13 :1 };
							if (e.data.getKeystroke() in preventKeyBubblingKeys) {
								// check if suggestion is shown
								var suggestBox = self._.suggestContainer;

								if (suggestBox.css('visibility') != 'hidden') {
									// set the flag
									self._.dontHide = true;

									e.data.stopPropagation();

									// hide suggest box
									suggestBox.css('visibility', 'hidden');
								}
							}
						});
					};

					var eventCallback = function(ev) {
						// prevent dialog hiding
						if (this._.dontHide) {
							RTE.log('dialog hide prevented');
							ev.data.hide = false;

							// unset this flag
							this._.dontHide = false;
						}
					};

					this.on('ok', eventCallback);
					this.on('cancel', eventCallback);
					// fix - end
				}
				else {
					this._.suggestContainer = $('#' + os_map[fieldId].container);
				}
			}

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
