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
			callbackAfterSelect: function(url) {
				AddVideoStatic.addVideoCallbackFunction(url, 'VideosController', function() {
					window.location.search = "?sort=recent"; 
				});
			}
		});
	}
};

$(function() {
	SpecialVideos.init();
});