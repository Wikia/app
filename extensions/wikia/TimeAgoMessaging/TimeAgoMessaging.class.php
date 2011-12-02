<?php

class TimeAgoMessaging {

	const VERSION = 2;
	const TTL = 86400;

	/**
	 * Add inline JS with i18n messages for jquery.timeago.js
	 */
	public static function onMakeGlobalVariablesScript(&$vars) {
		$vars['wgTimeAgoi18n'] = self::getMessages();
		return true;
	}

	/**
	 * Get timeago messages (for user language)
	 */
	private static function getMessages() {
		global $wgLang, $wgMemc;
		wfProfileIn(__METHOD__);

		$lang = $wgLang->getCode();
		$memcKey = wfMemcKey('timeago', 'i18n', $lang, self::VERSION);

		$messages = $wgMemc->get($memcKey);

		if (empty($messages)) {
			wfDebug(__METHOD__ . ": lang '{$lang}'\n");

			$messages = array();
			$keys = array(
				'month',
				'day',
				'hour',
				'minute',
				'second',
			);

			// get singular and plural form
			foreach($keys as $key) {
				$singular = wfMsgExt("timeago-{$key}", array('parsemag'), 1);
				$plural = str_replace('2', '%d', wfMsgExt("timeago-{$key}", array('parsemag'),  2));

				$messages[$key] = $singular;
				$messages["{$key}s"] = $plural;

				// TODO: handle cases like "2 godziny" vs "5 godzin" (pl)
				/*
				$plural2 = str_replace('5', '%d', wfMsgExt("timeago-{$key}", array('parsemag'), 5));
				if ($plural != $plural2) {
					$messages["{$key}s2"] = $plural2;
				}
				*/
			}

			unset($messages['second']);

			$wgMemc->set($memcKey, $messages, self::TTL);
		}

		wfProfileOut(__METHOD__);
		return $messages;
	}
}
