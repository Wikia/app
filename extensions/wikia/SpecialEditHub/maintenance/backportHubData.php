<?php

/**
 * A script to backport data that appeared in Hubs V3 to Hubs V2
 * Can be executed with any CITYID, as accesses shared db
 *
 * @author Sebastian Marzjan
 */

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

require_once( "../../../../maintenance/Maintenance.php" );

class backportHubData extends Maintenance {
	CONST LOG_FORMAT = "%12s\n%12s%12s%12s%15s%12s\n";

	static $moduleToMigrate = 6; //WikiaHubsModuleFromthecommunityService::MODULE_ID
	static $ftcHeadline = [
		'en' =>	'From the Community',
		'de' =>	'Aus der Community',
		'fr' => 'En provenance de la communauté',
		'es' => 'De la comunidad',
		'pl' => 'Od społeczności',
		'ja' => 'コミュニティーから'
	];
	static $ftcSuggest = [
		'en' =>	'Suggest an Article',
		'de' =>	'Artikel vorschlagen',
		'fr' => 'Suggérer un article',
		'es' => 'Sugerir un artículo',
		'pl' => 'Zasugeruj artykuł',
		'ja' => '記事を投稿する'
	];

	public function execute() {
		echo 'Hub backport starting: ' . ( new DateTime() )->format( "Y-m-d H:i:s" ) . PHP_EOL;
		global $wgExternalSharedDB;
		$sdb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$mdb = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$result = $sdb->select(
			'wikia_hub_modules',
			'*',
			array(
				'module_id' => self::$moduleToMigrate
			),
			array(
				'ORDER BY' => ''
			),
			__METHOD__
		);

		$changeLog = [
			sprintf(self::LOG_FORMAT,
				'Changelog',
				'city_id',
				'lang_code',
				'vertical_id',
				'hub_date',
				'module_id'
			)
		];

		while($row = $result->fetchObject()) {
			$module_data = json_decode($row->module_data);
			$rowChanged = false;

			if(empty($module_data->headline)) {
				$module_data->headline = static::$ftcHeadline[$row->lang_code];
				$rowChanged = true;
			}
			if(empty($module_data->suggest)) {
				$module_data->suggest = $module_data->suggest = static::$ftcSuggest[$row->lang_code];
				$rowChanged = true;
			}

			if($rowChanged) {
				$mdb->update(
					'wikia_hub_modules',
					array(
						'module_data' => json_encode($module_data)
					),
					array(
						'city_id' => $row->city_id,
						'lang_code' => $row->lang_code,
						'vertical_id' => $row->vertical_id,
						'hub_date' => $row->hub_date,
						'module_id' => $row->module_id
					)
				);
				$changeLog []= sprintf(self::LOG_FORMAT,
					$row->city_id,
					$row->lang_code,
					$row->vertical_id,
					$row->hub_date,
					$row->module_id
				);

			}
		}

		if(count($changeLog) > 1) {
			foreach($changeLog as $line) {
				echo $line;
			}
		}

		echo 'Hub backport ended: ' . ( new DateTime() )->format( "Y-m-d H:i:s" ) . PHP_EOL;
	}
}

$maintClass = "backportHubData";
require_once( RUN_MAINTENANCE_IF_MAIN );

