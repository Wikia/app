require([
	'jquery',
	'mw',
	'wikia.cache',
	'BannerNotification'
], function (
	$,
	mw,
	cache,
	BannerNotification
) {
	'use strict';

	var wgFandomComMigrationScheduled = mw.config.get('wgFandomComMigrationScheduled');
	var wgFandomComMigrationDone = mw.config.get('wgFandomComMigrationDone');
	var wgFandomComMigrationCustomMessageBefore = mw.config.get('wgFandomComMigrationCustomMessageBefore');
	var wgFandomComMigrationCustomMessageAfter = mw.config.get('wgFandomComMigrationCustomMessageAfter');
	var wgDomainMigrationScheduled = mw.config.get('wgDomainMigrationScheduled');
	var wgDomainMigrationDone = mw.config.get('wgDomainMigrationDone');

	var afterMigrationClosedStorageKey = 'fandom-com-migration-after-closed';
	var beforeMigrationClosedStorageKey = 'fandom-com-migration-before-closed';
	var ucpDomainMigrationScheduledMessageKey = 'ucp-migration-banner-fandom-message-scheduled-fandom-wikis';
	var ucpDomainMigrationDoneMessageKey = 'ucp-migration-banner-fandom-message-complete';
	var storageTrueValue = '1';

	// Keep it for a year, it's more than enough
	var localStorageTTL = 60 * 60 * 24 * 365;

	function shouldShowAfterMigrationNotification() {
		return wgFandomComMigrationDone && cache.get(afterMigrationClosedStorageKey) !== storageTrueValue;
	}

	function shouldShowBeforeMigrationNotification() {
		return wgFandomComMigrationScheduled && cache.get(beforeMigrationClosedStorageKey) !== storageTrueValue;
	}

	function shouldShowDomainMigrationScheduledBannerNotification() {
		return wgDomainMigrationScheduled && cache.get(ucpDomainMigrationScheduledMessageKey) !== storageTrueValue;
	}

	function shouldShowDomainMigrationDoneBannerNotification() {
		return wgDomainMigrationDone && cache.get(ucpDomainMigrationDoneMessageKey) !== storageTrueValue;
	}

	function showAfterMigrationNotification() {
		mw.loader.using(['ext.fandomComMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				wgFandomComMigrationCustomMessageAfter ? wgFandomComMigrationCustomMessageAfter : mw.message('fandom-com-migration-after').parse(),
				'warn',
				null
			);

			banner.onCloseHandler = function () {
				cache.set(afterMigrationClosedStorageKey, storageTrueValue, localStorageTTL);
			}

			banner.show();
		});
	}

	function showBeforeMigrationNotification() {
		mw.loader.using(['ext.fandomComMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				wgFandomComMigrationCustomMessageBefore ? wgFandomComMigrationCustomMessageBefore : mw.message('fandom-ucp-migration-before').parse(),
				'warn',
				null
			);

			banner.onCloseHandler = function () {
				cache.set(beforeMigrationClosedStorageKey, storageTrueValue, localStorageTTL);
			}

			banner.show();
		});
	}

	function showPreDomainMigrationBanner() {
		mw.loader.using(['ext.fandomComMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				mw.message(ucpDomainMigrationScheduledMessageKey).parse(),
				'warn',
				null
			);

			banner.onCloseHandler = function () {
				cache.set(ucpDomainMigrationScheduledMessageKey, storageTrueValue, localStorageTTL);
			}

			banner.show();
		});
	}

	function showPostDomainMigrationBanner() {
		mw.loader.using(['ext.fandomComMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				mw.message(ucpDomainMigrationDoneMessageKey).parse(),
				'warn',
				null
			);

			banner.onCloseHandler = function () {
				cache.set(ucpDomainMigrationScheduledMessageKey, storageTrueValue, localStorageTTL);
			}

			banner.show();
		});
	}

	$(function () {
		if (shouldShowAfterMigrationNotification()) {
			showAfterMigrationNotification();
		} else if (shouldShowBeforeMigrationNotification()) {
			showBeforeMigrationNotification();
		}

		if (shouldShowDomainMigrationScheduledBannerNotification()) {
			showPreDomainMigrationBanner();
		}
		if (shouldShowDomainMigrationDoneBannerNotification()) {
			showPostDomainMigrationBanner();
		}
	});
});
