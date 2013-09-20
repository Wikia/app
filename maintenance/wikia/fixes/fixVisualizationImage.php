<?php
require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class FixVisualizationImage extends Maintenance {
	public function execute() {
		$app = F::app();

		$dbr = wfGetDB( DB_MASTER, array(), $app->wg->ExternalSharedDB );
		$rows = $dbr->select(
			array( 'city_visualization' ),
			array( 'city_id', 'city_main_image', 'city_images' ),
			array(
				'city_lang_code' => $app->wg->ContLang->getCode(),
				'city_main_image is not null'
			),
			__METHOD__
		);


		$i = 0;
		while ($row = $rows->fetchRow()) {
			$row['city_images'] = json_decode($row['city_images'], true);
			$title = Title::newFromText($row['city_main_image'], NS_FILE);
			$file = wffindFile($title);


			if ($file && $file->isMissing()) {

				$t = GlobalTitle::newFromText('Wikia-Visualization-Main.png', NS_FILE, $row['city_id']);

				$task = new PromoteImageReviewTask();

				var_dump($t->getArticleID(), $row['city_main_image'], $app->wg->cityId, $row['city_id']);

				$res = $task->uploadSingleImage($t->getArticleID(), 'Wikia-Visualization-Main.png', $app->wg->cityId, $row['city_id']);

				var_dump($res);

				$i++;
			}

			if (is_array($row['city_images'])) {

				foreach($row['city_images'] as $imageName) {
					$imageIndex = str_replace('Wikia-Visualization-Add-', '', $imageName);
					$imageIndex = substr($imageIndex, 0, 1);

					$title = Title::newFromText($imageName, NS_FILE);
					$file = wffindFile($title);
					if ($file && $file->isMissing()) {

						$t = GlobalTitle::newFromText("Wikia-Visualization-Add-$imageIndex.png", NS_FILE, $row['city_id']);
						$task = new PromoteImageReviewTask();
						var_dump($t->getArticleID(), "Wikia-Visualization-Add-$imageIndex.png", $app->wg->cityId, $row['city_id']);
						$res = $task->uploadSingleImage($t->getArticleID(), "Wikia-Visualization-Add-$imageIndex.png", $app->wg->cityId, $row['city_id']);

						var_dump($res);
					}
				}
			}


		}
		var_dump($i);

	}
}

$maintClass = "FixVisualizationImage";
require_once( DO_MAINTENANCE );