<?php

class SpellCheckerAjax {

	static function checkWords() {
		wfProfileIn(__METHOD__);

		$app = WF::build('App');
		$request = $app->getGlobal('wgRequest');

		// get request params
		$lang = $request->getVal('lang', false);
		$words = explode(',', $request->getVal('words', ''));

		$service = new SpellCheckerService($lang);
		$ret = $service->checkWords($words);

		// BugId:2570 - log statistics
		$wordsCount = count($words);
		$suggestionsCount = count($ret['suggestions']);

		$now = wfTime();
		$elapsed = round($now - $app->getGlobal('wgRequestTime'), 4);

		Wikia::log(__METHOD__, __LINE__, "{$wordsCount} words checked / {$suggestionsCount} suggestions / done in {$elapsed} sec.", true);

		wfProfileOut(__METHOD__);
		return $ret;
	}

}
