(function(window, $) {
Forum.NewMessageForm = $.createClass(Wall.settings.classBindings.newMessageForm, {
	initElements: function() {	
		this.wrapper = $('#ForumNewMessage');
		this.buttons = this.wrapper.find('.buttons');
		this.message = this.wrapper.find('.message');
		this.messageNoTitle = this.message.find('.no-title-warning');
		this.messageTitle = this.message.find('.title');
		this.messageBody = this.message.find('.body');
		this.messageBodyContainer = this.message.find('.body-container');
		this.messageSubmit = this.message.find('.submit');
		this.messagePreview = this.message.find('.preview');
		this.notifyEveryone = this.message.find('.notify-everyone');
		this.loading = this.message.find('.loadingAjax');
		this.messageTitle.on('focus', this.proxy(this.messageTitleFocus));
		this.boardList = $('#BoardList');
		
		var topicOptions = {};
		
		if(this.boardList.exists()) {
			this.page = {
				namespace: $('#Wall').data('board-namespace')
			};
			topicOptions['topics'] = [window.wgTitle];
		}
		this.messageTopic = this.message.find('.message-topic').messageTopic(topicOptions);

	},
	afterPost: function(newmsg) {
		// TODO: this is a hack. We should just be getting the ID back
		window.location = newmsg.find('.msg-title a').attr('href');
	},
	messageTitleFocus: function(event) {
		if (this.messageBodyContainer.is(':hidden')) {
			this.messageBodyContainer.fadeIn();
			this.messageTopic.fadeIn();
		}
	},
	doPostNewMessage: function(title) {
		var boardTitle = this.boardList.find('option:selected').val();
		if(!this.boardList.exists()) {
			Forum.NewMessageForm.superclass.doPostNewMessage.call(this, title);
		} else if(this.boardList.exists() && boardTitle) {
			this.page['title'] = boardTitle;
			Forum.NewMessageForm.superclass.doPostNewMessage.call(this, title);
		}
	}
});

Wall.settings.classBindings.newMessageForm = Forum.NewMessageForm;

})(window, jQuery);