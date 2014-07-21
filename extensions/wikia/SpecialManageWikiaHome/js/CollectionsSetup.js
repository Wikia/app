var CollectionsSetup = function() {};

CollectionsSetup.prototype = {
	wmuReady: undefined,
	wmuDeffered: undefined,
	nav: undefined,
	init: function() {
		var checkboxes = $('#collectionsSetupForm input[name="enabled[]"]');

		checkboxes.click(this.handleToggleEnabled);
		checkboxes.each($.proxy(function(i, elem){
			this.handleToggleEnabled({target: elem});
		}, this));

		this.nav = new CollectionsNavigation('.collection-module');
		$('#collectionsSetupForm').find('.wmu-show').click($.proxy(this.handleAddPhoto, this));
	},

	handleToggleEnabled: function(event) {
		var checkbox = $(event.target);
		var switchableElems = checkbox.parents('.collection-module:first').find('input').filter(':not([name="enabled[]"])');

		if (checkbox.is(':checked')) {
			switchableElems.removeAttr('disabled');
		} else {
			switchableElems.attr('disabled', 'disbaled');
		}
	},
	handleAddPhoto: function(event) {
		event.preventDefault();
		this.lastActiveWmuButton = $(event.target);
		if (!this.wmuReady) {
			this.wmuDeffered = $.when(
					$.loadYUI(),
					$.loadJQueryAIM(),
					$.getResources([
						wgExtensionsPath + '/wikia/WikiaMiniUpload/js/WMU.js',
						$.getSassCommonURL( 'extensions/wikia/WikiaMiniUpload/css/WMU.scss')
					]),
					$.loadJQueryAIM()
				).then($.proxy(function() {
					WMU_skipDetails = true;
					WMU_show();
					WMU_openedInEditor = false;
					this.wmuReady = true;
				}, this));
			$(window).bind('WMU_addFromSpecialPage', $.proxy(function(event, wmuData) {
				this.addImage(wmuData);
			}, this));
		}
		else {
			WMU_show();
			WMU_openedInEditor = false;
		}
	},
	addImage: function(wmuData) {
		var fileName = this.getImageNameFromFileTilte(wmuData.imageTitle);
		this.lastActiveWmuButton
			.parents('.image-input-container:first')
			.find('input')
			.filter('[type="text"]')
			.val(fileName);
	},
	getImageNameFromFileTilte: function(title) {
		var elems = title.split(':');
		elems.shift();
		return elems.join(':');
	}
};

var CollectionsSetupInstance = new CollectionsSetup();
$(function () {
	CollectionsSetupInstance.init();
});
