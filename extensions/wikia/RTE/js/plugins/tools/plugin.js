// "fake" CK plugin with RTE helper methods
CKEDITOR.plugins.add('rte-tools', {});

window.RTE.tools = {
	// show modal version of alert()
	"alert": function(title, content) {
		window.$.showModal(title, '<p>' + content + '</p>', {className: 'RTEModal', width: 500});
	},

	// call given function with special RTE event type and provide function with given element and extra data
	callFunction: function(fn, element, data) {
		// extra check
		if (typeof fn != 'function') {
			return;
		}

		// create "fake" event
		var ev = jQuery.Event('rte');

		// add extra event data
		ev.data = (typeof data == 'object') ? data : {};
		ev.data.element = element || false;

		// "fake" target
		ev.target = window.document.createElement('div');

		fn.call(window, ev);
	},

	// checks whether given page name exists and sets appriopriate CSS classes / href of element
	checkInternalLink: function(element, pageName) {
		// check for anchor
		var anchor = '';
		if (/^#(.+)/.test(pageName)) {
			// use current page name and store anchor
			anchor = pageName;
			pageName = window.wgPageName;
		}

		RTE.ajax('checkInternalLink', {title: pageName}, function(data) {
			if (!data.exists) {
				element.addClass('new');
			}
			else {
				element.removeClass('new');
			}

			element.setAttribute('href', data.href + anchor);
			element.setAttribute('title', data.title);
		});
	},

	// show modal version of confirm()
	// call callback when Ok is pressed
	"confirm": function(title, question, callback) {
		var html = '<p>' + question + '</p>' +
			'<div class="RTEConfirmButtons neutral">' +
				'<a id="RTEConfirmCancel" class="wikia-button secondary"><span>' + RTE.getInstance().lang.common.cancel + '</span></a>' +
				'<a id="RTEConfirmOk" class="wikia-button"><span>' + RTE.getInstance().lang.common.ok + '</span></a>' +
			'</div>';

		function track(label) {
			var data = $('#RTEConfirm').data('tracking');
			if (data) {
				WikiaEditor.track(data, label);
			}
		}

		var wrapper = $.showModal(title, html, {
			id: 'RTEConfirm',
			className: 'RTEModal',
			width: 500,
			onClose: function() {
				track('rte-confirm-close');
			},
			callbackBefore: function() {
				$('#RTEConfirmOk').click(function() {
					track('button-rte-confirm-ok');

					$('#RTEConfirm').closeModal();

					// try to call callback when Ok is pressed
					if (typeof callback == 'function') {
						callback();
					}
				});

				$('#RTEConfirmCancel').click(function() {
					track('button-rte-confirm-cancel');

					$('#RTEConfirm').closeModal();
				});
			}
		});

		return wrapper;
	},

	// creates new placeholder of given type and with given meta data
	createPlaceholder: function(type, data) {
		var placeholder = $('<img />', RTE.getInstance().document.$);

		// CSS classes and attributes
		placeholder.addClass('placeholder placeholder-' + type);
		placeholder.attr('src', wgBlankImgUrl).attr('type', type).attr('data-rte-instance', RTE.instanceId);

		// set meta data
		data = data && (typeof data == 'object') ? data : {};
		data.type = type;
		data.placeholder = true;

		placeholder.setData(data);

		RTE.log('creating new placeholder for "' + type + '"');
		RTE.log(placeholder);

		return placeholder;
	},

	// RT #69635: prevent drag&drop for provided elements
	disableDragDrop: function(nodes) {
		nodes.bind('mousedown', function(ev) {
			ev.preventDefault();
		});
	},

	// get height of editor's iframe
	getEditorHeight: function() {
		return $('#cke_contents_' + WikiaEditor.instanceId).height();
	},

	// get editor's document scroll offsets
	getEditorScrollOffsets: function() {
		var scrollLeft, scrollTop;

		if (CKEDITOR.env.webkit) {
			// RT #46408: use different property for Safari to get scroll offset
			scrollLeft = RTE.getInstance().document.$.body.scrollLeft;
			scrollTop = RTE.getInstance().document.$.body.scrollTop;
		}
		else {
			scrollLeft = RTE.getInstance().document.$.documentElement.scrollLeft;
			scrollTop = RTE.getInstance().document.$.documentElement.scrollTop;
		}

		return {
			left: scrollLeft,
			top: scrollTop
		};
	},

	// get theme colors from .color1 CSS class
	// TODO: use SASS settings echo'ed by PHP to JS variable(s)
	getThemeColors: function() {
		// create or use existing color picker div
		var colorPicker = $('#RTEColorPicker');
		if ( !colorPicker.exists() ) {
			colorPicker = $('<div id="RTEColorPicker">').addClass('color1').appendTo(RTE.overlayNode).hide();
		}

		// get colors and update CK config
		RTE.config.baseBackgroundColor = colorPicker.css('backgroundColor');
		RTE.config.baseColor = colorPicker.css('color');
	},

	// get list of images
	getImages: function() {
		var images = RTE.getEditor().find('img.image');
		return images;
	},

	// get list of media (images / videos)
	getMedia: function() {
		var media = RTE.getEditor().find('img.image,img.video');
		return media;
	},

	// get position of given placeholder in coordinates of browser window
	getPlaceholderPosition: function(placeholder) {
		var position = placeholder.offset(),
			scrollOffsets = this.getEditorScrollOffsets();

		return {
			left: parseInt(position.left - scrollOffsets.left),
			top: parseInt(position.top - scrollOffsets.top)
		};
	},

	// get list of placeholders of given type (or all if no type is provided)
	getPlaceholders: function(type) {
		var query = type ? ('img[type=' + type + ']') : 'img.placeholder';
		var placeholders = RTE.getEditor().find(query);
		return placeholders;
	},

	// get text content of current selection
	getSelectionContent: function() {
		var text;

		if (CKEDITOR.env.ie) {
			// IE
			text = RTE.getInstance().document.$.selection.createRange().text;
		}
		else {
			// Gecko, Opera, Safari
			text = RTE.getInstance().window.$.getSelection().toString();
		}

		return text;
	},

	// get list of videos
	getVideos: function() {
		var videos = RTE.getEditor().find('img.video');
		return videos;
	},

	// inserts given DOMElement / jQuery element into CK
	// TODO: throw an exception if jQuery element was not
	// created inside CKeditor's document
	insertElement: function(element, dontReinitialize) {
		var CKelement = new CKEDITOR.dom.element($(element).get(0));

		RTE.getInstance().insertElement(CKelement);

		// re-initialize placeholders
		if (!dontReinitialize) {
			RTE.getInstance().fire('wysiwygModeReady');
		}
	},

	// check whether given URL is external
	isExternalLink: function(href) {
		return this.isExternalLinkRegExp.test(href);
	},

	isExternalLinkRegExp: new RegExp('^' + window.RTEUrlProtocols),

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

	// remove given node and add undo step
	removeElement: function(elem) {
		// save undo step (RT #35914)
		RTE.getInstance().fire('saveSnapshot');

		// remove element
		$(elem).remove();

		// save undo step (RT #35914)
		RTE.getInstance().fire('saveSnapshot');
	},

	// remove resize box
	removeResizeBox: function() {
		setTimeout(function() {
			// simply switch design mode off and on - this solves #RT #33853
			if (CKEDITOR.env.gecko) {
				var documentNode = RTE.getInstance().document.$;

				documentNode.designMode = 'off';
				documentNode.designMode = 'on';
			}
		}, 50);
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

	// makes the element and its children unselectable
	// @see http://www.highdots.com/forums/javascript/making-image-unselectable-ff-292462.html
	// TODO: remove as it's no longer needed
	unselectable: function(elem) {}
}

// helper class for highlighting given parts of editor's HTML
// TODO: move to a separate file (plugin maybe?)
CKEDITOR.nodeRunner = function() {
	// "Beep, Beep"
};

CKEDITOR.nodeRunner.prototype = {
	// recursively call provided function for child nodes (skip read only nodes)
	walk: function(node, callback) {
		if ((node.type != CKEDITOR.NODE_ELEMENT) || node.isReadOnly() || this.isSkipped(node)) {
			return;
		}

		var childNode,
			childNodes = node.getChildren();

		for (var n=0, len = childNodes.count(); n < len; n++) {
			childNode = childNodes.getItem(n);
			callback(childNode);
			this.walk(childNode, callback);
		}
	},

	// recursively call provided function for child text nodes
	walkTextNodes: function(node, callback) {
		this.walk(node, function(node) {
			if (node.type == CKEDITOR.NODE_TEXT) {
				callback(node);
			}
		});
	},

	// override this function when you create an object of class CKEDITOR.nodeRunner
	isSkipped: function(node) {
		return false;
	}
};
