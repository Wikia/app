/* global Wall:true, Observable */
(function ($, mw) {
	'use strict';

	Wall.BackendBridge = $.createClass(Observable, {
		pageController: 'WallExternalController',
		bucky: window.Bucky('Wall.BackendBridge'),

		loadPage: function (page, pagenumber, callback) {
			this.bucky.timer.start('loadPage');

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'getCommentsPage',
				format: 'json',
				data: {
					page: pagenumber,
					pagetitle: page.title,
					pagenamespace: page.namespace
				},
				callback: this.proxy(function (data) {
					var html = data.html,
						page = $('.comments, .ThreadList', html),
						pagination = $('.Pagination', html);

					if ($.isFunction(callback)) {
						callback(page, pagination);
					}

					this.fire('pageLoaded', page, pagination);
					this.bucky.timer.stop('loadPage');
				})
			});
		},

		/**
		 * relatedTopics - nullable or empty array
		 * boardId - nullable
		 */
		postNew: function (page, title, body, convertToFormat, notifyEveryone, relatedTopics, successCallback, failCallback) {
			this.bucky.timer.start('postNew');

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'postNewMessage',
				type: 'POST',
				data: {
					body: body,
					messagetitle: title,
					notifyeveryone: notifyEveryone,
					pagetitle: page.title,
					pagenamespace: page.namespace,
					convertToFormat: convertToFormat,
					relatedTopics: relatedTopics,
					token: mw.user.tokens.get('editToken')
				}
			}).done(this.proxy(function (data) {
				var newmsg = $(data.message);

				if ($.isFunction(successCallback)) {
					successCallback(newmsg);
				}
				this.fire('newPosted', newmsg);
			})).fail(this.proxy(function (data) {
				if ($.isFunction(failCallback)) {
					failCallback(data);
				}
			})).always(this.proxy(function(){
				this.bucky.timer.stop('postNew');
			}));
		},

		postReply: function (page, body, convertToFormat, parent, quotedFrom, successCallback, failCallback) {
			this.bucky.timer.start('postReply');

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'replyToMessage',
				type: 'POST',
				data: {
					body: body,
					parent: parent,

					pagetitle: page.title,
					pagenamespace: page.namespace,
					convertToFormat: convertToFormat,
					quotedFrom: quotedFrom || '',
					token: mw.user.tokens.get('editToken')
				}
			}).done(this.proxy(function (data) {
				var newMessage = $(data.message);

				if ($.isFunction(successCallback)) {
					successCallback(newMessage);
				}

				this.fire('postReply', newMessage);
			})).fail(this.proxy(function (data) {
				if ($.isFunction(failCallback)) {
					failCallback(data);
				}
			})).always(this.proxy(function () {
				this.bucky.timer.stop('postReply');
			}));
		},

		loadEditData: function (page, id, mode, convertToFormat, callback) {
			this.bucky.timer.start('loadEditData');

			this.fire('beforeEditDataLoad', id);

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'editMessage',
				format: 'json',
				data: {
					msgid: id,
					pagetitle: page.title,
					pagenamespace: page.namespace,
					convertToFormat: convertToFormat
				},
				callback: this.proxy(function (data) {

					// backend error lets reload the page
					if (data.status === false && data.forcereload === true) {
						var url = window.location.href;

						if (url.indexOf('#') >= 0) {
							url = url.substring(0, url.indexOf('#'));
						}

						// we're about to navigate away so let's send bucky data right away
						this.bucky.timer.stop('loadEditData');
						this.bucky.flush();
						window.location.href = url + '?reload=' + Math.floor(Math.random() * 999);
						return;
					}

					data.mode = mode;
					data.id = id;

					if ($.isFunction(callback)) {
						callback(data);
					}

					this.fire('editDataLoaded', data);

					// resolve profiling in case we didn't navigate away
					this.bucky.timer.stop('loadEditData');
				})
			});
		},

		saveEdit: function (page, id, title, body, isreply, convertToFormat, successCallback, failCallback) {
			this.bucky.timer.start('saveEdit');

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'editMessageSave',
				format: 'json',
				type: 'POST',
				data: {
					msgid: id,
					newtitle: title,
					newbody: body,
					isreply: isreply,
					pagetitle: page.title,
					pagenamespace: page.namespace,
					convertToFormat: convertToFormat,
					token: mw.user.tokens.get('editToken')
				}
			}).done(this.proxy(function (data) {
				if ($.isFunction(successCallback)) {
					successCallback(data);
				}
				this.fire('editSaved', data);
			})).fail(this.proxy(function (data) {
				if ($.isFunction(failCallback)) {
					failCallback(data);
				}
			})).always(this.proxy(function () {
				this.bucky.timer.stop('saveEdit');
			}));
		},

		switchWatch: function (element, isWatched, commentId, callback) {
			var buckyString = 'switchWatch.' + (isWatched ? 'unfollow' : 'follow');
			this.bucky.timer.start(buckyString);

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'switchWatch',
				format: 'json',
				type: 'POST',
				data: {
					isWatched: isWatched,
					commentId: commentId,
					token: mw.user.tokens.get('editToken')
				},
				callback: this.proxy(function (data) {
					if ($.isFunction(callback)) {
						callback(element, data);
					}

					this.fire('afterSwitchWatch', element, data);
					this.bucky.timer.stop(buckyString);
				})
			});
		},

		notifyEveryone: function (msgid, dir, callback) {
			this.bucky.timer.start('notifyEveryone');

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'notifyEveryoneSave',
				format: 'json',
				type: 'POST',
				data: {
					msgid: msgid,
					dir: dir,
					token: mw.user.tokens.get('editToken')
				},
				callback: this.proxy(function (data) {
					if ($.isFunction(callback)) {
						callback(data);
					}

					this.fire('notifyEveryoneSaved', data);
					this.bucky.timer.stop('notifyEveryone');
				})
			});
		},

		updateTopics: function (msgid, relatedTopics, callback) {
			this.bucky.timer.start('updateTopics');

			$.nirvana.sendRequest({
				controller: this.pageController,
				method: 'updateTopics',
				format: 'json',
				type: 'POST',
				data: {
					msgid: msgid,
					relatedTopics: relatedTopics,
					token: mw.user.tokens.get('editToken')
				},
				callback: this.proxy(function (json) {
					if ($.isFunction(callback)) {
						callback(json);
					}
					this.bucky.timer.stop('updateTopics');
				})
			});
		}
	});
})(jQuery, mediaWiki);
