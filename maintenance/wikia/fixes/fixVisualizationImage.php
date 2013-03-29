<?php

require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class FixVisualizationImage extends Maintenance {
	public function execute() {
		$app = F::app();

		$dbr = $app->wf->GetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
		$rows = $dbr->select(
			array( 'city_visualization' ),
			array( 'city_id', 'city_main_image' ),
			array( 'city_main_image is not null' ),
			__METHOD__
		);


		$i = 0;
		while ($row = $rows->fetchRow()) {
			$title = Title::newFromText($row['city_main_image'], NS_FILE);

			$file = $app->wf->findFile($title);

			if ($file === false) {
				// TODO add re-upload code here
				var_dump($row['city_id'], $row['city_main_image']);
				$i++;
			}
		}
		var_dump($i);

	}
}

$maintClass = "FixVisualizationImage";
require_once( DO_MAINTENANCE );