require(['jquery'], function ($) {
	'use strict';

	var articleContainer = null;
	var tooltip = null;
	var articleTitle = null;

	function init() {
		if (!window.getSelection) {
			return;
		}

		articleContainer = document.getElementById('mw-content-text');
		articleTitle = document.querySelector('h1').innerText;

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

			renderTooltip(rect.x + rect.width / 2, rect.y + window.scrollY, parent.wholeText);

			setTimeout(function () {
				window.addEventListener('click', onClick);
			}, 0);
		}, 0);
	}

	function renderTooltip(x, y, text) {
		if (!tooltip) {
			tooltip = document.createElement('a');
			tooltip.classList.add('feeds-article-selection-tooltip');
			tooltip.innerText = "Twoja stara jeździ wózkiem bez kółek.";
		}

		tooltip.href = window.location.origin +
			'/f?url=' + encodeURIComponent(window.location.href) +
			'&title=' + articleTitle +
			'&text=' + text;

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

	init();
});
