require([
	'mw',
	'wikia.cache',
	'BannerNotification'
], function (
	mw,
	cache,
	BannerNotification
) {

	var forumMigrationMessageClosedCacheKey = 'forum-migration-message-closed';

	if (cache.get(forumMigrationMessageClosedCacheKey) !== '1') {
		var notification = new BannerNotification(mw.message('forum-to-discussions-migration-message'), 'warn');

		notification.onCloseHandler = function () {
			cache.set(forumMigrationMessageClosedCacheKey, '1', 60 * 60 * 24 * 365);
		};

		notification.show();
	}
});
