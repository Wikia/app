/**
 * SVGEdit extension: add 'Edit drawing' popup button for inline image usages (experimental)
 * @copyright 2011 Brion Vibber <brion@pobox.com>
 */

(function($, mw) {

$(document).ready(function() {
	// We probably should check http://www.w3.org/TR/SVG11/feature#SVG-dynamic
	// but Firefox is missing a couple random subfeatures.
	//
	// Chrome, Safari, Opera, and IE 9 preview all return true for it!
	//
	if (!document.implementation.hasFeature('http://www.w3.org/TR/SVG11/feature#Shape', '1.1')) {
		return;
	}
	var trigger = function(link) {
		// hackkkkkkk
		var url = $(link).attr('href');
		var match = url.match(/\/[^?\/:]+:([^?\/]+)(?:\?|$)/);
		var title = match[1];
		mw.svgedit.open({
			filename: title,
			replace: link,
			onclose: function(filename) {
				if (filename) {
					// Saved! Refresh parent window...
					window.location.reload(true);
				}
			},
			leaveopen: true // Our reload will get rid of the UI.
		})
	};

	function setupImage(link) {
		var button = $('<button></button>')
			.text(mw.msg('svgedit-editbutton-edit'))
			.click(function() {
				trigger(link);
			});
		$(link).after(button);
	}

	$('a.image').each(function() {
		setupImage(this);
	})
});

})(jQuery, mediaWiki);
