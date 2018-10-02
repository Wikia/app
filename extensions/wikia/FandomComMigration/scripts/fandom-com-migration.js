require([
	'jquery',
	'mw',
	'wikia.cache',
	'BannerNotification',
	'JSMessages'
], function (
	$,
	mw,
	cache,
	BannerNotification,
	msg
) {
	'use strict';

	var wgFandomComMigrationDate = mw.config.get('wgFandomComMigrationDate');
	var wgFandomComMigrationDone = mw.config.get('wgFandomComMigrationDone');

	var afterMigrationClosedStorageKey = 'fandom-com-migration-after-closed';
	var beforeMigrationClosedStorageKey = 'fandom-com-migration-before-closed';
	var storageTrueValue = '1';

	// Keep it for a year, it's more than enough
	var localStorageTTL = 60 * 60 * 24 * 365;

	function shouldShowAfterMigrationNotification() {
		return wgFandomComMigrationDone && cache.get(afterMigrationClosedStorageKey) !== storageTrueValue;
	}

	function shouldShowBeforeMigrationNotification() {
		return wgFandomComMigrationDate && cache.get(beforeMigrationClosedStorageKey) !== storageTrueValue;
	}

	function showAfterMigrationNotification() {
		var banner = new BannerNotification(
			msg('fandom-com-migration-after'),
			'warn',
			null
		);

		banner.onCloseHandler = function () {
			cache.set(afterMigrationClosedStorageKey, storageTrueValue, localStorageTTL);
		}

		banner.show();
	}

	function showBeforeMigrationNotification() {
		var banner = new BannerNotification(
			msg('fandom-com-migration-before', wgFandomComMigrationDate),
			'warn',
			null
		);

		banner.onCloseHandler = function () {
			cache.set(beforeMigrationClosedStorageKey, storageTrueValue, localStorageTTL);
		}

		banner.show();
	}

	$(function () {
		if (shouldShowAfterMigrationNotification()) {
			showAfterMigrationNotification();
		} else if (shouldShowBeforeMigrationNotification()) {
			showBeforeMigrationNotification();
		}
	});
});
