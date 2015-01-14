(function (window, $, mw) {

	var follow = {

		hover: function (e) {
			$(e.target).closest('LI')
				.find('.otherNs, .ajax-unwatch')
				.css('visibility', 'visible');
		},

		unhover: function () {
			$('.otherNs, .ajax-unwatch').css('visibility', 'hidden');
		},

		uwatch: function (e) {
			var target = $(e.target),
				title = target.closest('A').attr('title'),
				li = target.closest('LI'),
				api = new mw.Api();

			// there has to be a callback supplied in the case of success although this returns
			// a promise, hence the use of $.noop
			// @todo remove second arg on completion of MAIN-2490 (backporting updates to mediawiki.api.watch)
			api.unwatch(title, $.noop).done(function () {
				li.remove();
			});

			return false;
		},

		loadStatus: {},

		showMore: function (e) {
			var $target = $(e.target),
				head = $target.data('ns'),
				user_id = $target.data('userid'),
				key = head.split('-')[3],
				cTime = new Date(),
				valueKey;

			// this used to compare against undefined and null
			// so just use non-strict comparison and check for both at the same time
			if (follow.loadStatus[key] == null) {
				valueKey = 'count-' + head;
				follow.loadStatus[key] = {
					loaded: wgFollowedPagesPagerLimit,
					toload: $('#' + valueKey).val()
				};
			}

			$.ajax({
				url: mw.util.wikiScript(),
				data: {
					action: 'ajax',
					rs: 'FollowHelper::showAll',
					head: head,
					user_id: user_id,
					from: follow.loadStatus[key].loaded,
					cb: cTime.getTime()
				},
				success: function (data) {
					follow.loadStatus[key].loaded += wgFollowedPagesPagerLimitAjax;
					if (follow.loadStatus[key].loaded >= follow.loadStatus[key].toload) {
						$target.hide();
					}

					$('#' + head).append(data);
					// VOLDEV-55
					// previously only checked for mainspace, this checks for every prefixed id
					var lis = $('[id^="wikiafollowedpages-special-heading-"]').find('li');
					lis.off().hover(follow.hover, follow.unhover);
					lis.find('.ajax-unwatch').click(follow.uwatch);
				}
			});

			return false;
		},

		syncUserPrefsEvent: function (e) {
			follow.syncUserPrefs($(e.target));
		},

		syncUserPrefs: function ($target) {
			var sync = {};

			sync['mw-input-enotifminoredits'] = 'mw-input-enotiffollowedminoredits';
			sync['mw-input-enotifwatchlistpages'] = 'mw-input-enotiffollowedpages';
			sync['mw-input-enotiffollowedminoredits'] = 'mw-input-enotifminoredits';
			sync['mw-input-enotiffollowedpages'] = 'mw-input-enotifwatchlistpages';

			$('#' + sync[$target.attr('id')]).prop('checked', $target.prop('checked'));
		}
	};

	$(function () {
		var ids = [
			'#mw-input-enotiffollowedminoredits',
			'#mw-input-enotiffollowedpages',
			'#mw-input-enotifminoredits',
			'#mw-input-enotifwatchlistpages'
		].join(',');

		$('.ajax-unwatch').click(follow.uwatch);
		$('.ajax-show-more').click(follow.showMore).show();

		$(ids).click(follow.syncUserPrefsEvent);
		follow.syncUserPrefs($('#mw-input-enotifminoredits'));
		follow.syncUserPrefs($('#mw-input-enotifwatchlistpages'));
		$('.watched-list li').hover(follow.hover, follow.unhover);
	});

	window.follow = follow;

}(this, jQuery, mediaWiki));
