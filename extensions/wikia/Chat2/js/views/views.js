//
//Views
//

var ChatView = Backbone.View.extend({
	tagName: 'li',
	template: _.template($('#message-template').html()),
	inlineTemplate: _.template($('#inline-alert-template').html()),
	meMessageTemplate: _.template($('#me-message-template').html()),
	emoticonMapping: new EmoticonMapping(),

	initialize: function () {
		_.bindAll(this, 'render');

		if (this.model) {
			this.model.bind('all', this.render);
		}
		// Load the mapping of emoticons.  This wiki has priority, then falls back to Messaging.  If both of those fail, uses some hardcoded fallback.
		this.emoticonMapping.loadFromWikiText(window.wgChatEmoticons);
	},

	/**
	 * All messages that are received are processed here before being displayed. This
	 * will escape html/js, build links, and process emoticons.
	 */
	processText: function (text, allowHtml) {
		// TODO: Use the wgServer and wgArticlePath from the chat room. Maybe the room should be passed into this function?
		// (it seems like it could be called a bunch of times in rapid succession).

		// Prepare a regexp we use to match local wiki links
		var localWikiLinkReg = '^' + wgServer + wgArticlePath,
			exp;

		if (!allowHtml) {
			// Prevent simple HTML/JS vulnerabilities (need to do this before other rewrites).
			text = text.replace(/</g, '&lt;');
			text = text.replace(/>/g, '&gt;');
		}

		localWikiLinkReg = localWikiLinkReg.replace(/\$1/, '(\\S+[^.\\s\\?\\,])');
		localWikiLinkReg = new RegExp(localWikiLinkReg, 'i');

		if (!allowHtml) {
			// Linkify http://links
			exp = /\b(ftp|http|https):\/\/(\w+:{0,1}\w*@)?[a-zA-Z0-9\-\.]+(:[0-9]+)?\S+[^.\s\?\,]/ig;

			text = text.replace(exp, function (link) {
				var linkName = link,
				// Linkify local wiki links (eg: http://thiswiki.wikia.com/wiki/Page_Name ) as shortened links (like bracket links)
					match = localWikiLinkReg.exec(link);

				if (match !== null) {
					linkName = match[1].replace(/_/g, ' ');
				}

				// (BugId:97945) Invalid URIs can throw 'URIError: URI malformed'
				try {
					linkName = decodeURIComponent(linkName);
				} catch (e) {
				}

				linkName = linkName.replace(/</g, '&lt;'); // prevent embedding HTML in urls (to get it to come out as plain HTML in the text of the link)
				linkName = linkName.replace(/>/g, '&gt;');
				return '<a href="' + link + '">' + linkName + '</a>';
			});
		}

		// helper function (to avoid code duplicates)
		function linkify(article, linkText) {
			var path = wgServer + wgArticlePath,
				url;

			article = article.replace(/ /g, '_');
			linkText = linkText.replace(/_/g, ' ');
			linkText = unescape(linkText);
			linkText = linkText.replace(/</g, '&lt;'); // prevent embedding HTML in urls (to get it to come out as plain HTML in the text of the link)
			linkText = linkText.replace(/>/g, '&gt;');


			article = encodeURIComponent(article);
			article = article.replace(/%2f/ig, '/'); // make slashes more human-readable (they don't really need to be escaped)
			article = article.replace(/%3a/ig, ':'); // make colons more human-readable (they don't really need to be escaped)
			url = path.replace('$1', article);

			return '<a href="' + url + '">' + linkText + '</a>';
		}

		// Linkify [[Pipes|Pipe-notation]] in bracketed links.
		exp = /\[\[([^\[\|\]\r\n\t]*)\|([^\[\]\|\r\n\t]*)\]\]/ig;
		text = text.replace(exp, function (wholeMatch, article, linkText) {
			if (!linkText) { // Parse 'pipe-trick' links, eg. [[User:Example|]] expands to <a href='/wiki/User:Example'>Example</a>
				var colonLocation = article.indexOf(':');
				if (colonLocation == -1) {
					linkText = article;
				} else {
					linkText = article.substring(colonLocation + 1);
				}
			}
			return linkify(article, linkText);
		});

		// Linkify [[links]]
		exp = /(\[\[[^\[\]\r\n\t]*\]\])/ig;
		text = text.replace(exp, function (match) {
			var article = match.substr(2, match.length - 4),
				linkText = article.replace(/_/g, ' ');

			return linkify(article, linkText);
		});

		// Process emoticons (should be done after the linking because the link code is searching for URLs and the emoticons contain URLs).
		// Replace appropriate shortcuts in the text with the emoticons.
		text = WikiaEmoticons.doReplacements(text, this.emoticonMapping);

		return text;
	},

	// Inline Alerts have may have i18n messages in them. If so (and they don't have 'text' yet), process the message and cache it in 'text'.
	// This needs to be done before the template processing below so that 'text' will be set by then.
	render: function (type) {
		var params,
			msgId,
			i18nText,
			msg,
			originalTemplate,
			date,
			hours,
			minutes;

		if (this.model.get('text') === '') {
			params = this.model.get('msgParams');
			msgId = this.model.get('wfMsg');

			if (!params || !msgId) {
				return this;
			}
			$().log('Found an i18n message with msg name ' + msgId + ' and params: ' + params);
			params.unshift(msgId);
			i18nText = $.msg.apply(null, params);
			this.model.set({
				text: i18nText
			});
			$().log('Message translated to: ' + i18nText);
		}

		msg = this.model.toJSON();
		// Make a call to process any text for links, unsafe html/js, emoticions, etc.
		// note: html/js is not escaped in alerts (FB 21922)
		msg.text = this.processText(msg.text, this.model.get('isInlineAlert'));
		if (this.model.get('isInlineAlert')) {
			originalTemplate = this.template;
			this.template = this.inlineTemplate;
			$(this.el).html(this.template(msg));
			this.template = originalTemplate;
		} else {
			// '/me' command implementation
			// note - in case of more commands executed on the message receiver side, there should
			// be a loop here which goes through all commands and executes callbacks
			if (msg.text.indexOf('/me ') == 0) {
				msg.text = msg.text.substr(4);
				originalTemplate = this.template;
				this.template = this.meMessageTemplate;
				$(this.el).html(this.template(msg)).addClass('me-message-line');
				this.template = originalTemplate;
			} else {
				if (msg.text.indexOf('//me ') == 0) {
					msg.text = msg.text.substr(1);
				}
				// end of /me implementation
				$(this.el).html(this.template(msg));
			}
		}

		$(this.el).attr('id', 'entry-' + this.model.cid);

		// Add username as a class in li element
		if (this.model.get('name')) {
			$(this.el).attr('data-user', this.model.get('name'));
		}

		// Add 'continued' class if this user also typed the last message (combines in UI)
		if (type === 'change' || typeof(type) === 'undefined') {
			if (this.model.get('continued') === true) {
				$(this.el).addClass('continued');
			}
		}

		// Add a special 'you' class for styling your own messages
		if (this.model.get('name') === window.wgUserName) {
			$(this.el).addClass('you');
		}

		// Inline Alert
		if (this.model.get('isInlineAlert') === true) {
			$(this.el).addClass('inline-alert');
		}

		// Timestamps
		if (this.model.get('timeStamp').toString().match(/^\d+$/)) {
			date = new Date(this.model.get('timeStamp'));

			if (date.getHours() === 0) {
				hours = 12;
			} else if (date.getHours() > 12) {
				hours = date.getHours() - 12;
			} else {
				hours = date.getHours();
			}
			minutes = (date.getMinutes().toString().length == 1) ? '0' + date.getMinutes() : date.getMinutes();
			$(this.el).find('.time').text(hours + ':' + minutes);
		}

		return this;
	}
});

