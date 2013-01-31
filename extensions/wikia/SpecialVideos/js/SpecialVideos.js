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
				$.nirvana.postJson(
					// controller
					'VideosController',
					// method
					'addVideo',
					// data
					{ url: url },
					// success callback
					function( formRes ) {
						GlobalNotification.hide();
						if ( formRes.error ) {
							GlobalNotification.show( formRes.error, 'error' );
						} else {
							VET_loader.modal.closeModal();
							window.location.search = "?sort=recent";
						}
					},
					// error callback
					function() {
						GlobalNotification.show( $.msg('vet-error-while-loading'), 'error' );
					}
				);
				// Don't move on to second VET screen.  We're done.
				return false; 
			}
		});
	}
};

$(function() {
	SpecialVideos.init();
});