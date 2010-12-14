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

		// toolbar tracking

		// tracking for CK toolbar buttons
		editor.on('buttonClick', function(ev) {
			var buttonClicked = ev.data.button;
			//RTE.log(buttonClicked);

			RTE.track('toolbar', buttonClicked.command);
		});

		// tracking for CK toolbar rich combos (dropdowns)
		editor.on('panelShow', function(ev) {
			var me = ev.data.me;
			//RTE.log(me);

			var id = me.trackingName || me.className.split('_').pop();

			// track combo panel open
			RTE.track('toolbar', id + 'Menu', 'open');
		});
		editor.on('panelClick', function(ev) {
			var me = ev.data.me;
			var value = ev.data.value;
			//RTE.log([me, value]);

			var id = me.trackingName || me.className.split('_').pop();

			// for templates dropdown
			if (id == 'template') {
				if (value == '--other--') {
					value = 'other';
				}
				else {
					var panelItems = me._.items;
					var idx = 0;

					// iterate thru panel items and find index chosen template
					for (tpl in panelItems) {
						idx++;
						if (tpl == value) {
							value = idx;
							break;
						}
					}
				}
			}

			// track combo panel open
			RTE.track('toolbar', id + 'Menu', value);
		});

		// tracking for MW toolbar buttons
		editor.on('instanceReady', function() {
			$('#mw-toolbar').bind('click', function(ev) {
				var target = $(ev.target).filter('img');
				//RTE.log(target);

				if (!target.exists()) {
					return;
				}

				var id = target.attr('id').split('-').pop();
				RTE.track('source', id);
			});
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
			// 10900 => 1.9.0 (3.0.x line)
			// 10902 => 1.9.2 (3.6.x line)
			var version = parseInt(env.version / 10000) + '.' + parseInt(env.version / 100 % 100) + '.' + (env.version % 100);
		}
		else {
			var version = env.version;
		}

		// and finally send it to GA
		RTE.track('browser', eventName, name, version);
	}
});
