CKEDITOR.plugins.add('rte-tools',
{
        init: function(editor) {
		// RTE helper methods
		window.RTE.tools = {
			// show modal alert
			"alert": function(title, content) {
				window.$.showModal(title, '<p>' + content + '</p>', {className: 'RTEAlert'});
			},

			// call given function with special RTE event type and provide function with given placeholder
			callFunction: function(fn, placeholder) {
				// extra check
				if (typeof fn != 'function') {
					return;
				}

				// create "fake" event with extra data and "fake" target
				var ev = jQuery.Event('rte');
				ev.data = {placeholder: placeholder || false};
				ev.target = window.document.createElement('div');

				fn.call(window, ev);
			},

			// checks whether given page name exists and sets appriopriate CSS classes / href of element
			checkInternalLink: function(element, pageName) {
				RTE.ajax('checkInternalLink', {title: pageName}, function(data) {
					if (!data.exists) {
						element.addClass('new');
					}
					else {
						element.removeClass('new');
					}

					element.setAttribute('href', data.href);
					element.setAttribute('title', data.title);
				});
			},

			// creates new placeholder of given type and with given meta data
			createPlaceholder: function(type, data) {
				var placeholder = $('<img />', editor.document.$);

				// CSS classes and attributes
				placeholder.addClass('placeholder placeholder-' + type);
				placeholder.attr('src', 'http://images.wikia.com/common/skins/monobook/blank.gif?1').attr('type', type).attr('_rte_placeholder', 1).attr('_rte_instance', RTE.instanceId);

				// set meta data
				data = (typeof data == 'object') ? data : {};
				data.type = type;

				placeholder.setData(data);

				RTE.log('creating new placeholder for "' + type + '"');
				RTE.log(placeholder);

				return placeholder;
			},

			// setup MW suggest on given dialog field
			enableSuggesionsOn: function(dialog, field, namespaces) {
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
						dialog._.suggestContainer = container;
					}
					else {
						dialog._.suggestContainer = $('#' + os_map[fieldId].container);
					}
				}

			},

			// return ID of currently visible dialog tab
			getActiveTab: function(dialog) {
				return dialog._.currentTabId;
			},

			// get list of images
			getImages: function() {
				var images = RTE.getEditor().find('img.image');
				return images;
			},

			// get position of given placeholder in coordinates of browser window
			getPlaceholderPosition: function(placeholder) {
				var position = placeholder.position();

				var scrollTop;
				var scrollTopPage = $(window).scrollTop();
				var scrollTopEditor = RTE.instance.document.$.documentElement.scrollTop;

				if (!CKEDITOR.env.ie) {
					// use both page and editarea scroll
					scrollTop = scrollTopPage + scrollTopEditor;

					// keep value of position.top constant (not depending on scrollTop of editarea)
					if (scrollTopPage > 0) {
						position.top += scrollTopEditor;
					}
				}
				else {
					// IE: ignore page scroll, use editarea scroll
					scrollTop = scrollTopEditor;
				}

				return {
					left: parseInt(position.left - 10),
					top: parseInt(position.top - scrollTop)
				};
			},

			// get list of placeholders of given type (or all if no type is provided)
			getPlaceholders: function(type) {
				var query = type ? ('img[type=' + type + ']') : 'img[type]';
				var placeholders = RTE.getEditor().find(query);
				return placeholders;
			},

			// get text content of current selection
			getSelectionContent: function() {
				var selection = (CKEDITOR.env.ie) ? editor.document.$.selection : editor.window.$.getSelection();
				var text = selection.type ? selection.createRange().text : selection.toString();

				return text;
			},

			// inserts given DOMElement / jQuery element into CK
			insertElement: function(element, dontReinitialize) {
				editor.insertElement( new CKEDITOR.dom.element($(element)[0]) );

				// re-initialize placeholders
				if (!dontReinitialize) {
					editor.fire('wysiwygModeReady');
				}
			},

			// simple JS "cache" for parse() method
			parseCache: {},

			// parse wikitext to HTML (try to use client-side JS "cache")
			parse: function(wikitext, callback) {
				var cache = RTE.tools.parseCache;

				// try to use cache
				if (typeof cache[wikitext] != 'undefined') {
					RTE.log('RTE.tools.parse() - cache hit');

					if (typeof callback == 'function') {
						callback(cache[wikitext]);
					}
					return;
				}

				// ok, send AJAX request
				RTE.ajax('parse', {wikitext: wikitext, title: window.wgPageName}, function(json) {
					cache[wikitext] = json.html;

					if (typeof callback == 'function') {
						callback(json.html);
					}
				});
			},

			// parse wikitext to HTML using RTE parser (try to use client-side JS "cache")
			parseRTE: function(wikitext, callback) {
				RTE.ajax('rteparse', {wikitext: wikitext, title: window.wgPageName}, function(json) {
					if (typeof callback == 'function') {
						callback(json.html);
					}
				});
			},

			// regenerate numbers for external "autonumbered" links
			renumberExternalLinks: function() {
				RTE.getEditor().find('a.autonumber').each(function(i) {
					  $(this).text('[' + (i+1) + ']');
				});
			},

			// simple JS "cache" for resolveDoubleBrackets() method
			resolveDoubleBracketsCache: {},

			// get information about given wikitext with double brackets syntax (templates / magic words / parser functions)
			resolveDoubleBrackets: function(wikitext, callback) {
				var cache = RTE.tools.resolveDoubleBracketsCache;

				// try to use cache
				if (typeof cache[wikitext] != 'undefined') {
					RTE.log('RTE.tools.resolveDoubleBrackets() - cache hit');

					if (typeof callback == 'function') {
						callback(cache[wikitext]);
					}
					return;
				}

				// ok, send AJAX request
				RTE.ajax('resolveDoubleBrackets', {wikitext: wikitext, title: window.wgPageName}, function(json) {
					cache[wikitext] = json;

					if (typeof callback == 'function') {
						callback(json);
					}
				});
			},
			// set loading state of current dialog
			setDialogLoading: function(dialog, loading) {
				var wrapper = dialog.getElement();

				wrapper.removeClass('wikiaEditorLoading');

				if (loading) {
					wrapper.addClass('wikiaEditorLoading');
				}
			}
		}
	}
});
