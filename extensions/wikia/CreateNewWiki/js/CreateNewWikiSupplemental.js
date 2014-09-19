// ThemeDesigner.js overwrites
ThemeDesigner.init = function() {
	$('#ThemeTab li label').remove();
};

ThemeDesigner.set = function(setting, newValue) {
	// The newValue is either the name of a theme or a single setting.
	// The latter should be hadled as it is in the original method...
	//
	// ... or the theme settings will be overwritten (CE-456)
	if ( 'undefined' === typeof themes[newValue] ) {
		ThemeDesigner.settings[setting] = newValue;
	} else {
		ThemeDesigner.settings = themes[newValue];
	}
	var sassUrl = $.getSassCommonURL('/skins/oasis/css/oasis.scss', $.extend(ThemeDesigner.settings, window.applicationThemeSettings));
	$.getCSS(sassUrl, function(link) {
		$(ThemeDesigner.link).remove();
		ThemeDesigner.link = link;
	});
};

ThemeDesigner.save = function() {

};
