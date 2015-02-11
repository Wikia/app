/**
 * Simple script to queue run of WikiTextSyntaxHighlighter for source mode editor
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

require(['wikia.window', 'jquery', 'wikia.log'], function(window, $) {
	'use strict';

	var WE = window.WikiaEditor = window.WikiaEditor || (new window.Observable());

	WE.plugins.syntaxhighlighterqueueinit = $.createClass(WE.plugin, {

		init: function () {
			this.editor.on('mode', this.proxy(this.initSyntaxHighlighting));
			this.editor.on('editorReady', this.proxy(this.initSyntaxHighlighting));
		},

		initConfig: function () {
			var config;

			if (window.wgIsDarkTheme) {
				config = this.initDarkThemeColors();
			} else {
				config = this.initLightThemeColors();
			}

			return config;
		},

		initSyntaxHighlighting: function () {
			if (this.editor.mode === 'source') {
				var textarea = this.editor.getEditbox()[0],
					config = this.initConfig();
				require(['WikiTextSyntaxHighlighter'], function (WikiTextSyntaxHighlighter) {
					WikiTextSyntaxHighlighter.init(textarea, config);
				});
			}
		},

		initDarkThemeColors: function() {
			return {
				boldOrItalicColor: '#373959',
				commentColor: '#4d1a19',
				entityColor: '#474d23',
				externalLinkColor: '#244d491',
				headingColor: '#373959',
				hrColor: '#373959',
				listOrIndentColor: '#4d1a19',
				parameterColor: '#66331e',
				signatureColor: '#66331e',
				tagColor: '#662946',
				tableColor: '#806e38',
				templateColor: '#806e38',
				wikilinkColor: '#2e6c99'
			};
		},

		initLightThemeColors: function() {
			return {
				boldOrItalicColor: '#e8e9ff',
				commentColor: '#ffb8b6',
				entityColor: '#c5cf86',
				externalLinkColor: '#97d8d2',
				headingColor: '#e8e9ff',
				hrColor: '#e8e9ff',
				listOrIndentColor: '#ffb8b6',
				parameterColor: '#ffb692',
				signatureColor: '#ffb692',
				tagColor: '#ffc0e8',
				tableColor: '#ecddb1',
				templateColor: '#ecddb1',
				wikilinkColor: '#b0e8ff'
			};
		}
	});
});
