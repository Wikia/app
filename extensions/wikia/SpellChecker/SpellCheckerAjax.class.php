<?php

class SpellCheckerAjax {

	static function checkWords() {
		wfProfileIn(__METHOD__);

		$app = F::app();
		$request = $app->getGlobal('wgRequest');

		// get request params
		$lang = $request->getVal('lang', false);
		$words = explode(',', $request->getVal('words', ''));

		// benchmark
		$time = wfTime();

		$service = new SpellCheckerService($lang);
		$ret = $service->checkWords($words);

		// BugId:2570 - log statistics
		$wordsCount = count($words);
		$suggestionsCount = count($ret['suggestions']);

		// finish the benchmark
		$time = round(wfTime() - $time, 4);

		if (!empty($ret)) {
			$ret['info']['time'] = $time;
		}

		Wikia::log(__METHOD__, __LINE__, "{$wordsCount} words checked / {$suggestionsCount} suggestions / done in {$time} sec.", true);

		wfProfileOut(__METHOD__);
		return $ret;
	}

}
