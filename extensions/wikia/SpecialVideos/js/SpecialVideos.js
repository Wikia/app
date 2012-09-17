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
				window.location.search = "?sort=recent"; // TODO: fix this so it's not hard coded
			}
		});
	}
};

$(function() {
	SpecialVideos.init();
});