// "fake" CK plugin with RTE helper methods
CKEDITOR.plugins.add('rte-tools', {});

window.RTE.tools = {
	// show modal version of alert()
	"alert": function(title, content) {
		window.$.showModal(title, '<p>' + content + '</p>', {className: 'RTEModal'});
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

	// show modal version of confirm()
	// call callback when Ok is pressed
	"confirm": function(title, question, callback) {
		var html = '<p>' + question + '</p>' +
			'<div class="RTEConfirmButtons neutral">' +
				'<a id="RTEConfirmCancel" class="wikia_button secondary"><span>' + RTE.instance.lang.common.cancel + '</span></a>' +
				'<a id="RTEConfirmOk" class="wikia_button"><span>' + RTE.instance.lang.common.ok + '</span></a>' +
			'</div>';

		$.showModal(title, html, {
			id: 'RTEConfirm',
			className: 'RTEModal',
			callbackBefore: function() {
				$('#RTEConfirmOk').click(function() {
					$('#RTEConfirm').closeModal();

					// try to call callback when Ok is pressed
					if (typeof callback == 'function') {
						callback();
					}
				});

				$('#RTEConfirmCancel').click(function() {
					$('#RTEConfirm').closeModal();
				});
			}
		});
	},

	// creates new placeholder of given type and with given meta data
	createPlaceholder: function(type, data) {
		var placeholder = $('<img />', RTE.instance.document.$);

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
		var query = type ? ('img[type=' + type + ']') : 'img.placeholder';
		var placeholders = RTE.getEditor().find(query);
		return placeholders;
	},

	// get text content of current selection
	getSelectionContent: function() {
		var selection = (CKEDITOR.env.ie) ? RTE.instance.document.$.selection : RTE.instance.window.$.getSelection();
		var text = selection.type ? selection.createRange().text : selection.toString();

		return text;
	},

	// get list of videos
	getVideos: function() {
		var videos = RTE.getEditor().find('img.video');
		return videos;
	},

	// inserts given DOMElement / jQuery element into CK
	insertElement: function(element, dontReinitialize) {
		RTE.instance.insertElement( new CKEDITOR.dom.element($(element)[0]) );

		// re-initialize placeholders
		if (!dontReinitialize) {
			RTE.instance.fire('wysiwygModeReady');
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

	// makes the element and its children unselectable
	// @see http://www.highdots.com/forums/javascript/making-image-unselectable-ff-292462.html
	unselectable: function(elem) {
		return;

		$(elem).each(function(i) {
			var CKelem = new CKEDITOR.dom.element(this);
			CKelem.unselectable();
		});
	}
}
