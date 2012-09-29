var SpecialVideos = {
	init: function() {
		$('.WikiaDropdown').wikiaDropdown({
			onChange: function(e, $target) {
				var currSort = this.$selectedItemsList.text(),
					newSort = $target.text();

				if(currSort != newSort) {
					var sort = $target.data('sort');
					window.location.search = "?sort="+sort;
				}
			}
		});
		
		$('.addVideo').addVideoButton({
			gaCat: 'testing',
			callback: function() {
				window.location = window.location.href.split('?')[0]; // Remove query string when reloading the page (default sort is recent)
			}
		});
	}
};

$(function() {
	SpecialVideos.init();
});