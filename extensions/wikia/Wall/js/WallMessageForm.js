(function(window, $) {

Wall.MessageForm = $.createClass(Observable, {
	constructor: function(page, model) {
		Wall.MessageForm.superclass.constructor.apply(this,arguments);
		this.model = model;
		this.page = page;
		this.wall = $('#Wall');
	},
	
	showPreviewModal: function(format, metatitle, body, width, publishCallback) {
		var modal;
		var options = {
			buttons: [
				{
					id: 'close',
					message: $.msg('back'),
					handler: function() {
						modal.closeModal();
					}
				},
				{
					id: 'publish',
					defaultButton: true,
					message: $.msg('savearticle'),
					handler: function() {
						modal.closeModal();
						publishCallback();
					}
				}
			],
			width: 'auto',
			className: 'preview',
			callback: function() {
				$.nirvana.sendRequest({
					controller: 'WallExternalController',
					method: 'preview',
					format: 'json',
					data: { 
						'convertToFormat': format,
						'metatitle': metatitle,
						'body': body
					},
					callback: function(data) {
						$('.WallPreview').stopThrobbing();
						$('.WallPreview .WikiaArticle').html(data.body);
					}
				});
			}
		};
		
		// use loading indicator before real content will be fetched	
		var content = $('<div class="WallPreview"><div class="WikiaArticle"></div></div>');
		content.find('.WikiaArticle').css('width', width);
		var modal = $.showCustomModal($.msg('preview'), content, options);
		$('.WallPreview').startThrobbing();
		
		return false;
	},
	
	getMessageWidth: function(msg) {
		return msg.find('.editarea').width();
	},
	
	loginBeforeSubmit: function(action) {
		if(window.wgDisableAnonymousEditing  && !window.wgUserName) {
			UserLoginModal.show({
				callback: this.proxy(function() {
					action(false);
					return true;
				})
			});
		} else {
			action(true);
			return true;
		}
	},

	reloadAfterLogin: function() {
		UserLoginAjaxForm.prototype.reloadPage();
	},

	getFormat: function() {
		// gets overriden if MiniEditor is enabled
		return '';
	},

	proxy: function(func) {
		return $.proxy(func, this);
	}
});

})(window, jQuery);
