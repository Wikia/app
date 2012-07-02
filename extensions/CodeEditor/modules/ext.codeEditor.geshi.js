/**
 * This is experimental and does not yet actually save anything back.
 * Has to be manually enabled.
 * Needs some code de-dup with the full-page JS/CSS page editing.
 */

$(function() {
	var $sources = $('.mw-geshi');
	if ($sources.length > 0) {
		var setupEditor = function($div) {
			var $link = $('<a>')
				.text(mediaWiki.msg('editsection'))
				.attr('href', '#')
				.attr('title', 'Edit this code section')
				.click(function(event) {
					openEditor($div)
					event.preventDefault();
				});
			var $edit = $('<span>')
				.css('float', 'right')
				.append('[')
				.append($link)
				.append(']'); // @fixme use the editsection-brackets msg
			$div.prepend($edit);
		};
		var openEditor = function($div) {
			var $main = $div.find('div'),
				geshiLang = null,
				matches = /(?:^| )source-([a-z0-9_-]+)/.exec($main.attr('class'));
			if (matches) {
				geshiLang = matches[1];
			}
			mediaWiki.loader.using('ext.codeEditor.ace.modes', function() {
				// @fixme de-duplicate
				var map = {
					c: 'c_cpp',
					cpp: 'c_cpp',
					clojure: 'clojure',
					csharp: 'csharp',
					css: 'css',
					coffeescript: 'coffee',
					groovy: 'groovy',
					html4strict: 'html',
					html5: 'html',
					java: 'java',
					java5: 'java',
					javascript: 'javascript',
					jquery: 'javascript',
					ocaml: 'ocaml',
					perl: 'perl',
					php: 'php',
					python: 'python',
					ruby: 'ruby',
					scala: 'scala',
					xml: 'xml'
				};
				

				// Disable some annoying commands
				var canon = require('pilot/canon');
				canon.removeCommand('replace');          // ctrl+R
				canon.removeCommand('transposeletters'); // ctrl+T
				canon.removeCommand('gotoline');         // ctrl+L

				var $container = $('<div>')
					.attr('style', 'top: 32px; left: 0px; right: 0px; bottom: 0px; border: 1px solid gray')
					.text($main.text()); // quick hack :D

				var $label = $('<label>').text('Source language: ');
				var $langDropDown = $('<select>');
				$.each(map, function(geshiLang, aceLang) {
					var $opt = $('<option>')
						.text(geshiLang)
						.val(geshiLang)
						.appendTo($langDropDown);
				});
				$langDropDown
					.val(geshiLang)
					.appendTo($label)
					.change(function(event) {
						setLanguage($(this).val());
					});
				var $save = $('<button>')
					.text(mediaWiki.msg('savearticle'))
					.click(function(event) {
						// horrible hack ;)
						var src = codeEditor.getSession().getValue();
						var tag = '<source lang="' + geshiLang + '">' + src + '</source>';
						
						$.ajax(wgScriptPath + '/api' + wgScriptExtension, {
							data: {
								action: 'parse',
								text: tag,
								format: 'json'
							},
							type: 'POST',
							success: function(data, xhr) {
								var $html = $(data.parse.text['*']);
								$div.replaceWith($html)
								setupEditor($html);


								closeEditor();
								event.preventDefault();
							}
						});
					});
				var $cancel = $('<button>')
					.text('Close').click(function(event) {
						$xcontainer.remove();
						$div.css('display', 'block');
						event.preventDefault();
					});
				var $controls = $('<div>')
					.append($label)
					.append($save)
					.append($cancel);
				var $xcontainer = $('<div style="position: relative"></div>')
					.append($controls)
					.append($container);
				$xcontainer.width($main.width())
						   .height($main.height() * 1.1 + 64 + 32);

				$div.css('display', 'none');
				$xcontainer.insertAfter($div);

				var codeEditor = ace.edit($container[0]);

				var setLanguage = function(lang) {
					geshiLang = lang;
					var aceLang = map[geshiLang];
					codeEditor.getSession().setMode(new (require("ace/mode/" + aceLang).Mode));
				};
				setLanguage(geshiLang);

				var closeEditor = function() {
					$xcontainer.remove();
					$div.css('display', 'block');
				};
			});
		};

		$sources.each(function(i, div) {
			var $div = $(div);
			setupEditor($div);
		});
	}
});
