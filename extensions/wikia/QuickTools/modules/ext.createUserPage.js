/**
 * Ajax User Page Creation
 * Attempts to create a user page if it does not already exist
 *
 * @author Grunny
 */
/*global jQuery, mediaWiki, window*/
(function ($, mw, window) {
	'use strict';

	var QuickCreateUserPage = {

		init: function () {
			var $createUserPageLink;
			if (mw.config.get('skin') === 'oasis') {
				$createUserPageLink = $('#AccountNavigation').find('li > ul.subnav a[data-id="createuserpage"]');
			} else {
				$createUserPageLink = $('#column-one').find('#p-personal #pt-createuserpage');
			}
			if ($createUserPageLink.length) {
				$createUserPageLink.click(this.createUserPage.bind(this));
			}
		},

		createUserPage: function () {
			var userPageContent = window.qtUserPageTemplate || '{{w:User:' + mw.config.get('wgUserName') + '}}',
				pageName = 'User:' + mw.config.get('wgUserName'),
				self = this;

			this.checkPageExists(pageName).done(function (pageExists) {
				if (pageExists) {
					self.showResult('ok', 'quicktools-createuserpage-exists');
				} else {
					$.ajax({
						type: 'POST',
						url: mw.util.wikiScript('api'),
						dataType: 'json',
						data: {
							action: 'edit',
							title: pageName,
							summary: mw.msg('quicktools-createuserpage-reason'),
							text: userPageContent,
							format: 'json',
							token: mw.user.tokens.get('editToken')
						}
					}).done(function (data) {
						if (data.edit.result === 'Success') {
							self.showResult('ok', 'quicktools-createuserpage-success');
						} else {
							self.showResult('error', 'quicktools-createuserpage-error');
						}
					}).fail(function () {
						self.showResult('error', 'quicktools-createuserpage-error');
					});
				}
			});
		},

		checkPageExists: function (pageName) {
			var deferred = $.Deferred(),
				pageExists = false;

			$.getJSON(mw.util.wikiScript('api'), {
				action: 'query',
				prop: 'revisions',
				titles: pageName,
				format: 'json'
			}).done(function (data) {
				var pageIds = Object.keys(data.query.pages),
					pageId = pageIds[0];
				if (pageId !== '-1') {
					pageExists = true;
				}
				deferred.resolve(pageExists);
			});

			return deferred.promise();
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

	mw.QuickCreateUserPage = QuickCreateUserPage;

	$(function () {
		QuickCreateUserPage.init();
	});
}(jQuery, mediaWiki, window));
