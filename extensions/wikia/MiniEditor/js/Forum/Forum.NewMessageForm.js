/* global require */
require(['jquery', 'wikia.window'], function ($, context) {
	'use strict';

	context.MiniEditor.Forum.NewMessageForm = $.createClass(context.Wall.settings.classBindings.newMessageForm, {
		disableNewMessage: function() {
			this.messageBody.data('wikiaEditor').fire('editorReset');
			this.message.find('.submit').attr('disabled', 'disabled');
			this.message.addClass('loading');
		},
		enableNewMessage: function() {
			this.messageSubmit.html($.msg('wall-button-to-submit-comment'));
			this.messageTitle.removeClass('no-title');
			this.messageNoTitle.fadeOut('fast');
			this.message.removeClass('loading');
		}
	});

	// Set as default class binding for NewMessageForm
	context.Wall.settings.classBindings.newMessageForm = context.MiniEditor.Forum.NewMessageForm;

});
