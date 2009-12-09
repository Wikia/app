CKEDITOR.plugins.add('rte-paste',
{
	init: function(editor) {
		// storage for paste data
		RTE.paste = {
			'attempts': 0,
			'lock': false,
			'htmlBeforePaste': false
		};

		// detect pastes
		editor.on('beforePaste', function(ev) {
			RTE.log('beforePaste fired');

			// only care when in wysiwyg mode
			if (editor.mode != 'wysiwyg') {
				return;
			}

			// break if paste is alread in progess
			if (RTE.paste.lock) {
				RTE.log('paste is in progress');
				ev.cancel();
				return;
			}

			RTE.log('paste has been detected');

			// store current HTML - without pasted content
			RTE.paste.htmlBeforePaste = RTE.instance.document.getBody().getHtml();

			// set lock
			RTE.paste.lock = true;

			// reset handle attemps counter
			RTE.paste.attempts = 0;

			// handle pasted HTML
			setTimeout(RTE.paste.handlePaste, 10);
		});

		RTE.paste.handlePaste = function() {
			RTE.paste.attempts++;

			// get current HTML - with pasted content
			var newHTML = RTE.instance.document.getBody().getHtml();

			// check whether paste has ended
			if (newHTML == RTE.paste.htmlBeforePaste) {
				if (RTE.paste.attempts < 75) {
					// try again
					setTimeout(RTE.paste.handlePaste, 10);
				} else {
					// unlock
					// TODO: log it since it should never happen
					RTE.paste.lock = false;
					RTE.log('paste handling timeout');
				}
				return;
			}

			RTE.log('handlePaste successfully fired');

			// required to restore cursor position
			var selection = RTE.instance.getSelection();
			var bookmarks = selection.createBookmarks2();

			// we have HTML before and after the paste -> generate 'diff'
			var diff = RTE.paste.diff(RTE.paste.htmlBeforePaste, newHTML);

			// add _rte_pasted attribute to pasted nodes
			diff.pasted = diff.pasted.replace(/\<(\w+)/g, '<$1 _rte_pasted="true"');

			RTE.log(diff);

			// update HTML in editor
			RTE.getEditor().html('');
			RTE.instance.insertHtml(diff.prefix + diff.pasted + diff.suffix);

			// restore cursor position
			selection.selectBookmarks(bookmarks);

			// unlock
			RTE.paste.lock = false;
			RTE.paste.htmlBeforePaste = false;
		};

		// performs quick diff between two strings (original and one with pasted content)
		// and returns pasted content
		// example: RTE.paste.diff('<br/><b>', '<br/><foo><b>') => <foo>
		// example: RTE.paste.diff('<br/><span><b>', '<br/><foo><b>') => <foo>
		RTE.paste.diff = function(o, n) {
			// speed-up
			if (o == n) {
				return null;
			}

			var lenDiff = o.length - n.length;
			var idx = {start: 0, end: n.length - 1};

			// search for prefix and suffix common for old and new string
			while (o.charAt(idx.start) == n.charAt(idx.start)) {
				if (idx.start >= o.length) {
					return null;
				}
				idx.start++;
			}

			while (o.charAt(idx.end+lenDiff) == n.charAt(idx.end)) {
				if (idx.end <= idx.start) {
					return null;
				}
				idx.end--;
			}

			// get unchanged parts at the beginning and at the end of diff
			var prefix = n.substring(0, idx.start+1);
			var suffix = n.substring(idx.end, n.length);

			// fix HTML by finding closing > and opening < in suffix and prefix respectively
			if (/<[^>]*$/.test(prefix)) {
				// go to last < in prefix
				idx.start = prefix.lastIndexOf('<');
			}

			if (/^[^<]*>/.test(suffix)) {
				// go to first > in suffix
				idx.end += suffix.indexOf('>') + 1;
			}

			// get changed fragment
			var pasted = n.substring(idx.start, idx.end + 1);

			// HTML before and after pasted fragment
			prefix = n.substring(0, idx.start);
			suffix = n.substring(idx.end + 1, n.length);

			return {pasted: pasted, prefix: prefix, suffix: suffix, 'new': n, 'old': o};
		}
	}
});