var UserView = Backbone.View.extend({
	tagName: 'li',
	className: 'User',
	template: _.template($('#user-template').html()),

	initialize: function () {
		_.bindAll(this, 'render', 'close');
		this.model.bind('change', this.render);
		this.model.view = this;
	},

	render: function () {
		var model = this.model.toJSON();

		$().log(model, model.name);
		if (model.since) {
			model.since = window.wgChatLangMonthAbbreviations[model.since.mon] + ' ' + model.since.year;
		}

		$(this.el).html(this.template(model));

		// Set the id by username so that we can remove it when the user parts.

		$(this.el).attr('id', this.liId());
		$(this.el).attr('data-user', this.model.get('name'));

		// If this is a chat moderator, add the chat-mod class so that kick-ban links don't show up, etc.
		if (this.model.get('isModerator') === true) {
			$(this.el).addClass('chat-mod');
		}

		if (this.model.get('isStaff') === true) {
			$(this.el).addClass('staff');
		}


		// If the user is away, add a certain class to them, if not, remove the away class.
		if (this.model.get('statusState') == STATUS_STATE_AWAY) {
			$(this.el).addClass('away');
		} else {
			$(this.el).removeClass('away');
		}

		// If this is you, render your content on top.
		if (this.model.get('name') === wgUserName) {
			$(this.el).css('display', 'none');
			$('#ChatHeader').find('.User').html($(this.el).html())
				.attr('class', $(this.el).attr('class'));
		}

		return this;
	},

	liId: function () {
		var prefix = '',
			username;

		if (this.model.get('isPrivate') === true) {
			prefix = 'priv-';
		}
		username = this.model.get('name').replace(/ /g, '_'); // encodeURIComponent would add invalid characters
		return prefix + 'user-' + username;
	},

	getUserElement: function () {
		return $(document.getElementById(this.liId()));
	}
});

