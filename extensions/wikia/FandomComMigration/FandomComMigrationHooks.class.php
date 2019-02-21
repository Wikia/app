<?php

class FandomComMigrationHooks {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( static::isEnabled() ) {
			$out->addModules( 'ext.fandomComMigration' );
		}

		return true;
	}

	public static function onMercuryWikiVariables( array &$wikiVariables ): bool {
		global $wgFandomComMigrationDone, $wgFandomComMigrationCustomMessageBefore,
			   $wgFandomComMigrationCustomMessageAfter;

		if ( static::isEnabled() ) {
			$parser = ParserPool::get();
			// Send HTML instead of message key to avoid the issue of non-compatible i18n libs
			if ( $wgFandomComMigrationDone ) {
				if ( !empty( $wgFandomComMigrationCustomMessageAfter ) ) {  // customized message
					$wikiVariables['fandomComMigrationNotificationAfter'] = $parser->parse(
						$wgFandomComMigrationCustomMessageAfter, new Title(), new ParserOptions() )->getText();
				} else {
					$wikiVariables['fandomComMigrationNotificationAfter'] =
						wfMessage( 'fandom-com-migration-after' )->parse();
				}
			} elseif ( static::isMigrationScheduled() ) {
				if ( !empty( $wgFandomComMigrationCustomMessageBefore ) ) {  // customized message
					$wikiVariables['fandomComMigrationNotificationBefore'] = $parser->parse(
						$wgFandomComMigrationCustomMessageBefore, new Title(), new ParserOptions() )->getText();
				} else {
					$wikiVariables['fandomComMigrationNotificationBefore'] =
						wfMessage( 'fandom-com-migration-before' )
							->parse();
				}
			}
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
			$parser = ParserPool::get();
			global $wgFandomComMigrationDone, $wgFandomComMigrationCustomMessageBefore,
				   $wgFandomComMigrationCustomMessageAfter;

			$vars['wgFandomComMigrationScheduled'] = static::isMigrationScheduled();
			$vars['wgFandomComMigrationDone'] = $wgFandomComMigrationDone;
			$vars['wgFandomComMigrationCustomMessageBefore'] = $parser->parse(
				$wgFandomComMigrationCustomMessageBefore, new Title(), new ParserOptions() )->getText();
			$vars['wgFandomComMigrationCustomMessageAfter'] = $parser->parse(
				$wgFandomComMigrationCustomMessageAfter, new Title(), new ParserOptions() )->getText();
		}

		return true;
	}

	private static function isEnabled() {
		global $wgDomainChangeDate, $wgFandomComMigrationDone;

		if ( $wgFandomComMigrationDone && !empty( $wgDomainChangeDate ) ) {
			$migrationDateTime = new DateTime( $wgDomainChangeDate );
			$weekAgo = ( new DateTime() )->sub( new DateInterval( 'P7D' ) );

			return $migrationDateTime > $weekAgo;
		}

		return static::isMigrationScheduled();
	}

	/**
	 * Check if the "migration scheduled" banner should be displayed.
	 *
	 * The banner will be displayed if either $wgFandomComMigrationScheduled is true
	 * or the following criteria are met:
	 *     - It is not a fandom.com already wiki
	 *     - It is not a single subdomain non-English wiki
	 *     - It is not in the wiki verticals "Other" or "Lifestyle"
	 *
	 * @return boolean
	 */
	private static function isMigrationScheduled(): bool {
		global $wgFandomComMigrationScheduled, $wgWikiaOrgMigrationScheduled, $wgCityId, $wgServer, $wgLanguageCode;
		$hubService = WikiFactoryHub::getInstance();

		return empty( $wgWikiaOrgMigrationScheduled ) &&
			(
				!empty( $wgFandomComMigrationScheduled )
				|| !wfHttpsEnabledForURL( $wgServer )
			);
	}
}
