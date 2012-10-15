<?php

$wgHooks["NormalizeMessageKey"][] = "wfFakeAnswersMessaging";

/**
 * @param $key
 * @param $useDB
 * @param $langCode
 * @param $transform
 * @return bool
 */
function wfFakeAnswersMessaging(&$key, &$useDB, &$langCode, &$transform) {
	$mask = "-answers2";

	if (!preg_match("/{$mask}$/", $key, $matches)) {
		$key2 = "{$key}{$mask}";
		$msg2 = wfMsgGetKey($key2, $useDB, $langCode, $transform);

		if (!wfEmptyMsg($key2, $msg2)) {
			$key = $key2;
		}
	}

	return true;
}
