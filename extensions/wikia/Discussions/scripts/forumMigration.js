require([
	'mw',
	'wikia.cache',
	'BannerNotification'
], function (
	mw,
	cache,
	BannerNotification
) {

	var forumMigrationMessageToDisplay = mw.config.get('forumMigrationMessageToDisplay');

	/**
	 * possible keys:
	 * before-forum-migration-message-closed
	 * in-progress-forum-migration-message-closed
	 * after-forum-migration-message-closed
	 * @type {string}
	 */
	var forumMigrationMessageClosedCacheKey = forumMigrationMessageToDisplay + '-forum-migration-message-closed';

	if (cache.get(forumMigrationMessageClosedCacheKey) !== '1') {
		/**
		 * possible translation keys:
		 * before-forum-to-discussions-migration-message
		 * in-progress-forum-to-discussions-migration-message
		 * after-forum-to-discussions-migration-message
		 * @type {module:BannerNotification|BannerNotification|exports}
		 */
		var notification = new BannerNotification(mw.message(forumMigrationMessageToDisplay + '-forum-to-discussions-migration-message'), 'warn');

		notification.onCloseHandler = function () {
			cache.set(forumMigrationMessageClosedCacheKey, '1', 60 * 60 * 24 * 365);
		};

		notification.show();
	}
});
