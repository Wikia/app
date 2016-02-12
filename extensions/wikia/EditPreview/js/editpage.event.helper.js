define('editpage.event.helper', ['wikia.window'], function (window, ace) {
	'use strict';

	// get editor's content (either wikitext or HTML)
	// and call provided callback with wikitext as its parameter
	function getContent() {
		var dfd = new $.Deferred(),
			editor = typeof RTE == 'object' ? RTE.getInstance() : false,
			mode = editor ? editor.mode : 'mw',
			content = '';

		if (window.wgEnableCodePageEditor) {
			require(['wikia.ace.editor'], function (ace) {
				content = ace.getContent();
				dfd.resolve(content, mode);
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

			dfd.resolve(content, mode);
		}

		return dfd.promise();
	}

	// send AJAX request
	function ajax(method, params, callback, skin) {
		var editor = typeof RTE == 'object' ? RTE.getInstance() : false;

		params = $.extend({
			page: window.wgEditPageClass ? window.wgEditPageClass : '',
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

	/**
	 * Allows for sending POST requests from an iframe.
	 * Creates an iframe with form with id and target marked with timestamp.
	 *
	 * @param {string} url
	 * @returns {IFrameForm}
	 */
	function IFrameForm(url) {
		if (!this instanceof IFrameForm) {
			return new IFrameForm(url);
		}

		this.time = new Date().getTime();
		this.form = $('<form></form>')
			.attr('action', url)
			.attr('style', 'display:none')
			.attr('target', 'iframe' + this.time)
			.attr('method', 'post')
			.attr('id', 'form' + this.time)
			.attr('name', 'form' + this.time);

		this.iframe = $('<iframe></iframe>')
			.attr('data-time', this.time)
			.attr('id', 'iframe' + this.time)
			.attr('name', 'iframe' + this.time);

		// wrapper with special styling is required to prevent iframe auto-resizing on iOS Safari
		this.iframeWrapper = $('<div></div>')
			.attr('class', 'mobile-preview');

		this.addParameter = function (parameter, value) {
			$('<input type=\'hidden\' />')
				.attr('name', parameter)
				.attr('value', value)
				.appendTo(this.form);
		};

		this.send = function (frameRoot, callback) {
			var $frameRoot = $(frameRoot);

			this.iframeWrapper.append(this.iframe);
			$frameRoot
				.append(this.iframeWrapper)
				.append(this.form);

			this.iframe.load((function () {
				$('#form' + this.time).remove();
				callback();
			}).bind(this));

			this.form.submit();
		};
	}

	return {
		ajax: ajax,
		getCategories: getCategories,
		getContent: getContent,
		getScrollbarWidth: getScrollbarWidth,
		IFrameForm: IFrameForm
	};
});
