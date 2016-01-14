<?php
/**
 * Configure Wikia Mobile Apps smart banner.
 *
 * @author Mix (Michał Roszka) <mix@wikia.com>
 * @author Alistra (Aleksander Balicki) <alistra@wikia.com>
 * @ingroup Maintenance
 *
 * @example SERVER_ID=42 php ConfigureSmartBanner.php --disable
 * @example SERVER_ID=42 php ConfigureSmartBanner.php --icon http://example.com/icon.png --title 'Some text' --ios-app-id A3BD6 --android-app-id C76DF5
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class ConfigureSmartBanner extends Maintenance {

	const REASON_ENABLED  = 'Enabled Wikia Mobile Apps smart banner.';
	const REASON_DISABLED = 'Disabled Wikia Mobile Apps smart banner.';


	public function __construct() {

		parent::__construct();
		$this->mDescription = 'Configure Wikia Mobile Apps smart banner.';

		// Disable the smart banner completely.
		$this->addOption( 'disable', 'Disable the banner', false, false);

		// Enable the banner (all the options must have arguments).
		$this->addOption( 'icon', 'Icon URL', false, true );
		$this->addOption( 'title', 'Title for the banner', false, true );
		$this->addOption( 'ios-app-id', 'iOS App ID', false, true );
		$this->addOption( 'android-app-id', 'Android Application Package ID', false, true);

	}

	public function execute() {

		// Act as WikiaBot. Informative for Wikia staff in WikiFactory logs.
		F::app()->wg->user = User::newFromName( 'WikiaBot' );
		$wikiId = F::app()->wg->cityId;

		// Disable the smart banner.
		if ( $this->getOption('disable') ) {

			WikiFactory::setVarByName( 'wgEnableWikiaMobileSmartBanner', $wikiId, false, self::REASON_DISABLED )
				or $this->error( 'Failed to set wgEnableWikiaMobileSmartBanner.', 1 );

			$this->output( "Disabled smart banner for $wikiId.\n" );

			exit(0);
		}

		// Make sure that all required paramaters are set.
		if ( ! $this->getOption( 'title' ) || ! $this->getOption( 'icon' ) || ! $this->getOption( 'ios-app-id' ) || ! $this->getOption( 'android-app-id' ) ) {
			$this->error( 'Required parameters: title, icon, ios-app-id, android-app-id', 1 );
		}
		
		// Calculate the banner configuration.
		$config = [
			'disabled'	=> 0,
			'name'		=> "Wikia: {$this->getOption( 'title' )} Fan App",
			'icon'		=> $this->getOption( 'icon' ),
			'meta'		=> [
						'apple-itunes-app'	=> "app-id={$this->getOption( 'ios-app-id' )}",
						'google-play-app'	=> "app-id={$this->getOption( 'android-app-id' )}",
			],
		];

		// Try to set the banner configuration first.
		WikiFactory::setVarByName( 'wgWikiaMobileSmartBannerConfig', $wikiId, $config, self::REASON_ENABLED )
			or $this->error( 'Failed to set wgWikiaMobileSmartBannerConfig.', 1 );

		$this->output( "Set smart banner configuration for $wikiId.\n" );

		// Then, on success, try to enable the banner.
		WikiFactory::setVarByName( 'wgEnableWikiaMobileSmartBanner', $wikiId, true, self::REASON_ENABLED )
			or $this->error( 'Failed to set wgEnableWikiaMobileSmartBanner.', 1 );

		$this->output( "Enabled smart banner for $wikiId.\n" );

	}
}

$maintClass = 'ConfigureSmartBanner';
require_once RUN_MAINTENANCE_IF_MAIN;
