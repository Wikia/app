(function(window){

	var WE = window.WikiaEditor;

	WE.modules.License = $.createClass(WE.modules.base,{
		modes: true,
		headerClass: 'license',
		template: '<p class="{{wrapperClass}}">{{{text}}}</p>',
		defaultLicense: 'CC-BY-SA',
		getData: function() {
			var icons = '',
				wrapperClass = 'cke_license';

			if (window.wgRightsText == this.defaultLicense) {
				icons = '<img src="' + wgBlankImgUrl + '" class="cke_license_icon icon1">' +
					'<img src="' + wgBlankImgUrl + '" class="cke_license_icon icon2">';

				wrapperClass += ' cke_license_with_icons';
			}

			var text = $.msg('wikia-editor-modules-license-text',
				icons,
				window.wgEditPageLicensingUrl,
				window.wgRightsText);

			// open license text URL in new tab
			text = text.replace('<a href', '<a target="_blank" href');

			return {
				text: text,
				wrapperClass: wrapperClass
			};
		}
	});

	WE.modules.ToolbarLicense = WE.modules.License;
	WE.modules.RailLicense = WE.modules.License;

})(this);