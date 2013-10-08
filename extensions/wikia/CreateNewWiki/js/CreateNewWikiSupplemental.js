// ThemeDesigner.js overwrites
ThemeDesigner.init = function() {
	$('#ThemeTab li label').remove();
};

ThemeDesigner.set = function(setting, newValue) {
	ThemeDesigner.settings = themes[newValue];

	var paths = [
			'/skins/oasis/css/oasis.scss'
		],
		urls = [];
	if ( wgOasisResponsive ) {
		paths.push( '/skins/oasis/css/core/responsive.scss' );
	}

	$.each(paths, function(i, path) {
		urls.push($.getSassCommonURL(path, $.extend(ThemeDesigner.settings, window.applicationThemeSettings)));
	});

	var styleSheetsToRemove = [];

	// Find duplicate existing stylesheets and queue them for removal
	$.each(document.styleSheets, function(i, styleSheet) {
		if (styleSheet) {
			$.each(paths, function(j, path) {
				if (styleSheet.href && ~styleSheet.href.indexOf(path)) {
					styleSheetsToRemove.push(styleSheet.ownerNode);
				}
			});
		}
	});

	// Load and inject the new stylesheets
	$.getResources(urls, function() {
		$(styleSheetsToRemove).remove();
	});

};
ThemeDesigner.save = function() {

};
