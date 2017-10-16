/**
 * Module to execute quick tool actions from a popup menu
 *
 * @author Grunny
 */
/*global jQuery, mediaWiki, alert */
(function ($, mw, window) {
	'use strict';

	var QuickTools = {
		init: function () {
			var $quickToolsLink = $('#contentSub').find('#quicktools-link');
			if ($quickToolsLink.length) {
				this.userName = $quickToolsLink.data('username');
				$quickToolsLink.click(this.showModal.bind(this));
			}
		},

		showModal: function () {
			$.nirvana.sendRequest({
				controller: 'QuickToolsController',
				method: 'quickToolsModal',
				format: 'html',
				data: {
					username: this.userName
				},
				callback: function (data) {
					var $quickToolsModalWrapper = $(data).makeModal({
							'width': 320
						}),
						$quickToolsModal = $quickToolsModalWrapper.find('#QuickToolsModal');

					$quickToolsModal.find('.quicktools-action').click(function (e) {
						var $action = $(e.target),
							doRollback = $action.data('rollback') === 1,
							doDelete = $action.data('delete') === 1,
							doBlock = $action.data('block') === 1,
							addOrRemoveBot = $action.data('bot');

						if (addOrRemoveBot) {
							this.botFlag(addOrRemoveBot);
						}
						if (doRollback || doDelete) {
							this.doRevert(doRollback, doDelete);
						}
						if (doBlock) {
							this.doBlock();
						}
						if (addOrRemoveBot !== 'add') {
							$quickToolsModalWrapper.closeModal();
						}
					}.bind(this));
				}.bind(this)
			});
		},

		doRevert: function (doRollback, doDeletes) {
			var $quickToolsModal = $('#QuickToolsModal'),
				time = $quickToolsModal.find('#quicktools-time').val(),
				summary = $quickToolsModal.find('#quicktools-reason').val(),
				botRevert = mw.util.getParamValue('bot'),
				data = {
					target: this.userName,
					time: time,
					summary: summary,
					dorollback: doRollback,
					dodeletes: doDeletes,
					markbot: botRevert,
					token: mw.user.tokens.get('editToken')
				};

			this.sendRequest('revertAll', data);
		},

		doBlock: function () {
			var $quickToolsModal = $('#QuickToolsModal'),
				blockLength = $quickToolsModal.find('#quicktools-block-length').val(),
				summary = $quickToolsModal.find('#quicktools-reason').val(),
				data = {
					target: this.userName,
					length: blockLength,
					summary: summary,
					token: mw.user.tokens.get('editToken')
				};

			this.sendRequest('blockUser', data);
		},

		sendRequest: function (methodName, data) {
			$.nirvana.sendRequest({
				controller: 'QuickToolsController',
				method: methodName,
				data: data,
				callback: function (data) {
					if (data.success === true && data.message) {
						alert(data.message);
						this.refreshContribContent();
					} else if (data.error) {
						alert(data.error);
					}
				}.bind(this)
			});
		},

		botFlag: function (addOrRemove) {
			var userName = mw.config.get('wgUserName'),
				addRights = (addOrRemove === 'add' ? 'bot' : ''),
				removeRights = (addOrRemove === 'remove' ? 'bot' : '');

			this.changeRights(userName, addRights, removeRights, mw.msg('quicktools-bot-reason'));
		},

		getUserRightsToken: function (userName) {
			var deferred = $.Deferred(),
				token;

			$.getJSON(mw.util.wikiScript('api'), {
				action: 'query',
				list: 'users',
				ususers: userName,
				ustoken: 'userrights',
				format: 'json'
			}).done(function (data) {
				token = data.query.users[0].userrightstoken;
				deferred.resolve(token);
			});

			return deferred.promise();
		},

		changeRights: function (userName, addRights, removeRights, summary) {
			this.getUserRightsToken(userName).done(function (token) {
				$.ajax({
					type: 'POST',
					url: mw.util.wikiScript('api'),
					dataType: 'json',
					data: {
						action: 'userrights',
						user: userName,
						add: addRights,
						remove: removeRights,
						reason: summary,
						format: 'json',
						token: token
					}
				}).done(function (data) {
					if (data.error) {
						alert(mw.message('quicktools-adopt-error').escaped());
					} else {
						alert(mw.message('quicktools-adopt-success').escaped());
						if (addRights === 'bot') {
							$('#QuickToolsModal')
								.find('#quicktools-bot')
								.attr('data-bot', 'remove')
								.text(mw.msg('quicktools-botflag-remove'));
						}
					}
				}).fail(function () {
					alert(mw.message('quicktools-adopt-error').escaped());
				});
			});
		},

		refreshContribContent: function () {
			$('#mw-content-text').load(window.location.href + ' #mw-content-text > *');
		}
	};

	$(function () {
		QuickTools.init();
	});
}(jQuery, mediaWiki, this));
