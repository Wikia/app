<?php

class WikiaOrgMigrationHooks {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( static::isEnabled() ) {
			$out->addModules( 'ext.wikiaOrgMigration' );
		}

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgWikiaOrgMigrationDone, $wgWikiaOrgMigrationCustomMessageBefore,
			   $wgWikiaOrgMigrationCustomMessageAfter;

		if ( static::isEnabled() ) {
			$parser = ParserPool::get();
			// Send HTML instead of message key to avoid the issue of non-compatible i18n libs
			if ( $wgWikiaOrgMigrationDone ) {
				if ( !empty( $wgWikiaOrgMigrationCustomMessageAfter ) ) {  // customized message
					$wikiVariables['wikiaOrgMigrationNotificationAfter'] = $parser->parse(
						$wgWikiaOrgMigrationCustomMessageAfter, new Title(), new ParserOptions() )->getText();
				} else {
					$wikiVariables['wikiaOrgMigrationNotificationAfter'] =
						wfMessage( 'wikia-org-migration-after' )->parse();
				}
			} elseif ( static::isMigrationScheduled() ) {
				if ( !empty( $wgWikiaOrgMigrationCustomMessageBefore ) ) {  // customized message
					$wikiVariables['wikiaOrgMigrationNotificationBefore'] = $parser->parse(
						$wgWikiaOrgMigrationCustomMessageBefore, new Title(), new ParserOptions() )->getText();
				} else {
					$wikiVariables['wikiaOrgMigrationNotificationBefore'] =
						wfMessage( 'wikia-org-migration-before' )
							->parse();
				}
			}
		}

		return true;
	}

	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		if ( static::isEnabled() ) {
			$jsAssets[] = 'wikia_org_migration_js';
		}

		return true;
	}

	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		if ( static::isEnabled() ) {
			$parser = ParserPool::get();
			global $wgWikiaOrgMigrationDone, $wgWikiaOrgMigrationCustomMessageBefore,
				   $wgWikiaOrgMigrationCustomMessageAfter;

			$vars['wgWikiaOrgMigrationScheduled'] = static::isMigrationScheduled();
			$vars['wgWikiaOrgMigrationDone'] = $wgWikiaOrgMigrationDone;
			$vars['wgWikiaOrgMigrationCustomMessageBefore'] = $parser->parse(
				$wgWikiaOrgMigrationCustomMessageBefore, new Title(), new ParserOptions() )->getText();
			$vars['wgWikiaOrgMigrationCustomMessageAfter'] = $parser->parse(
				$wgWikiaOrgMigrationCustomMessageAfter, new Title(), new ParserOptions() )->getText();
		}

		return true;
	}

	private static function isEnabled() {
		global $wgDomainChangeDate, $wgWikiaOrgMigrationDone;

		if ( $wgWikiaOrgMigrationDone && !empty( $wgDomainChangeDate ) ) {
			$migrationDateTime = new DateTime( $wgDomainChangeDate );
			$weekAgo = ( new DateTime() )->sub( new DateInterval( 'P7D' ) );

			return $migrationDateTime > $weekAgo;
		}

		return static::isMigrationScheduled();
	}

	/**
	 * Check if the "migration scheduled" banner should be displayed.
	 *
	 * The banner will be displayed if either $wgWikiaOrgMigrationScheduled is true
	 * or the following criteria are met:
	 *     - It is not a wikia.org already wiki
	 *     - It is not a single subdomain non-English wiki
	 *     - It is not in the wiki verticals "Other" or "Lifestyle"
	 *
	 * @return boolean
	 */
	private static function isMigrationScheduled(): bool {
		global $wgWikiaOrgMigrationScheduled, $wgWikiaOrgMigrationScheduled, $wgCityId, $wgServer, $wgLanguageCode;
		$hubService = WikiFactoryHub::getInstance();

		return empty( $wgWikiaOrgMigrationScheduled ) &&
			(
				!empty( $wgWikiaOrgMigrationScheduled )
				|| !wfHttpsEnabledForURL( $wgServer )
			);
	}
}
