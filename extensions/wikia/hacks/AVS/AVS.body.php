<?php

class AVS {
	public static function parser_hook_video($input, $args, $parser) {

		$args['align'] = empty($args['align']) ? "right":$args['align'];


		$args['align'] = self::getAlign($args['align']);

		$adm = new Amazon_DataMapper();

		if(empty($args['asin'])) {
			return wfMsg('avs-no-asin');
		}

		$widget = $adm->findWidgetByAsin($args['asin']);

		if(empty($widget)) {
			return wfMsg('avs-wrong-asin');
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars(array(
		    "data" => array(
				'align' => $args['align'],
				'type' => 'video',
				'widget' => $widget
			)
		));

		return $oTmpl->render("image");
	}

	public static function parser_hook_image($input, $args, $parser) {

		$args['align'] = empty($args['align']) ? "right":$args['align'];


		$args['align'] = self::getAlign($args['align']);

		$adm = new Amazon_DataMapper();

		if(empty($args['asin'])) {
			return wfMsg('avs-no-asin');
		}

		$data = $adm->findItemByAsin($args['asin']);

		if(empty($data)) {
			return wfMsg('avs-wrong-asin');
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$data = array(
				'align' => $args['align'],
				'type' => 'image',
				'image' => $data->ImageSets->ImageSet->LargeImage->URL,
				'season' => $data->ItemAttributes->SeasonSequence,
				'episode' => $data->ItemAttributes->EpisodeSequence,
				'title' => $data->ItemAttributes->Title,
				'url' => $data->DetailPageURL
		);

		$oTmpl->set_vars(array(
		    "data" => $data
		));

		return $oTmpl->render("image");
	}

	public static function initHooks(&$parser) {
		$parser->setHook('avs_video', 'AVS::parser_hook_video');
		$parser->setHook('avs_image_link', 'AVS::parser_hook_image');
		return true;
	}


	public static function getAlign($inAlign = "") {

		$align =  'float' . $inAlign;

		if($align == 'floatcenter') {
			$align = "tnone";
		}

		return $align;
	}

}

class AVSSpecialPage extends SpecialPage {

	function __construct() {
		parent::__construct( 'AVS', '' );
	}

	function execute() {
		global $wgOut, $wgAVStag;

		$dataMaper = new Amazon_DataMapper();

		$fromAmazon = $dataMaper->findItemsByTag($wgAVStag);

		foreach( $fromAmazon as $key => $value ) {
			$data[$key]['image'] = $value->ImageSets->ImageSet->LargeImage;
			$data[$key]['season'] = $value->ItemAttributes->SeasonSequence;
			$data[$key]['episode'] = $value->ItemAttributes->EpisodeSequence;
			$data[$key]['title'] = $value->ItemAttributes->Title;
			$data[$key]['video-widget'] = $dataMaper->findWidgetByAsin($key);

			$data[$key]['video-widget-code'] = htmlspecialchars('<avs_video align="right"  asin="' . $key . '" />');
			$data[$key]['image-widget-code'] = htmlspecialchars('<avs_image_link align="right" asin="' . $key . '" />');
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$oTmpl->set_vars(array(
		    "data" => $data
		));

		$wgOut->addHTML( $oTmpl->render("list") );
	}
}
