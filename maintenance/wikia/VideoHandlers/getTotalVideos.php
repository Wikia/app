<?php
/**
 * Get the number of videos for the provider
 * This is one time use script
 * @author Saipetch Kongkatong
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class GetTotalVideos
 */
class GetTotalVideos extends Maintenance
{
	public function __construct()
	{
		parent::__construct();
		$this->mDescription = "Get total videos by provider";
		$this->addOption('providers', 'List of providers (comma separated)', false, true, 'p');
	}

	public function execute()
	{
		$providers = $this->getOption( 'providers', '' );
		if ( empty( $providers ) ) {
			echo "Error: Invalid providers\n";
			exit;
		}

		$app = F::app();
		echo "Checking wiki: {$app->wg->DBname} (ID: {$app->wg->CityId})\n";

		$providerList = array_map( 'trim', explode( ',', $providers ) );
		$videos = $this->getVideos( $providerList );
		if ( empty( $videos ) ) {
			$videos = array_fill_keys( $providerList, 0 );
		}

		$msg = [];
		foreach( $videos as $provider => $count ) {
			$msg[] = "$provider = $count";
		}

		echo "[Wiki: {$app->wg->CityId}, {$app->wg->DBname}] Total videos: ".array_sum( $videos )." (".implode(', ', $msg).").\n";
	}

	/**
	 * Get total videos for the providers
	 * @param array $providerList
	 * @return array
	 */
	private function getVideos( $providerList ) {
		$db = wfGetDB( DB_SLAVE );
		$query = ( new WikiaSQL() )->cache( 5 )
			->SELECT( 'provider' )
				->FIELD( 'premium' )
				->FIELD( 'count(*) cnt' )
			->FROM( 'video_info' )
			->WHERE( 'removed' )->EQUAL_TO( 0 )
				->AND_( 'provider' )->IN( $providerList )
			->GROUP_BY( 'provider, premium' )
			->ORDER_BY( 'provider, premium' );

		$videos = $query->runLoop( $db, function( &$videos, $row ) {
			$premium = ($row->premium == 1) ? 'premium' : 'direct';
			$videos[$row->provider.'-'.$premium] = $row->cnt;
		});

		return $videos;
	}
}

$maintClass = "GetTotalVideos";
require_once( RUN_MAINTENANCE_IF_MAIN );

