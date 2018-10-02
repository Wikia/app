<?php

class FandomComMigrationHooks {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( static::isEnabled() ) {
			$out->addModules( 'ext.fandomComMigration' );
		}

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgFandomComMigrationDate, $wgFandomComMigrationDone;

		// Send HTML instead of message key to avoid the issue of non-compatible i18n libs
		if ( $wgFandomComMigrationDone ) {
			$wikiVariables['fandomComMigrationNotificationAfter'] =
				wfMessage( 'fandom-com-migration-after' )->parse();
		} else if ( !empty( $wgFandomComMigrationDate ) ) {
			$wikiVariables['fandomComMigrationNotificationBefore'] =
				wfMessage( 'fandom-com-migration-before' )
					->params( $wgFandomComMigrationDate )
					->parse();
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
