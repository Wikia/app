(function(window){

		var WE = window.WikiaEditor,
				items;

		items = [
			'InsertImage'
		];

		// for wgAllVideosAdminOnly
		if (window.showAddVideoBtn) {
			items.splice( 1, 0, "InsertVideo" );
		}

		WE.modules.InsertMiniEditor = $.createClass(WE.modules.Insert, {
				items: items,
				init: function() {
					WE.modules.InsertMiniEditor.superclass.init.call(this);
				}
		});

})(this);
