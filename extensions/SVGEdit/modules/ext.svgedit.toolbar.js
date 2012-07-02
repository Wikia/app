/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$( document ).ready( function() {

	var safeFilename = function(str) {
		// hack hack
		return str.replace(/[^A-Za-z0-9- ]/, '').replace(/[\s_]+/, ' ');
	};
	var handyDate = function() {
		var now = new Date();
		var pad2 = function(n) {
			if (n < 10) {
				return '0' + n;
			} else {
				return new String(n);
			}
		}
		return now.getUTCFullYear() +
			'-' +
			pad2(now.getUTCMonth()) +
			'-' +
			pad2(now.getUTCDay()) +
			' ' +
			pad2(now.getUTCHours()) +
			'-' +
			pad2(now.getUTCMinutes()) +
			'-' +
			pad2(now.getUTCSeconds());
	};
	var callback = function(context) {
		var filename = safeFilename(wgTitle) + ' drawing ' + handyDate() + '.svg';
		var form = context.$ui.closest('form');
		mediaWiki.svgedit.open({
			filename: filename,
			replace: form[0],
			onclose: function(filename) {
				if (filename) {
					// Saved! Insert a [[File:foo]]
					context.$textarea.textSelection('encapsulateSelection', {
						'pre': '[[File:',
						'peri': filename,
						'post': ']]',
						'replace': true
					});
				}
			}
		});
	};
	$( '#wpTextbox1' ).wikiEditor( 'addToToolbar', {
		'section': 'advanced',
		'group': 'insert',
		'tools': {
			'newsvg': {
				'labelMsg': 'svgedit-toolbar-insert',
				'type': 'button',
				'icon': wgExtensionAssetsPath + '/SVGEdit/modules/images/svgedit-toolbar-icon.png',
				'action': {
					/*
					'type': 'encapsulate',
					'options': {
						'pre': '[[File:',
						'periMsg': 'wikieditor-toolbar-tool-file-example',
						'post': "]]"
					}*/
					'type': 'callback',
					'execute': callback
				}
		}
	}});
});
