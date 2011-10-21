<?php
class PlacesHookHandler {

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

		$storage = F::build('PlaceStorage', array($out->getTitle()), 'newFromTitle');
		$model = $storage->getModel();

		// TODO: add check
		$out->addMeta('geo.position', implode(',', $model->getLatLon()));

		wfProfileOut(__METHOD__);
		return true;
	}
}
