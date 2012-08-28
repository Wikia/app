$(function() {

var VideoPage = {
	init: function() {
		var self = this;
		
		$('.WikiaMenuElement').on('click', '.remove', function(e) {
			e.preventDefault();
			
			$.showCustomModal($.msg('videohandler-remove-video-modal-title'),'', {
				id: 'remove-video-modal',
				buttons: [
					{
						id: 'ok', 
						defaultButton: true, 
						message: $.msg('videohandler-remove-video-modal-ok'), 
						handler: function(){
							//$.nirvana.sendRequest
						}
					},
					{
						id: 'cancel', 
						message: $.msg('videohandler-remove-video-modal-cancel'), 
						handler: function(){
							alert('cancel');
						}
					}
				],
				callback: function() {
					self.
				}
			});
		});
	}
}

VideoPage.init();

});