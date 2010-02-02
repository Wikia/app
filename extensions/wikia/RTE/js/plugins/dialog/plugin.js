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

		// setup tracking for given dialog
		// events "<name>/dialog/<event>" will be reported
		CKEDITOR.dialog.prototype.setupTracking = function(name, options) {
			// options handling (which events should be reported)
			var defaults = {cancel: 1, close: 1, ok:1, error: 1};
			options = $().extend(defaults, options);

			// cleanup
			this._.wikiaTrack = {
				sendEvent: options,
				sendEvents: true,
				name: name
			};

			// add custom events callbacks
			var self = this;
			this.on('cancelClicked', function(ev) {
				self.fireTrackingEvent('cancel', ev);
			});
			this.on('close', function(ev) {
				self.fireTrackingEvent('close', ev);
			});
			this.on('notvalid', function(ev) {
				self.fireTrackingEvent('error', ev);
			});

			// handle clicks on OK button
			var okButton = this.getButton('ok');
			if (okButton) {
				okButton.on('click', function(ev) {
					self.fireTrackingEvent('ok', ev);
				});
			}
		};

		CKEDITOR.dialog.prototype.fireTrackingEvent = function(eventName, ev) {
			var wikiaTrack = this._.wikiaTrack;

			if (wikiaTrack.sendEvents) {
				// should this type of event be reported
				if  (wikiaTrack.sendEvent[eventName]) {
					RTE.track(wikiaTrack.name, 'dialog', eventName);

					// prevent duplicated reports
					if (eventName == 'cancel' || eventName == 'close') {
						wikiaTrack.sendEvents = false;
					}
				}
			}
		};
	}
});
