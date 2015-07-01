define('editpage.event.helper', ['wikia.window'], function(window, ace){
	'use strict';

	// get editor's content (either wikitext or HTML)
	// and call provided callback with wikitext as its parameter
	function getContent() {
		var dfd = new $.Deferred(),
			editor = typeof RTE == 'object' ? RTE.getInstance() : false, mode = editor ? editor.mode : 'mw',
			content = '';

		if (window.wgEnableCodePageEditor) {
			require(['wikia.ace.editor'], function(ace){
				content = ace.getContent();
				dfd.resolve(content);
			});
		} else {
			switch (mode) {
				case 'mw':
					content = $('#wpTextbox1').val();
					break;
				case 'source':
				case 'wysiwyg':
					content = editor.getData();
					break;
			}

			dfd.resolve(content);
		}

		return dfd.promise();
	}

	// send AJAX request
	function ajax(method, params, callback, skin) {
		var editor = typeof RTE == 'object' ? RTE.getInstance() : false;

		params = $.extend({
			page: window.wgEditPageClass ? window.wgEditPageClass : "",
			method: method,
			mode: editor.mode
		}, params);

		var url = window.wgEditPageHandler.replace('$1', encodeURIComponent(window.wgEditedTitle));

		if (skin) {
			url += '&type=full&skin=' + encodeURIComponent(skin);
		}

		return $.post(url, params, function (data) {
			if (typeof callback == 'function') {
				callback(data);
			}
		}, 'json');
	}

	// Returns the width of the browsers scrollbar
	function getScrollbarWidth() {
		var inner = document.createElement('p'),
			outer = document.createElement('div'),
			w1, w2;

		inner.style.width = '100%';
		inner.style.height = '100px';

		outer.style.position = 'absolute';
		outer.style.top = '0px';
		outer.style.left = '0px';
		outer.style.visibility = 'hidden';
		outer.style.width = '100px';
		outer.style.height = '100px';
		outer.style.overflow = 'hidden';
		outer.appendChild(inner);

		document.body.appendChild(outer);

		w1 = inner.offsetWidth;
		outer.style.overflow = 'scroll';
		w2 = inner.offsetWidth;

		if (w1 === w2) {
			w2 = outer.clientWidth;
		}

		document.body.removeChild(outer);

		return (w1 - w2);
	}

	function getCategories() {
		return $('#categories');
	}

	return {
		ajax: ajax,
		getCategories: getCategories,
		getContent: getContent,
		getScrollbarWidth: getScrollbarWidth
	};
});
