<?php
class WikiaInternalHooks {

	static public function onAfterCheckInitialQueries($title, $action, $ret) {
		global $wgCityId, $wgUser, $wgIsPrivateWiki;

		wfProfileIn(__METHOD__);

		if( (empty($wgCityId) || $wgIsPrivateWiki) && $wgUser->isAnon() ) {
			//if internal/private wiki redirect -- do not show original title (file name for example) not logged in users fb#1090
			$ret = null;
		}

		wfProfileOut(__METHOD__);

		return true;
	}
}
