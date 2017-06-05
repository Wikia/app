/* global require */
require(['jquery', 'mw', 'wikia.window'], function ($, mw, context) {
	'use strict';
	var bucky = context.Bucky('ForumNewMessageForm');

	context.Forum.NewMessageForm = $.createClass(context.Wall.settings.classBindings.newMessageForm, {
		constructor: function () {
			context.Forum.NewMessageForm.superclass.constructor.apply(this, arguments);
			if (context.Wikia.Querystring().getVal('openEditor')) {
				this.messageTitleFocus();
			}
		},
		initElements: function () {
			bucky.timer.start('initElement');
			this.wrapper = $('#ForumNewMessage');
			this.buttons = $('#ForumNewMessage button');
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
			this.boardListError = this.message.find('.board-list-error');

			var topicOptions = {};

			if (this.boardList.exists()) {
				this.page = {
					namespace: $('#Wall').data('board-namespace')
				};
				topicOptions.topics = [ mw.config.get('wgTitle') ];
			}
			this.messageTopic = this.message.find('.message-topic').messageTopic(topicOptions);
			bucky.timer.stop('initElement');
		},
		afterPost: function (newmsg) {
			// TODO: this is a hack. We should just be getting the ID back
			context.location = newmsg.find('.msg-title a').attr('href');
		},
		messageTitleFocus: function () {
			if (this.messageBodyContainer.is(':hidden')) {
				this.messageBodyContainer.fadeIn();
				this.messageTopic.fadeIn();
			}
		},
		doPostNewMessage: function (title) {
			//disable buttons for user to not send multiply posts
			this.buttons.attr('disabled', true);
			var boardTitle = this.boardList.find('option:selected').val();
			if (!this.boardList.exists()) {
				context.Forum.NewMessageForm.superclass.doPostNewMessage.call(this, title);
				bucky.timer.stop('doPostNewMessage');
			} else if (boardTitle) {
				this.page.title = boardTitle;
				context.Forum.NewMessageForm.superclass.doPostNewMessage.call(this, title);
				bucky.timer.stop('doPostNewMessage');
			} else {
				this.boardListError.fadeIn('slow');
				this.buttons.removeAttr('disabled');
			}
		}
	});

	context.Wall.settings.classBindings.newMessageForm = context.Forum.NewMessageForm;

});
