(function($) {

Wall.BackendBridge = $.createClass(Observable, {
	pageController: 'WallExternalController',

	loadPage: function(page, pagenumber, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'getCommentsPage',
			format: 'json',
			data: {
				page: pagenumber,
				pagetitle: page['title'],
				pagenamespace: page['namespace']
			},
			callback: this.proxy(function(data) {
				var html = data.html,
					page = $('.comments, .ThreadList', html),
					pagination = $('.Pagination', html);

				if ($.isFunction(callback)) {
					callback(page, pagination);
				}

				this.fire('pageLoaded', page, pagination);
			})
		});
	},

	postNew: function(page, title, body, convertToFormat, notifyEveryone, relatedTopics, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'postNewMessage',
			data: {
				body: body,
				messagetitle: title,
				notifyeveryone: notifyEveryone,
				pagetitle: page['title'],
				pagenamespace: page['namespace'],
				convertToFormat: convertToFormat,
				relatedTopics: relatedTopics
			},
			callback: this.proxy(function(data) {
				var newmsg = $(data.message);

				if ($.isFunction(callback)) {
					callback(newmsg);
				}

				this.fire('newPosted', newmsg);
			})
		});
	},

	postReply: function(page, body, convertToFormat, parent, quotedFrom, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'replyToMessage',
			data: {
				body: body,
				parent: parent,

				pagetitle: page['title'],
				pagenamespace: page['namespace'],
				convertToFormat: convertToFormat,
				quotedFrom: quotedFrom || ''
			},
			callback: this.proxy(function(data) {
				var newMessage = $(data.message);

				if ($.isFunction(callback)) {
					callback(newMessage);
				}

				this.fire('postReply', newMessage);
			})
		});
	},

	loadEditData: function(page, id, mode, convertToFormat, callback) {
		this.fire('beforeEditDataLoad', id);

		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'editMessage',
			format: 'json',
			data: {
				msgid: id,
				pagetitle: page['title'],
				pagenamespace: page['namespace'],
				convertToFormat: convertToFormat
			},
			callback: this.proxy(function(data) {

				// backend error lets reload the page
				if (data.status == false && data.forcereload == true) {
					var url = window.location.href;

					if (url.indexOf('#') >= 0) {
						url = url.substring(0, url.indexOf('#'));
					}

					window.location.href = url + '?reload=' + Math.floor(Math.random() * 999);
				}

				data.mode = mode;
				data.id = id;

				if ($.isFunction(callback)) {
					callback(data);
				}

				this.fire('editDataLoaded', data);
			})
		});
	},

	saveEdit: function(page, id, title, body, isreply, convertToFormat, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'editMessageSave',
			format: 'json',
			data: {
				msgid: id,
				newtitle: title,
				newbody: body,
				isreply: isreply,
				pagetitle: page['title'],
				pagenamespace: page['namespace'],
				convertToFormat: convertToFormat
			},
			callback: this.proxy(function(data) {
				if ($.isFunction(callback)) {
					callback(data);
				}

				this.fire('editSaved', data);
			})
		});
	},

	switchWatch: function(element, isWatched, commentId, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'switchWatch',
			format: 'json',
			data: {
				isWatched: isWatched,
				commentId: commentId
			},
			callback: this.proxy(function(data) {
				if ($.isFunction(callback)) {
					callback(element, data);
				}

				this.fire('afterSwitchWatch', element, data);
			})
		});
	},

	notifyEveryone: function(msgid, dir, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'notifyEveryoneSave',
			format: 'json',
			data: {
				msgid: msgid,
				dir: dir
			},
			callback: this.proxy(function(data) {
				if ($.isFunction(callback)) {
					callback(data);
				}

				this.fire('notifyEveryoneSaved', data);
			})
		});
	},
	
	updateTopics: function(msgid, relatedTopics, callback) {
		$.nirvana.sendRequest({
			controller: this.pageController,
			method: 'updateTopics',
			format: 'json',
			data: {
				msgid: msgid,
				relatedTopics: relatedTopics
			},
			type: 'post',
			callback: function(json) {
				if ($.isFunction(callback)) {
					callback(json);
				}
			}
		});
	}
});

})(jQuery);
