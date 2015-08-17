/**
 * Ajax Quick Adopt
 * Adds a button to the contribs page that allows staff who handle adoption requests to give rights with one click.
 * Also, attempts to create the staff member's user page when the rights change has succeeded.
 *
 * @author Grunny
 */
/*global jQuery, mediaWiki, window*/
(function ($, mw, window) {
	'use strict';

	var QuickAdopt = {

		init: function () {
			var $adoptLink = $('#contentSub').find('#quicktools-adopt-link'),
				userName;

			if ($adoptLink.length) {
				userName = $adoptLink.data('username');

				$adoptLink.click(function () {
					$.confirm({
						title: mw.message('quicktools-adopt-confirm-title').escaped(),
						content: mw.message('quicktools-adopt-confirm').escaped(),
						cancelMsg: mw.message('quicktools-adopt-confirm-cancel').escaped(),
						okMsg: mw.message('quicktools-adopt-confirm-ok').escaped(),
						width: 400,
						onOk: this.grantRights.bind(this, userName)
					});
				}.bind(this));
			}
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

		grantRights: function (userName) {
			var addRights = 'sysop|bureaucrat',
				self = this;

			this.getUserRightsToken(userName).done(function (token) {
				$.ajax({
					type: 'POST',
					url: mw.util.wikiScript('api'),
					dataType: 'json',
					data: {
						action: 'userrights',
						user: userName,
						add: addRights,
						reason: mw.msg('quicktools-adopt-reason'),
						format: 'json',
						token: token
					}
				}).done(function (data) {
					if (data.error) {
						self.showResult('error', 'quicktools-adopt-error');
					} else {
						self.showResult('ok', 'quicktools-adopt-success');
						mw.QuickCreateUserPage.createUserPage();
					}
				}).fail(function () {
					self.showResult('error', 'quicktools-adopt-error');
				});
			});
		},

		showResult: function (result, message) {
			if (mw.config.get('skin') === 'monobook') {
				mw.util.$content.prepend(
					$('<div>').addClass(result === 'error' ? 'errorbox' : 'successbox').append(
						$('<p>').append(
							$('<img class="sprite">')
							.attr('src', mw.config.get('wgBlankImgUrl'))
							.addClass(result),
							mw.message(message).escaped()
						)
					),
					'<div class="visualClear"></div>'
				);
			} else {
				var resultClass = (result === 'error' ? 'error' : 'confirm');
				new window.BannerNotification(mw.message(message).escaped(), resultClass).show();
			}
		}
	};

	$(function () {
		QuickAdopt.init();
	});

}(jQuery, mediaWiki, window));
