CKEDITOR.plugins.add('rte-paste',
{
	htmlBeforePaste: '',

	getHtml: function() {
		return RTE.instance.document.getBody().getHtml();
	},

	track: function(ev) {
		RTE.track('paste', ev);
	},

	init: function(editor) {
		var self = this;

		// fire on each mode switch, setup event handler for wysiwyg mode only
		editor.on('dataReady', function(ev) {
			// only care when in wysiwyg mode
			if (editor.mode != 'wysiwyg') {
				return;
			}

			// @see clipboard CK core plugin
			var body = this.document.getBody();

			body.on('beforepaste', function(ev) {
				// store HTML before paste
				self.htmlBeforePaste = self.getHtml();

				// handle pasted HTML (mainly for tracking stuff)
				setTimeout(function() {self.handlePaste.call(self, editor)}, 250);
			});
		});
	},

	// get pasted HTML
	handlePaste: function(editor) {
		RTE.log('paste detected');

		// get HTML after paste
		var newHTML = this.getHtml();

		// regenerate pasted placeholder / image
		RTE.instance.fire('wysiwygModeReady');

		// we have HTML before and after the paste -> generate 'diff'
		var diff = this.diff(this.htmlBeforePaste, newHTML);
		if (typeof diff != 'object' || typeof diff.pasted != 'string') {
			return;
		}

		var pasted = diff.pasted;

		// try to get instance data (city ID and RTE instance ID)
		var matches = pasted.match(/_rte_instance="([a-z0-9-]+)"/);
		if (matches) {
			var instanceId = matches[1];
			if (instanceId == RTE.instanceId) {
				// pasted content from the same editor instance
				this.track('inside');
			}
			else {
				// check paste "source" city ID
				var cityId = parseInt( instanceId.split('-').shift() );
				if ( cityId != parseInt(wgCityId) ) {
					// pasted from different wiki
					this.track('anotherWiki');
				}
				else {
					// pasted content from different editor instance
					this.track('outside');
				}
			}
		}
		else {
			this.track('plainText');
		}

		// double single line breaks (<br />) - RT #38978
		if (typeof diff.pasted == 'string') {
			if ((/<br>/).test(diff.pasted)) {
				RTE.log('paste: detected <br> in pasted content');

				// let's replace <br>
				var html = diff['new'].replace(/([^>])<br>/g, '$1<br /><br />');
				editor.setData(html);
			}
		}
	},

	// performs quick diff between two strings (original and one with pasted content)
	// and returns pasted content
	// example: RTE.paste.diff('<br/><b>', '<br/><foo><b>') => <foo>
	// example: RTE.paste.diff('<br/><span><b>', '<br/><foo><b>') => <foo>
	diff: function(o, n) {
		// speed-up
		if (o == n) {
			return false;
		}

		var lenDiff = o.length - n.length;
		var idx = {start: 0, end: n.length - 1};

		// search for prefix and suffix common for old and new string
		while (o.charAt(idx.start) == n.charAt(idx.start)) {
			if (idx.start >= o.length) {
				return false;
			}
			idx.start++;
		}

		while (o.charAt(idx.end+lenDiff) == n.charAt(idx.end)) {
			if (idx.end <= idx.start) {
				return false;
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

		return {pasted: pasted, prefix: prefix, suffix: suffix, 'new': n, 'old': o, 'start': idx.start, 'end': idx.end};
	}
});
