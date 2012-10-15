/**
 * SVGEdit extension: edit widget fun
 * @copyright 2010-2011 Brion Vibber <brion@pobox.com>
 */

(function($, mw) {

mw.svgedit = {
	isOpen: false,

	init: function() {

	},

	/**
	 * Open the SVG editor.
	 * Will have no effect if the editor is already open.
	 *
	 * @param options: object
	 *           filename: wiki name of existing file to initially load
	 *           replace: selector or DOM node to replace the editor with while it runs
	 *           onclose: function(filename) callback; if saved, new file's on-wiki name is passed otherwise null
	 *           leaveopen: pass true to leave the editor goodies up after successful save: it's caller's responsibility to tidy up the page UI state
	 */
	open: function(options) {
		if (mw.svgedit.isOpen) {
			return false;
		}
		mw.svgedit.isOpen = true;

		if ("filename" in options) {
			// Get some basic info on the image before we go barrelling in...
			mwSVG.fetchInfo(options.filename, function(imageinfo) {
				mw.svgedit.openEditor(options, imageinfo);
			});
		} else {
			mw.svgedit.openEditor(options, {});
		}
	},

	/**
	 * @access private
	 */
	openEditor: function(options, imageinfo) {
		var url = wgSVGEditEditor ||
			(wgScriptPath + '/extensions/SVGEdit/svg-edit/svg-editor.html');

		var filename = options.filename || null;
		var replace = options.replace || null;
		var onclose = options.onclose || null;
		var leaveopen = options.leaveopen || false;

		var svgedit = null; // to be filled out when iframe is loaded
		var saved = false;

		var origWidth = parseInt(imageinfo.width) || 640;
		var origHeight = parseInt(imageinfo.height) || 480;
		if (origWidth && origHeight) {
			// Initialize the canvas dimensions to the image's defined size...
			url += '?dimensions=' + origWidth + ',' + origHeight;
		}

		var preferredHeight = origHeight + 180; // leave space for toolbars and UI inside the iframe
		var windowHeight = $(window).height() - 40; // leave space for our toolbar outside the iframe
		var minHeight = Math.min(windowHeight, preferredHeight);
		var initHeight = Math.max(minHeight, minHeight);

		// @fixme
		var orig = $(replace);

		orig.hide();
		orig.before('<div id="mw-svgedit">' +
					'<div id="mw-svgedit-toolbar">' +
						'<label id="mw-svgedit-summary-label"></label> ' +
						'<input id="mw-svgedit-summary" size="60" /> ' +
						'<button id="mw-svgedit-save"></button> ' +
						'<button id="mw-svgedit-close"></button>' +
					'</div>' +
					'<div id="mw-svgedit-frame-holder" style="width: 100%; height: ' + initHeight + 'px">' +
					'<iframe id="mw-svgedit-frame" width="100%" height="100%"></iframe>' +
					'</div>' +
					'</div>');

		var frame = $('#mw-svgedit-frame');
		$('#mw-svgedit-frame-holder').resizable({
			handles: 's',
			helper: 'mw-svgedit-resize',
			minHeight: minHeight
		});

		$('body').append('<div id="mw-svgedit-spinner"></div>');
		var spinner = $('#mw-svgedit-spinner');

		/**
		 * Close the editor when we're ready.
		 * Alert the caller's callback if provided.
		 */
		var closeEditor = function() {
			// Always remove the frame; not sure how to shut it up
			// with its beforeunload handler.
			$('#mw-svgedit-frame').replaceWith('<div style="height: ' + initHeight + 'px"></div>');
			if (!(saved && leaveopen)) {
				// Clean up editor UI unless we've been asked to leave
				// things open for caller after successful save.
				$('#mw-svgedit').remove();
				spinner.remove();
				orig.show();
				mw.svgedit.isOpen = false;
			}
			if (onclose) {
				onclose(saved ? filename : null);
			}
		};

		var spinnerOn = function() {
			$('#mw-svgedit-summary').attr('disabled', 'disabled');
			$('#mw-svgedit-save').attr('disabled', 'disabled');
			var offset = frame.offset();
			spinner
				.css('left', offset.left)
				.css('top', offset.top)
				.width(frame.width())
				.height(frame.height())
				.show();
		};
		var spinnerOff = function() {
			$('#mw-svgedit-summary').removeAttr('disabled');
			$('#mw-svgedit-save').removeAttr('disabled');
			spinner.hide();
		};

		$('#mw-svgedit-summary-label')
			.text(mediaWiki.msg('svgedit-summary-label'));

		$('#mw-svgedit-summary')
			.val(mediaWiki.msg('svgedit-summary-default') + ' ');

		$('#mw-svgedit-save')
			.text(mediaWiki.msg('svgedit-editor-save-close'))
			.click(function() {
				spinnerOn();
				svgedit.getSvgString()(function(svg) {
					var comment = $('#mw-svgedit-summary').val();
					mwSVG.saveSVG(filename, svg, comment, function(data, textStatus, xhr) {
						if (data.upload && data.upload.result == "Success") {
							saved = true;
							closeEditor();
						} else if (data.error && data.error.info) {
							spinnerOff();
							alert('Error saving file: ' + data.error.info);
						} else {
							spinnerOff();
							alert('Possible error saving file...');
						}
					});
				});
			});

		$('#mw-svgedit-close')
			.text(mediaWiki.msg('svgedit-editor-close'))
			.click(function() {
				closeEditor();
			});

		// Ok, let's load up the goodies!
		spinnerOn();
		$('#mw-svgedit-frame')
			.load(function() {
				svgedit = new embedded_svg_edit(this);

				// Load up the original file!
				if (filename && imageinfo && imageinfo.url) {
					var open = function(xmlSource) {
						svgedit.setSvgString(xmlSource)(function() {
							spinnerOff();
						});
					};

					var loadApiProxy = function() {
						mwSVG.fetchSVG(filename, function(xmlSource, textStatus, xhr) {
							open(xmlSource);
						}, function() {
							alert('failllll');
						});
					};

					mwSVG.fetchFile(imageinfo.url, function(xmlSource, textStatus, xhr) {
						if (xmlSource == '' && xhr.responseXML == null) {
							loadApiProxy();
						}
						open(xmlSource);
					}, function() {
						loadApiProxy();
					});
				} else {
					spinnerOff();
				}
			})
			.attr('src', url);

		// Check if the editor is fully in view; if not, scroll to the top.
		var win = $(window);
		var scrollTop = win.scrollTop();
		var scrollBottom = scrollTop + windowHeight;
		var top = $('#mw-svgedit').offset().top;
		var bottom = top + $('#mw-svgedit').height();
		if (top < scrollTop || bottom > scrollBottom) {
			win.scrollTop(top);
		}
	}
};

})(jQuery, mediaWiki);
