(function(window){

	var WE = window.WikiaEditor;

	WE.modules.Autolinker = $.createClass(WE.modules.base, {
		modes: {
			wysiwyg: true
		},

		headerClass: 'autolinker',
		headerTextId: 'autolinker-title',

		template: '<div></div>',
		data: {},

		// list of page to link to
		pages: {},

		nodeRunner: false,

		afterRender: function() {
			var self = this;
			this.el.text(this.editor.msg('modules-autolinker-loading'));

			// fetch list of pages
			$.nirvana.getJson('AutoLinkerController', 'getPagesList', this.proxy(this.onDataReceived));
		},

		onDataReceived: function(data) {
			if (data && data.pages) {
				this.pages = data.pages;

				$().log('received list of ' + data.count + ' page(s)', 'Autolinker');

				// show a button to perform auto-linking
				this.el.html('<button>' + this.editor.msg('modules-autolinker-button') + '</button>');
				this.el.children('button').bind('click', this.proxy(this.onPerformLinking));

				// setup node runner
				this.nodeRunner = new CKEDITOR.nodeRunner();

				// don't link inside links and headings
				this.nodeRunner.isSkipped = function(node) {
					return !!node.$.nodeName.match(/a|h\d/i);
				};
			}
		},

		onPerformLinking: function(ev) {
			ev.preventDefault();

			$().log('performing auto linking...', 'Autolinker');

			// node runner works on CKEDITOR nodes
			var editbox = this.editor.ck.document.getBody(),
				replacements = 0,
				pageName;

			for (var p=0, len=this.pages.length; p < len; p++) {
				pageName = this.pages[p];

				// don't link to the current page
				if (pageName == window.wgPageName) {
					continue;
				}

				this.nodeRunner.walkTextNodes(editbox, this.proxy(function(node) {
					var content = node.getText();

					if (content.indexOf(pageName) > -1) {
						$().log('> ' + pageName);

						var newNode = new CKEDITOR.dom.element('span'),
							href = window.wgArticlePath.replace('$1', pageName.replace(' ', '_')),
							dataAttr = 'data-rte-meta="' + encodeURIComponent($.toJSON({
								type: 'internal',
								link: pageName
							})) + '"';

						var newContent = content.replace(
							pageName,
							'<a class="autolinker" href="' + href + '" ' + dataAttr + '>' + pageName + '</a>'
						);

						// add replace current node with the one with link
						newNode.setHtml(newContent);
						newNode.replace(node);

						replacements++;

						// TODO: don't the same link several times!
					}
				}));
			}

			// animate autolinker links
			var links = $(editbox.$).find('a.autolinker');

			links.
				hide().
				css('border-bottom', 'double 3px').
				fadeIn({queue: true}).
				fadeOut({queue: true}).
				fadeIn({queue: true});

			$().log(replacements + ' replacement(s) performed', 'Autolinker');
		}
	});

	// register additional module
	WE.on('wikiaeditorspaceslayout', function(element, layout, data) {
		if (layout && layout.rail) {
			layout.rail.push('Autolinker');
		}
	});

})(this);