require(['jquery'], function ($) {
	'use strict';

	var articleContainer = null;
	var tooltip = null;
	var articleTitle = null;
	var ogImage = null;

	function init() {
		if (!window.getSelection) {
			return;
		}

		const ogImageMeta = document.head.querySelector('meta[property="og:image"]');

		articleContainer = document.getElementById('mw-content-text');
		articleTitle = document.querySelector('h1').innerText;
		ogImage = ogImageMeta ? ogImageMeta.content : '';

		window.document.addEventListener('mouseup', onMouseUp);
	}

	function onMouseUp() {
		setTimeout(function () {
			var selection = window.getSelection();
			var range = selection.getRangeAt(0);
			var rect = range.getBoundingClientRect();
			var parent = selection.anchorNode;
			var length = range.endOffset - range.startOffset;

			if (!parent || !articleContainer.contains(parent) || !length) {
				return;
			}

			renderTooltip(rect.x + rect.width / 2, rect.y + window.scrollY - 10, selection.toString());

			setTimeout(function () {
				window.addEventListener('click', onClick);
			}, 0);
		}, 0);
	}

	function renderTooltip(x, y, text) {
		if (!tooltip) {
			tooltip = document.createElement('a');
			tooltip.classList.add('feeds-article-selection-tooltip');
			tooltip.innerHTML = renderSvg() + "Ask a question";
		}

		tooltip.href = window.location.origin +
			'/f/?url=' + encodeURIComponent(window.location.href) +
			'&title=' + articleTitle +
			'&text=' + text +
			'&image=' + encodeURIComponent(ogImage);

		tooltip.style.top = y + 'px';
		tooltip.style.left = x + 'px';

		if (!document.body.contains(tooltip)) {
			document.body.appendChild(tooltip);
		}
	}

	function onClick(event) {
		if (tooltip && !tooltip.contains(event.target)) {
			document.body.removeChild(tooltip);
			window.removeEventListener('click', onClick);
		}
	}

	function renderSvg() {
		return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 12 12"><defs><path id="comment-tiny" d="M4.5 2c-.668 0-1.293.26-1.757.731A2.459 2.459 0 0 0 2 4.5c0 1.235.92 2.297 2.141 2.47A1 1 0 0 1 5 7.96v.626l1.293-1.293A.997.997 0 0 1 7 7h.5c.668 0 1.293-.26 1.757-.731.483-.476.743-1.1.743-1.769C10 3.122 8.878 2 7.5 2h-3zM4 12a1 1 0 0 1-1-1V8.739A4.52 4.52 0 0 1 0 4.5c0-1.208.472-2.339 1.329-3.183A4.424 4.424 0 0 1 4.5 0h3C9.981 0 12 2.019 12 4.5a4.432 4.432 0 0 1-1.329 3.183A4.424 4.424 0 0 1 7.5 9h-.086l-2.707 2.707A1 1 0 0 1 4 12z"/></defs><use fill-rule="evenodd" xlink:href="#comment-tiny"/></svg>';
	}

	init();
});
