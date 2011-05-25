var TabView = {
	init: function(options) {
		$('#' + options.id).tabs({cache: true, selected: options.selected});
	}
};