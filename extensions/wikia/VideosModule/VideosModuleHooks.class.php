<?php

class VideosModuleHooks {

	static public function onGetRailModuleList(&$modules) {
		wfProfileIn(__METHOD__);

		$app = F::App();
		$pos = $app->wg->User->isAnon() ? 1305 : 1285;


		$modules[$pos] = array('VideosModule', 'index', null);

		wfProfileOut(__METHOD__);

		return true;
	}
}