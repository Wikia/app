/**
 * Created by lukasz on 07.07.14.
 */
(function(){

	console.log('share');

	var savedText = null; // Variable to save the text

	function saveSelection() {
		if (window.getSelection) {
			var sel = window.getSelection();
			if (sel.getRangeAt && sel.rangeCount) {
				return sel.getRangeAt(0);
			}
		} else if (document.selection && document.selection.createRange) {
			return document.selection.createRange();
		}
		return null;
	}

	function restoreSelection(range) {
		if (range) {
			if (window.getSelection) {
				var sel = window.getSelection();
				sel.removeAllRanges();
				sel.addRange(range);
			} else if (document.selection && range.select) {
				range.select();
			}
		}
	}

	var btnWrap = document.getElementById('share-button'),
		btnShare = btnWrap.children[0];

	document.onmouseup = function(e) {

		savedText = saveSelection(); // Save selection on mouse-up

		setTimeout(function() {

			var isEmpty = savedText.toString().length === 0; // Check selection text length

			// set sharing button position
			btnWrap.style.top = (isEmpty ? -9999 : e.pageY) + 'px';
			btnWrap.style.left = (isEmpty ? -9999 : e.pageX) + 'px';

		}, 10);

	};

	btnShare.onmousedown = function(e) {

		if (!savedText) return;

		window.open('https://twitter.com/intent/tweet?text=' + savedText, 'shareWindow', 'width=300,height=150,top=50,left=50'); // Insert the selected text into sharing URL
		restoreSelection(savedText); // select back the old selected text

		// hide if we are done
		setTimeout(function() {
			btnWrap.style.top = '-9999px';
			btnWrap.style.left = '-9999px';
		}, 1000);

		return false;

	};
})();
