<?php

require_once __DIR__ . '/../Maintenance.php';

class SUS5726 extends Maintenance {

	public function execute() {
		global $wgUser;
		$wgUser = User::newFromName( Wikia::BOT_USER );
		foreach ( $this->allWikis() as $wiki ) $this->updateThemeSettings( $wiki->city_id );
	}

	private function allWikis() {
		global $wgExternalSharedDB;
		return wfGetDB( DB_SLAVE, [], $wgExternalSharedDB )
			->select(
				'city_list',
				'city_id',
				[ 'city_public = 1' ],
				__METHOD__,
				[ 'ORDER BY' => 'city_id ASC' ]
			);
	}

	private function updateThemeSettings( string $wiki ) {
		$var = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wiki ) ;

		$changed = false;

		if ( ! isset( $var['background-image-height'] ) ) {
			$var['background-image-height'] = 0;
			$changed = true;
		}

		if ( ! isset( $var['background-image-width'] ) ) {
			$var['background-image-width'] = 0;
			$changed = true;
		}

		if ( $changed ) {
			if ( $this->hasOption( 'dry-run' ) ) {
				$this->output( "Wiki $wiki will be updated.\n" );
			} else {
				$this->output( "Wiki $wiki has been updated.\n" );
				WikiFactory::setVarByName( 'wgOasisThemeSettings', $wiki, $var, 'SUS-5726' );
			}
		}
	}

}

$maintClass = 'SUS5726';
require_once RUN_MAINTENANCE_IF_MAIN;
