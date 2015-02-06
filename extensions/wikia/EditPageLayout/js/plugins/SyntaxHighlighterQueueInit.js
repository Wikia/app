/**
 * Simple script to queue run of WikiTextSyntaxHighlighter for source mode editor
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

(function(window, $) {
	'use strict';

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.syntaxhighlighterqueueinit = $.createClass(WE.plugin, {

		init: function () {

			this.editor.on('editorReady', function () {
				if (this.mode === 'source') {
					var textarea = this.getEditbox()[0];
					require(['WikiTextSyntaxHighlighter'], function (WikiTextSyntaxHighlighter) {
						WikiTextSyntaxHighlighter.init(textarea);
					});
				}
			});
		}
	});
})(this, jQuery);
