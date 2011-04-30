(function(window){

	var WE = window.WikiaEditor;

	WE.modules.License = $.createClass(WE.modules.base,{
		modes: true,
		headerClass: 'license',
		template: '<p class="cke_license"><%=text%></p>',
		icons: '<img src="' + wgBlankImgUrl + '" class="cke_license_icon icon1">' +
				'<img src="' + wgBlankImgUrl + '" class="cke_license_icon icon2">',
		getData: function() {
			var text = $.msg('wikia-editor-modules-license-text', [this.icons, wgEditPageLicensingUrl]);
			text = text.replace('<a href', '<a target="_blank" href');

			return {text: text};
		}
	});

	WE.modules.ToolbarLicense = WE.modules.License;
	WE.modules.RailLicense = WE.modules.License;

})(this);