CKEDITOR.plugins.add('rte-track',
{
	init: function(editor) {
		var self = this;

		// track style applies
		editor.on('wysiwygModeReady', function() {
			editor.document.removeListener(self.trackApplyStyle);
			editor.document.on('applyStyle', self.trackApplyStyle);
		});

		// track context menu
		editor.on('contextMenuOnOpen', self.trackContextMenuOpen);
		editor.on('contextMenuOnClick', self.trackContextMenuItem);

		// track list creation
		editor.on('listCreated', self.trackListCreated);

		// track loading time
		editor.on('RTEready', function() {
			self.trackLoadTime(editor);
		});

		// track browser info (RT #37894)
		editor.on('RTEready', function() {
			self.trackBrowser('init');
		});

		$('#wpSave').click(function() {
			self.trackBrowser('save');
		});
	},

	trackApplyStyle: function(ev) {
		var style = ev.data.style;
		var remove = ev.data.remove;

		// only track when style is applied
		if (style && !remove) {
			RTE.track('toolbar', 'format', style);
		}
	},

	trackContextMenuOpen: function(ev) {
		RTE.track('contextMenu', 'open');
	},

	trackContextMenuItem: function(ev) {
		var name = ev.data.item.command;

		// group events which name starts with...
		var g, groups = ['cell', 'row', 'column'];

		for(g=0; g<groups.length; g++) {
			var group = groups[g];

			if (name.indexOf(group) == 0) {
				RTE.track('contextMenu', 'action', group, name);
				return;
			}
		}

		RTE.track('contextMenu', 'action', name);
	},

	trackListCreated: function(ev) {
		var listNode = ev.data.listNode;
		var listType = (listNode.getName() == 'ul') ? 'unorderedList' : 'orderedList';

		RTE.track('format', listType);
	},

	trackLoadTime: function(editor) {
		// load time in ms (3.141 s will be reported as .../3100)
		var trackingLoadTime = parseInt(RTE.loadTime * 10) * 100;

		// tracking
		switch (editor.mode) {
			case 'source':
				RTE.track('init', 'sourceMode', trackingLoadTime);

				// add edgecase name (if any)
				if (window.RTEEdgeCase) {
					RTE.track('init', 'edgecase',  window.RTEEdgeCase);
				}

				break;

			case 'wysiwyg':
				RTE.track('init', 'wysiwygMode', trackingLoadTime);
				break;
		}
	},

	// track browser data (name, version) - RT #37894
	trackBrowser: function(eventName) {
		var env = CKEDITOR.env;

		var name = (
			env.ie ? 'ie' :
			env.gecko ? 'gecko' :
			env.opera ? 'opera' :
			env.air ? 'air' :
			env.webkit ? 'webkit' :
			'unknown'
		);

		if (name == 'gecko') {
			// small version fix for Gecko browsers
			// 10900 => 1.9.0
			var version = Math.round(env.version / 10000) + '.' + (env.version / 100 % 100) + '.' + (env.version % 100);
		}
		else {
			var version = env.version;
		}

		// and finally send it to GA
		RTE.track('browser', eventName, name, version);
	}
});
