<?php

class Bucky {

	static public function onSkinAfterBottomScripts( Skin $skin, &$bottomScripts ) {
		$wgBuckySampling = F::app()->wg->BuckySampling;
		$url = '/__rum/';
		$sample = (isset($wgBuckySampling) ? $wgBuckySampling : 100) / 100;
		$config = json_encode(array(
			'host' => $url,
			'sample' => $sample,
		));
		$script = "<script>Bucky.setOptions({$config});$(window).load(function(){Bucky.sendPagePerformance('all');});</script>";
		$bottomScripts .= $script;

		return true;
	}

	static public function onOasisSkinAssetGroups( &$assetGroups ) {
		$assetGroups[] = 'bucky_js';

		return true;
	}

}
