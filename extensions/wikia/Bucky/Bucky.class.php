<?php

class Bucky {

	const DEFAULT_SAMPLING = 1; // percentage
	const BASE_URL = '//speed.wikia.net/__rum';

	static public function onSkinAfterBottomScripts( Skin $skin, &$bottomScripts ) {
		$app = F::app();
		if ( $app->checkSkin('oasis',$skin) ) {
			$wgBuckySampling = $app->wg->BuckySampling;
			$url = self::BASE_URL; // "/v1/send" is automatically appended
			$sample = (isset($wgBuckySampling) ? $wgBuckySampling : self::DEFAULT_SAMPLING) / 100;
			$config = json_encode(array(
				'host' => $url,
				'sample' => $sample,
				'aggregationInterval' => 1000,
			));
			$script = "<script>$(function(){Bucky.setOptions({$config});$(window).load(function(){Bucky.sendPagePerformance('{$app->wg->WikiaEnvironment}');});});</script>";
			$bottomScripts .= $script;
		}

		return true;
	}

	static public function onOasisSkinAssetGroups( &$assetGroups ) {
		if ( self::getEnvironment() ) {
			$assetGroups[] = 'bucky_js';
		}

		return true;
	}

}
