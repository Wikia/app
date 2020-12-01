<?php

class FandomComMigrationHooks {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		global $wgDisableUCPMigrationBanner;
		if ( empty( $wgDisableUCPMigrationBanner ) ) {
			$out->addModules( 'ext.fandomComMigration' );
		}

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgFandomComMigrationDone, $wgFandomComMigrationCustomMessageBefore,
			   $wgFandomComMigrationCustomMessageAfter, $wgDomainMigrationScheduled,
			   $wgDomainMigrationDone, $wgDisableUCPMigrationBanner;

		if ( $wgDomainMigrationScheduled || $wgDomainMigrationDone ) {
			$domainMigrationMessageKey = null;
			if ( $wgDomainMigrationScheduled ) {
				$domainMigrationMessageKey = 'ucp-migration-banner-fandom-message-scheduled-fandom-wikis';
			}
			if ( $wgDomainMigrationDone ) {
				$domainMigrationMessageKey = 'ucp-migration-banner-fandom-message-complete';
			}

			if ( !is_null( $domainMigrationMessageKey ) ) {
				$wikiVariables['domainMigrationBannerMessage'] =
					wfMessage( $domainMigrationMessageKey )->parse();
				$wikiVariables['domainMigrationScheduled'] = $wgDomainMigrationScheduled;
				$wikiVariables['domainMigrationDone'] = $wgDomainMigrationDone;
			}
		}

		if ( empty( $wgDisableUCPMigrationBanner ) ) {
			$wikiVariables['fandomComMigrationNotificationBefore'] =
				wfMessage( 'fandom-ucp-migration-before' )->parse();
		}

		return true;
	}

	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		global $wgDomainMigrationScheduled, $wgDomainMigrationDone, $wgDisableUCPMigrationBanner;
		if ( empty( $wgDisableUCPMigrationBanner ) || $wgDomainMigrationScheduled || $wgDomainMigrationDone ) {
			$jsAssets[] = 'fandom_com_migration_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgDomainMigrationScheduled, $wgDomainMigrationDone, $wgDisableUCPMigrationBanner;
		if ( empty( $wgDisableUCPMigrationBanner ) || $wgDomainMigrationScheduled || $wgDomainMigrationDone ) {
			$parser = ParserPool::get();
			global $wgFandomComMigrationDone, $wgFandomComMigrationCustomMessageBefore,
				   $wgFandomComMigrationCustomMessageAfter;

			$vars['wgFandomComMigrationScheduled'] = empty( $wgDisableUCPMigrationBanner );
			$vars['wgFandomComMigrationDone'] = false;
			$vars['wgFandomComMigrationCustomMessageBefore'] = $parser->parse(
				$wgFandomComMigrationCustomMessageBefore, new Title(), new ParserOptions() )->getText();
			$vars['wgFandomComMigrationCustomMessageAfter'] = $parser->parse(
				$wgFandomComMigrationCustomMessageAfter, new Title(), new ParserOptions() )->getText();
			$vars['wgDomainMigrationScheduled'] = $wgDomainMigrationScheduled;
			$vars['wgDomainMigrationDone'] = $wgDomainMigrationDone;
		}

		return true;
	}
}
