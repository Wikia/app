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

	var wgWikiaOrgMigrationScheduled = mw.config.get('wgWikiaOrgMigrationScheduled');
	var wgWikiaOrgMigrationDone = mw.config.get('wgWikiaOrgMigrationDone');
	var wgWikiaOrgMigrationCustomMessageBefore = mw.config.get('wgWikiaOrgMigrationCustomMessageBefore');
	var wgWikiaOrgMigrationCustomMessageAfter = mw.config.get('wgWikiaOrgMigrationCustomMessageAfter');

	var afterMigrationClosedStorageKey = 'wikia-org-migration-after-closed';
	var beforeMigrationClosedStorageKey = 'wikia-org-migration-before-closed';
	var storageTrueValue = '1';

	// Keep it for a year, it's more than enough
	var localStorageTTL = 60 * 60 * 24 * 365;

	function shouldShowAfterMigrationNotification() {
		return wgWikiaOrgMigrationDone && cache.get(afterMigrationClosedStorageKey) !== storageTrueValue;
	}

	function shouldShowBeforeMigrationNotification() {
		return wgWikiaOrgMigrationScheduled && cache.get(beforeMigrationClosedStorageKey) !== storageTrueValue;
	}

	function showAfterMigrationNotification() {
		mw.loader.using(['ext.wikiaOrgMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				wgWikiaOrgMigrationCustomMessageAfter ? wgWikiaOrgMigrationCustomMessageAfter : mw.message('wikia-org-migration-after').parse(),
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
		mw.loader.using(['ext.wikiaOrgMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				wgWikiaOrgMigrationCustomMessageBefore ? wgWikiaOrgMigrationCustomMessageBefore : mw.message('wikia-org-migration-before').parse(),
				'warn',
				null
			);

			banner.onCloseHandler = function () {
				cache.set(beforeMigrationClosedStorageKey, storageTrueValue, localStorageTTL);
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
	});
});
