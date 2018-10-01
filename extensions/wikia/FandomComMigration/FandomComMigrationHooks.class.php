<?php

class FandomComMigrationHooks {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( static::isEnabled() ) {
			JSMessages::enqueuePackage('FandomComMigration', JSMessages::EXTERNAL);
		}

		return true;
	}

	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		if ( static::isEnabled() ) {
			$jsAssets[] = 'fandom_com_migration_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		if ( static::isEnabled() ) {
			global $wgFandomComMigrationDate, $wgFandomComMigrationDone;

			$vars['wgFandomComMigrationDate'] = $wgFandomComMigrationDate;
			$vars['wgFandomComMigrationDone'] = $wgFandomComMigrationDone;
		}

		return true;
	}

	private static function isEnabled() {
		global $wgFandomComMigrationDate, $wgFandomComMigrationDone;

		return !empty( $wgFandomComMigrationDate ) || $wgFandomComMigrationDone;
	}
}
