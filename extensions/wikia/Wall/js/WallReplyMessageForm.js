/*
 * Message reply functions
 */

var WallReplyMessageForm = $.createClass(WallMessageForm, {
	constructor: function(page, model) {
		WallNewMessageForm.superclass.constructor.apply(this, arguments);

		this.wall = $('#Wall');

		this.settings = {
			reply: {
				minFocus:100,
				minContent: 100,
				limit: 9999,
				limitEmpty: 30,
				extraSpace: 30
			}
		};

		this.init();

		this.model.bind('pageLoaded', this.proxy(function(page, data) {
			this.init(page);
		}));
	},

	init: function() {
		this.wall
			.on('click', '.replyButton', this.proxy(this.replyToMessage))
			.on('keydown keyup change', '.new-reply .body', this.proxy(this.change))
			.on('focus', '.new-reply .body', this.proxy(this.focus))
			.on('blur', '.new-reply .body', this.proxy(this.blur))
			.find('.new-reply .body').autoResize(this.settings.reply);
	},

	focus: function(e) {
		var el = $(e.target).closest('.SpeechBubble');
		$('.replyButton', el).show();
		el.css({ 'margin-bottom': '40px'});
		$('.speech-bubble-message', el).stop().css({'margin-left':'40px'});
		$('.speech-bubble-avatar', el).show();
		$('textarea',el).css('line-height','inherit');
		this.track('wall/message/reply_field');
	},

	change: function(e) {
		var target = $(e.target);
		var content = !target.hasClass('placeholder') && target.val().length > 0;

		if (content && !target.hasClass('content')) {
			target.closest('.SpeechBubble').find('.replyButton').removeAttr('disabled');
			target.addClass('content');
			var el = target.closest('.SpeechBubble');
			$('button', el ).removeAttr('disabled');

		} else if(!content && target.hasClass('content')) {
			target.closest('.SpeechBubble').find('.replyButton').attr('disabled', 'disabled');
			target.removeClass('content');
			var el = target.closest('.SpeechBubble');
			$('button', el ).attr('disabled','disabled');
		}
	},

	blur: function(e) {
		var content = !$(e.target).hasClass('placeholder') && $(e.target).val().length > 0;

		if(!content) {
			var el = $(e.target).closest('.SpeechBubble');
			$('button', el ).hide();
			$(el).css({ 'margin-bottom': '0px'});
			$('.speech-bubble-message', el).animate({'margin-left':'0px'},150);
			$('.speech-bubble-avatar', el)
				.css('position','absolute')
				.fadeOut(150);
			$('textarea',el).css('line-height','normal');
		} 
	},

	disable: function(el) {
		$('textarea', el).attr('disabled', 'disabled');
		$('.replyButton', el).attr('disabled', 'disabled');
		$('.loadingAjax', el).show();
		$('.speech-bubble-message', el).addClass('loading');
	},

	enable: function(el) {
		$('textarea', el).removeAttr('disabled');
		$('.replyButton', el).removeClass('loading').removeAttr('disabled');
		$('.loadingAjax', el).hide();
		$('.speech-bubble-message', el).removeClass('loading');
	},

	replyToMessage: function(e, href) {
		var main = $(e.target).closest('.comments > .SpeechBubble');
		var newreply = $(e.target).closest('.SpeechBubble');
		this.disable(newreply);

		if ($(e.target).hasClass('wall-require-login'))  {
			//do nothing -- ajax combo box will take care of it starting from now
			this.loginBeforeAction(this.proxy(function() {
				this.doReplyToMessage(main, newreply, true);
			}));

		} else {
			this.doReplyToMessage(main, newreply, false);
		}
	},

	doReplyToMessage: function(main, newreply, reload) {
		this.model.postReply(this.page, newreply.find('textarea').val(), this.getFormat(), main.attr('data-id'), this.proxy(function(msg) {
			this.enable(newreply);

			main.find('textarea').val('').trigger('blur');

			var newmsg = $(msg).insertBefore(main.find('ul li.new-reply')).hide().fadeIn('slow');
			
			if (window.skin && window.skin != 'monobook') {
				WikiaButtons.init(newmsg);
			}

			$('.timeago',newmsg).timeago();

			main.find('ul li.load-more .count').html(main.find('ul li.message').length);
			$('.speech-bubble-message', newreply).css({'margin-left':'0px'});
			$('.speech-bubble-avatar', newreply).hide();
			$('.follow', main).text($.msg('wikiafollowedpages-following')).removeClass('secondary');

			//click tracking
			this.track('wall/message/reply_post');

			if (reload) {
				this.reloadAfterLogin();
			}
		}));
	}
});