var NodeChatDiscussion = Backbone.View.extend({
	initialize: function (options) {
		this.roomId = options.roomId;
		this.model = options.model;
		this.model.chats.bind('afteradd', $.proxy(this.addChat, this));
		this.model.chats.bind('remove', $.proxy(this.removeChat, this));
		this.model.chats.bind('clear', $.proxy(this.clear, this));
		this.forceScroll = true;

		this.delegateEventsToTrigger(this.triggerEvents, function (event) {
			return event;
		});

		$('#WikiaPage')
			.append($('<div style="display:none" id="Chat_' + this.roomId + '" class="Chat"><ul></ul></div>'));
		this.chatDiv = $('#Chat_' + this.roomId);
		this.chatUL = this.chatDiv.find('ul');

		this.chatDiv.on('click', 'a', $.proxy(function (event) {
			this.trigger('clickAnchor', event);
			event.preventDefault();
		}, this));

		this.model.room.bind('change', $.proxy(this.updateRoom, this));
		this.chatDiv.bind('scroll', $.debounce(100, $.proxy(this.userScroll, this)));
	},
	//TODO: divide to NodeChatDiscussion and NodeChatUsers
	updateRoom: function (status) {
		var count = $('#MsgCount_' + status.get('roomId')),
			room = count.closest('.User, .wordmark'),
			$privateHeader = $('#Rail').find('> .private'),
			$write = $('#Write'),
			$textarea = $write.find('textarea'),
			$chatHeader = $('#ChatHeader'),
			$chatHeaderPublic = $chatHeader.find('.public'),
			$chatHeaderPrivate = $chatHeader.find('.private');

		if (status.get('unreadMessage') > 0) {
			count.text(status.get('unreadMessage'));
			room.addClass('unread');
		} else {
			room.removeClass('unread');
		}

		if (status.get('isActive') === true) {
			room.addClass('selected');

			if (status.get('blockedMessageInput') === true) {
				$write.addClass('blocked');
				$textarea.attr('disabled', 'disabled');
			} else {
				$write.removeClass('blocked');
				$textarea.removeAttr('disabled');
			}

			this.show();
			if (status.get('privateUser') === false) {
				$chatHeaderPublic.show();
				$chatHeaderPrivate.hide();
			} else {
				$chatHeaderPublic.hide();
				$chatHeaderPrivate.text($.msg('chat-private-headline')
					.replace('$1', status.get('privateUser').get('name')))
					.show();
			}
		} else {
			room.removeClass('selected');
			this.hide();
		}

		if (status.get('blockedMessageInput') === true) {
			room.addClass('blocked');
		} else {
			room.removeClass('blocked');
		}

		if (status.get('hidden') === true) {
			room.hide();
		} else {
			room.show();
		}

		// Handle hiding/showing private chat header
		($('#PrivateChatList').find('.User:visible').length) ? $privateHeader.show() : $privateHeader.hide();

	},

	getTextInput: function () {
		return $('#Write').find('[name="message"]');
	},

	show: function () {
		this.chatDiv.show();
		this.scrollToBottom();
	},

	hide: function () {
		this.chatDiv.hide();
	},

	triggerEvents: {
		'keyup #Write [name="message"]': 'updateCharacterCount',
		'keydown #Write [name="message"]': 'updateCharacterCount',
		'keypress #Write [name="message"]': 'sendMessage'
	},

	clear: function () {
		this.chatUL.empty();
	},

	addChat: function (chat) {
		var view = new ChatView({
			model: chat
		});
		// Add message to chat
		if (chat.attributes.name == wgUserName) {
			this.forceScroll = true;
		}

		this.chatUL.append(view.render().el);

		// Scroll chat to bottom
		if (this.forceScroll) {
			this.scrollToBottom();
		}
	},

	removeChat: function (chat) {
		var node = $('#entry-' + chat.cid);
		node.next().removeClass('continued');
		node.remove();
	},

	scrollToBottom: function () {
		// scroll after delay to allow text expansion (eg. emoteicons)
		var forceScroll = this.forceScroll;
		setTimeout($.proxy(function () {
			this.chatDiv.scrollTop(this.chatDiv.get(0).scrollHeight);
			// restore forceScroll status (this should happen after text expansion)
			this.forceScroll = forceScroll;
		}, this), 0);
	},

	userScroll: function () {
		// Determine if chat view is presently scrolled to the bottom
		var isAtBottom = false;
		if (( this.chatDiv.scrollTop() + 1) >= (this.chatUL.outerHeight() - this.chatDiv.height())) {
			isAtBottom = true;
		}

		this.forceScroll = isAtBottom;
	}
});
//TODO: rename it to frame NodeChatFrame ?
var NodeChatUsers = Backbone.View.extend({
	actionTemplate: _.template($('#user-action-template').html()),
	actionTemplateNoUrl: _.template($('#user-action-template-no-url').html()),

	initialize: function () {
		var $rail = $('#Rail');

		this.model.users.bind('add', $.proxy(this.addUser, this));
		this.model.users.bind('remove', $.proxy(this.removeUser, this));

		this.model.privateUsers.bind('add', $.proxy(this.addUser, this));
		this.model.privateUsers.bind('remove', $.proxy(this.removeUser, this));

		$('#ChatHeader').find('a').click($.proxy(function (event) {
			this.trigger('clickAnchor', event);
			event.preventDefault();
		}, this));

		this.delegateEventsToTrigger(this.triggerEvents, function (event) {
			var name = $(event.target)
				.closest('.UserStatsMenu')
				.find('.username')
				.text();

			if (!(name.length > 0)) {
				name = $(event.target)
					.closest('li')
					.find('.username')
					.first()
					.text();
			}
			event.preventDefault();
			return {
				name: name,
				event: event,
				target: $(event.target).closest('li')
			};
		});

		$rail.on('click', '.wordmark', function (event) {
			event.preventDefault();
			window.mainRoom.showRoom('main');
		});

		// Hide/show main chat user list
		$rail.find('.chevron').click(function () {
			var $wikiChatList = $('#WikiChatList');

			if ($wikiChatList.is(':visible')) {
				$(this).addClass('closed');
				$wikiChatList.slideUp('fast');
			} else {
				$(this).removeClass('closed');
				$wikiChatList.slideDown('fast');
			}
		});
	},

	triggerEvents: {
		'click .kick': 'kick',
		'click .ban': 'ban',
		'click .give-chat-mod': 'giveChatMod',
		'click .private-block': 'blockPrivateMessage',
		'click .private-allow': 'allowPrivateMessage',
		'click .private': 'showPrivateMessage',
		'click #WikiChatList li': 'mainListClick',
		'click #PrivateChatList li': 'privateListClick'
	},

	addUser: function (user) {
		var view = new UserView({model: user}),
			list = (user.attributes.isPrivate) ? $('#PrivateChatList') : $('#WikiChatList'),
			isPrivate = user.get('isPrivate'),
			el = $(view.render().el),
			compareA,
			wasAdded,
			$rail = $('#Rail');

		// For private chats, show private headline and possibly select the chat
		if (isPrivate) {
			$rail.find('h1.private').show();
			if (user.get('active')) {
				el.addClass('selected');
			}
		}

		// Add users to list
		if (list.children().length) {
			// The list is not empty. Arrange alphabetically.
			compareA = el.data('user');
			if (typeof(compareA) == 'string') {
				compareA = compareA.toUpperCase();
			}

			wasAdded = false;
			list.children().each(function (idx, itm) {
				var compareB = $(itm).data('user');
				if (typeof(compareB) == 'string') {
					compareB = compareB.toUpperCase();
				}
				//TODO: check it
				if (compareA == compareB) {
					return false;
				}
				if (compareA < compareB) {
					$(itm).before(el);
					wasAdded = true;
					return false;
				}
			});
			if (!wasAdded) {
				list.append(el);
			}
		} else {
			// The list is empty. Append this user.
			list.append(el);
		}

		// Scroll the list down if a new private chat is being added
		if (user.get('isPrivate')) {
			$().log('UserView SCROLL DOWN!!!');
			$rail.scrollTop($rail.get(0).scrollHeight);
		}

		if (!isPrivate) {
			this.toggleChevron(list);
		}
	},

	removeUser: function (user) {
		var list = (user.attributes.isPrivate) ? $('#PrivateChatList') : $('#WikiChatList'),
			isPrivate = user.get('isPrivate'),
			view = new UserView({model: user});

		view.getUserElement().remove();

		if (!isPrivate) {
			this.toggleChevron(list);
		}
	},

	// Only show chevron in public chat if there is anyone to talk to
	toggleChevron: function (list) {
		var chevron = $('#Rail').find('.public .chevron');

		if (list.children().length > 1) {
			chevron.show();
		} else {
			chevron.hide();
		}
	},

	showMenu: function (element, actions) {
		var location,
			$element = $(element),
			offset = $element.offset(),
			menu = $('#UserStatsMenu').html($(element).find('.UserStatsMenu').html()),
			menuActions = menu.find('.actions'),
			username = menu.find('.username').text(),
			ul = $('<ul>'),
			adminActions,
			regularActions,
			i,
			action;

		// position menu
		menu.css('right', $('#Rail').outerWidth()).css('top', offset.top);

		// regular actions
		if (actions.regular && actions.regular.length) {
			regularActions = ul.clone().addClass('regular-actions');

			for (i in actions.regular) {
				action = actions.regular[i];

				if (action == 'profile') {
					action = /Message_Wall/.test(window.wgChatPathToProfilePage) ? 'message-wall' : 'talk-page';
					location = window.wgChatPathToProfilePage.replace('$1', username);

				} else if (action == 'contribs') {
					location = window.wgChatPathToContribsPage.replace('$1', username);

				} else {
					location = null;
				}

				regularActions.append(
					this[location ? 'actionTemplate' : 'actionTemplateNoUrl']({
						actionUrl: location,
						actionName: action,
						actionDesc: mw.html.escape($.msg('chat-user-menu-' + action))
					})
				);
			}

			menuActions.append(regularActions);
		}

		// admin actions
		if (actions.admin && actions.admin.length) {
			adminActions = ul.clone().addClass('admin-actions');

			for (i in actions.admin) {
				action = actions.admin[i];

				adminActions.append(
					this.actionTemplateNoUrl({
						actionName: action,
						actionDesc: mw.html.escape($.msg('chat-user-menu-' + action))
					})
				);
			}

			menuActions.append($('<hr>').addClass('separator'));
			menuActions.append(adminActions);
		}

		// Is the menu falling below the viewport? If so, move it!
		if (parseInt(menu.css('top')) + menu.outerHeight() > $(window).height()) {
			menu.css('top', $(window).height() - menu.outerHeight());
		}

		// Add chat-mod class if necessary
		$element.hasClass('chat-mod') ? menu.addClass('chat-mod') : menu.removeClass('chat-mod');

		menu.show();

		// Bind event handler to body to close the menu
		$('body').bind('click.menuclose', function (event) {
			if (!$(event.target).closest('#UserStatsMenu').length) {
				$('#UserStatsMenu').hide();
				$('body').unbind('.menuclose');
			}
			;
		});

		// Handle clicking the profile and contrib links

		menu.find('.talk-page').add('.contribs').add('.message-wall').click(function (event) {
			var target = $(event.currentTarget),
				menu = target.closest('.UserStatsMenu'),
				username = menu.find('.username').text(),
				location = '';

			event.preventDefault();
			if (target.hasClass('talk-page') || target.hasClass('message-wall')) {
				location = window.wgChatPathToProfilePage.replace('$1', username);
			} else if (target.hasClass('contribs')) {
				location = window.wgChatPathToContribsPage.replace('$1', username);
			}

			window.open(location);
			menu.hide();
		});
	},
	hideMenu: function () {
		$('#UserStatsMenu').hide();
	}
});

/*
 * add method to Backbone to give possibility to export events to controller
 */
Backbone.View.prototype.delegateEventsToTrigger = function (events, preProcess) {
	var key,
		event,
		view;

	for (key in events) {
		event = events[key];
		view = this;

		this[event] = (function (event) {
			return function (e) {
				view.trigger(event, preProcess(e));
			};
		})(event);
	}

	this.delegateEvents(this.triggerEvents);
};
