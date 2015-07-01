define('editpage.event.helper', [], function(){
	'use strict';

	// get editor's content (either wikitext or HTML)
	// and call provided callback with wikitext as its parameter
	function getContent(callback) {
		var editor = typeof RTE == 'object' ? RTE.getInstance() : false, mode = editor ? editor.mode : 'mw';

		callback = callback || function () {};

		switch (mode) {
			case 'mw':
				callback($('#wpTextbox1').val());
				return;
			case 'source':
			case 'wysiwyg':
				callback(editor.getData());
				return;
		}
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

	function getCategories() {
		return $('#categories');
	}

	return {
		ajax: ajax,
		getCategories: getCategories,
		getContent: getContent
	};
});
