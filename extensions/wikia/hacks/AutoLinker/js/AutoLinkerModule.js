/**
 * Example pages:
 *  - http://futurama.macbre.wikia-dev.com/index.php?title=Morbo&action=edit
 *  - http://futurama.macbre.wikia-dev.com/index.php?title=Hubert_J._Farnsworth&action=edit
 *  - http://futurama.macbre.wikia-dev.com/index.php?title=Bender_Bending_Rodr%C3%ADguez&action=edit
 *  - http://muppet.macbre.wikia-dev.com/index.php?title=Sesame_Street&action=edit
 *  - http://muppet.macbre.wikia-dev.com/index.php?title=Kermit_the_Frog&action=edit
 *  - http://starwars.macbre.wikia-dev.com/index.php?title=Coruscant&action=edit&section=1
 *  - http://starwars.macbre.wikia-dev.com/index.php?title=New_Republic&action=edit&section=1
 */

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

		// module's button and status bar
		button: false,
		statusBar: false,

		// regular expression for matching pages to link
		regexp: false,
		separators: '\\s!"#$%&\\(\\)\\+,\\-.\\/:;<=>\\?\\@\\[\\]',

		nodeRunner: false,

		afterRender: function() {
			var self = this;
			this.el.text(this.editor.msg('modules-autolinker-loading'));

			// fetch list of pages
			$.nirvana.getJson('AutoLinkerController', 'getPagesList', this.proxy(this.onDataReceived));
		},

		onDataReceived: function(data) {
			if (data && data.count) {
				this.regexp = new RegExp('(^|[' + this.separators + '])(' + data.regexp + ')($|[' + this.separators + '])', 'g');

				$().log(this.regexp.toString(), 'Autolinker');
				$().log('received list of ' + data.count + ' page(s)', 'Autolinker');

				// show a button to perform auto-linking
				this.el.html(
					'<button>' + this.editor.msg('modules-autolinker-button') + '</button>' +
					'<p style="margin: 1em 0"></p>'
				);

				this.button = this.el.children('button');
				this.button.bind('click', this.proxy(this.onPerformLinking));

				this.statusBar = this.el.children('p');

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

			this.button.prop('disabled', true);

			// node runner works on CKEDITOR nodes
			var editbox = this.editor.ck.document.getBody(),
				// count links created
				linksCreated = 0,
				// pages which should not be linked (also used to avoid duplicated links creation)
				blacklist = {},
				// stack of linked pages to be shown to the user
				pagesLinked = [];

			// don't link to the page we're editing
			blacklist[wgPageName.replace(/_/g, ' ')] = 1;

			// blacklist existing links (exclude interwiki links)
			var existingLinks = this.getLinks('[data-rte-meta*="internal"]').not('.extiw');

			existingLinks.each(function() {
				blacklist[this.title] = 1;
			});

			// mark undo point
			this.editor.ck.fire('saveSnapshot');

			// scan text nodes in the article and perform linking
			this.nodeRunner.walkTextNodes(editbox, this.proxy(function(node) {
				var content = node.getText();

				if (this.regexp.test(content)) {
					var newNode = new CKEDITOR.dom.element('span'),
						newContent = content.replace(
							this.regexp,
							function(match, prefix, pageName, suffix) {
								// check the blacklist
								if (blacklist[pageName]) {
									return match;
								}

								$().log(pageName, 'Autolinker - link added');

								var href = window.wgArticlePath.replace('$1', pageName.replace(/ /g, '_')),
									dataAttr = 'data-rte-meta="' + encodeURIComponent(JSON.stringify({
										type: 'internal',
										link: pageName
									})) + '"';

								// register links
								blacklist[pageName] = 1;
								pagesLinked.push(pageName);
								linksCreated++;

								return prefix +
									'<a class="autolinker" title="' + pageName + '" href="' + href + '" ' + dataAttr + '>' + pageName + '</a>' +
									suffix;
							}
						);

					// and replace current node with the one with link
					newNode.setHtml(newContent);
					newNode.replace(node);
				}
			}));

			// animate autolinker links
			var links = this.getLinks('a.autolinker');

			links.
				hide().
				css('border-bottom', 'double 3px').
				fadeIn({queue: true}).
				fadeOut({queue: true}).
				fadeIn({queue: true});

			this.button.prop('disabled', false);

			this.statusBar.hide().
				html(this.editor.msg('modules-autolinker-completed', linksCreated, pagesLinked.join(', '))).
				fadeIn('slow');

			$().log(linksCreated + ' replacement(s) performed', 'Autolinker');

			// mark undo point
			setTimeout(this.proxy(function() {
				this.editor.ck.fire('saveSnapshot');
			}), 750);
		},

		// get all links from the editor and apply additional filtering
		getLinks: function(filter) {
			var editbox = this.editor.ck.document.getBody();
			return $(editbox.$).find('a').filter(filter);
		}
	});

	// register additional module
	WE.on('wikiaeditorspaceslayout', function(element, layout, data) {
		if (layout && layout.rail) {
			layout.rail.push('Autolinker');
		}
	});

})(this);
