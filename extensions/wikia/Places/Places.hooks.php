<?php
class PlacesHookHandler {

	private static $modelToSave;

	public static function setModelToSave(PlaceModel $model) {
		self::$modelToSave = $model;
	}

	public static function onOutputPageMakeCategoryLinks( $outputPage, $categories, $categoryLinks ) {
		RelatedVideos::getInstance()->setCategories( $categories );
		return true;
	}

	public static function onParserFirstCallInit(Parser $parser) {
		$parser->setHook( 'place', 'PlacesParserHookHandler::renderPlaceTag' );
		$parser->setHook( 'places', 'PlacesParserHookHandler::renderPlacesTag' );

		return true;
	}

	public static function onBeforePageDisplay(OutputPage $out, Skin $sk) {
		wfProfileIn(__METHOD__);
		$title = $out->getTitle();

		if ($title instanceof Title && $title->isContentPage()) {
			$storage = F::build('PlaceStorage', array($out->getTitle()), 'newFromTitle');
			$model = $storage->getModel();

			if ($model instanceof PlaceModel && !$model->isEmpty()) {
				$out->addMeta('geo.position', implode(',', $model->getLatLon()));
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	static public function onArticleSaveComplete(&$article, &$user, $text, $summary,
 $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId, &$redirect) {
 		wfProfileIn(__METHOD__);

		$app = F::app();
		$app->wf->Debug(__METHOD__ . "\n");

		// store queued model or clear data for the article (if no model was passed)
		$storage = F::build('PlaceStorage', array($article), 'newFromArticle');

		if (self::$modelToSave instanceof PlaceModel) {
			// use model from parser hook
			// self::$modelToSave is set in PlacesParserHookHandler::renderPlaceTag
			$storage->setModel(self::$modelToSave);
		}
		else {
			// no geo data fround - use an empty model
			$storage->setModel(F::build('PlaceModel'));
		}
		$storage->store();

		wfProfileOut(__METHOD__);
		return true;
 	}

	static public function onRTEUseDefaultPlaceholder($name, $params, $frame, $wikitextIdx) {
		if ($name !== 'place') {
			return true;
		}
		else {
			// store metadata index to be used when rendering placeholder for RTE
			PlacesParserHookHandler::$lastWikitextId = $wikitextIdx;
			return false;
		}
	}
}
