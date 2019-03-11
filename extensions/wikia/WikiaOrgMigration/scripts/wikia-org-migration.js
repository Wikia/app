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

	var afterMigrationClosedStorageKey = 'fandom-com-migration-after-closed';
	var beforeMigrationClosedStorageKey = 'fandom-com-migration-before-closed';
	var storageTrueValue = '1';

	// Keep it for a year, it's more than enough
	var localStorageTTL = 60 * 60 * 24 * 365;

	function shouldShowAfterMigrationNotification() {
		alert("1111");
		return wgWikiaOrgMigrationDone && cache.get(afterMigrationClosedStorageKey) !== storageTrueValue;
	}

	function shouldShowBeforeMigrationNotification() {
		alert("1111");
		return wgWikiaOrgMigrationScheduled && cache.get(beforeMigrationClosedStorageKey) !== storageTrueValue;
	}

	function showAfterMigrationNotification() {
		alert("1111");
		mw.loader.using(['ext.fandomComMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				wgWikiaOrgMigrationCustomMessageAfter ? wgWikiaOrgMigrationCustomMessageAfter : mw.message('fandom-com-migration-after').parse(),
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
		alert("1111");
		mw.loader.using(['ext.fandomComMigration', 'mediawiki.jqueryMsg']).then(function () {
			var banner = new BannerNotification(
				wgWikiaOrgMigrationCustomMessageBefore ? wgWikiaOrgMigrationCustomMessageBefore : mw.message('fandom-com-migration-before').parse(),
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
