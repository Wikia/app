(function(window, $) {

Wall.EditMessageForm = $.createClass(Wall.MessageForm, {
	oldHTML: {},
	constructor: function(page) {
		Wall.EditMessageForm.superclass.constructor.apply(this,arguments);

		var $wall = $('#Wall');
		$wall.on('click', '.source-message', this.proxy(this.viewSource));
		$wall.on('click', '.edit-message', this.proxy(this.editMessage));
		$wall.on('click', '.edit-buttons .cancel-edit', this.proxy(this.cancelEdit));
		$wall.on('click', '.edit-buttons .preview', this.proxy(this.showPreview));
		$wall.on('click', '.edit-buttons .save-edit', this.proxy(this.saveEdit));
	},

	initEditForm: function(msg, data, mode) {
		if(mode != 'source') {
			$('.msg-title', msg).first().html('<textarea class="title">'+$('.msg-title a', msg).html()+'</textarea>');
			this.showEditTextArea(msg, data.htmlorwikitext);

		} else {
			this.showSourceTextArea(msg, data.htmlorwikitext);
			$('.edit-buttons.sourceview', msg).first().show();
		}

		msg.find('.buttonswrapper').hide();

		$('.follow', msg).hide();
		$('textarea.title', msg).first()
			.keydown(function(e) { if(e.which == 13) { return false; }})
			.autoResize({min: 30, minFocus:30, minContent: 30, limit: 300, limitEmpty: 30, extraSpace: 0}).trigger('change');
	},

	editMessage: function(e) {
		e.preventDefault();
		this.editOrSource(e, 'edit');
	},

	viewSource: function(e) {
		e.preventDefault();
		this.editOrSource(e, 'source');
	},

	editOrSource: function(e, mode) {
		var msg = $(e.target).closest('li.message');
		var id = msg.attr('data-id');
		var isreply = msg.attr('data-is-reply');
		var bubble = $('.speech-bubble-message', msg).first();
		// If we're viewing source, we want wikitext and no conversion.
		var format = mode == 'source' ? '' : this.getEditFormat(msg);

		msg.find('.wikia-menu-button').removeClass("active");

		this.model.loadEditData(this.page, id, mode, format, this.proxy(function(data) {
			this.setOldHTML(id, bubble);
			this.initEditForm(msg, data, mode);
		}));
	},

	showEditTextArea: function(msg, text) {
		$('.edit-buttons.edit', msg).first().show();
		$('.msg-body', msg).first().html('<textarea class="body">' + text +'</textarea>');
		// TODO: make this more efficient?
		$('textarea.body', msg).first().focus().autoResize({minFocus:100, minContent: 100, limit: 9999, limitEmpty: 70, extraSpace: 30}).trigger('change');
	},

	showSourceTextArea: function(msg, text) {
		var sourceTextarea = $('<textarea readonly="readonly" class="body">' + text + '</textarea>');
		$('.msg-body', msg).first().html("").append(sourceTextarea);
		sourceTextarea.autoResize({minFocus:100, minContent: 100, limit: 9999, limitEmpty: 70, extraSpace: 30}).trigger('change');
	},

	cancelEdit: function(e) {
		e.preventDefault();

		var target = $(e.target),
			isSource = target.hasClass('cancel-source'),
			msg = target.closest('li.message'),
			bubble = msg.children('.speech-bubble-message'),
			id = msg.attr('data-id'),
			body = msg.find('.msg-body').first();

		/* restore html to state from before edit */
		this.insertOldHTML(id, bubble);

		msg.find('.buttonswrapper').show();

		if( window.skin && window.skin != "monobook" ) {
			WikiaButtons.init(bubble);
		}

		this.afterCancel(body, isSource, target, bubble);
	},

	getNewBody: function(container) {
		return $('.msg-body textarea.body', container).val();
	},

	getNewTitle: function(container) {
		return $('.msg-title textarea.title', container).val();
	},

	getEditFormat: function() {
		return this.getFormat();
	},

	getSaveFormat: function() {
		return this.getFormat();
	},

	showPreview: function(e) {
		var msg = $(e.target).closest('li.message');
		this.showPreviewModal(this.getSaveFormat(msg), this.getNewTitle(msg), this.getNewBody(msg), this.getMessageWidth(msg), this.proxy( function() {
			this.saveEdit(e);
		}));
	},

	saveEdit: function(e) {
		var target = $(e.target);
		var buttons = target.parent().children('.wikia-button');
		var msg = target.closest('li.message');
		var id = msg.attr('data-id');
		var isreply = msg.attr('data-is-reply');
		var newtitle = this.getNewTitle(msg);
		var newbody = this.getNewBody(msg);
		var format = this.getSaveFormat(msg);

		buttons.attr('disabled', true);

		this.model.saveEdit(
			this.page,
			id,
			newtitle,
			newbody,
			isreply,
			format,
			//success callback
			this.proxy(function (data) {
				var $bubble, $body, $timestamp, $editor;

				$bubble = $('.speech-bubble-message', msg).first();
				this.resetHTMLAfterEdit(id, $bubble);

				$('.msg-title', msg).first().html(data.msgTitle);
				$body = $('.msg-body', msg).first().html(data.body);

				// fire event when new article comment is/will be added to DOM
				mw.hook('wikipage.content').fire($body);

				$timestamp = $bubble.find('.timestamp');
				$editor = $timestamp.find('.username');
				if ($editor.exists()) {
					$timestamp.find('.username').html(data.username).attr('href', data.userUrl);
				} else {
					$timestamp.prepend($($.msg('wall-message-edited', data.userUrl, data.username, data.historyUrl)));
				}

				$timestamp.find('.timeago').attr('title', data.isotime).timeago();
				$timestamp.find('.timeago-fmt').html(data.fulltime);

				if (window.skin && window.skin != "monobook") {
					WikiaButtons.init(msg);
				}

				buttons.removeAttr('disabled');

				msg.find('.buttonswrapper').show();
			}),
			//fail callback
			this.proxy(function () {
				buttons.removeAttr('disabled');
				$.showModal($.msg('wall-posting-message-failed-title'), $.msg('wall-posting-message-failed-body'));
			})
		);
	},

	resetHTMLAfterEdit: function(id, bubble){
		this.insertOldHTML(id, bubble);
	},

	setOldHTML: function(id, bubble) {
		this.oldHTML[id] = bubble.html();
	},

	insertOldHTML: function(id, bubble) {
		bubble.html(this.oldHTML[id]);
	},

	afterCancel: function() {
		// used in MiniEditor;
	},

	afterEdit: function() {
		// used in MiniEditor;
	}
});

Wall.settings.classBindings.editMessageForm = Wall.EditMessageForm;

})(window, jQuery);