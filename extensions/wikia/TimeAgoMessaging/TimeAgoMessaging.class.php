<?php

class TimeAgoMessaging {

	const VERSION = 3;
	const TTL = 86400;

	/**
	 * Add inline JS with i18n messages for jquery.timeago.js
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['wgTimeAgoi18n'] = self::getMessages();
		return true;
	}

	/**
	 * Get timeago messages (for user language)
	 */
	private static function getMessages() {
		/* @var $wgLang Language */
		global $wgLang, $wgMemc;
		wfProfileIn(__METHOD__);

		$lang = $wgLang->getCode();
		$memcKey = wfMemcKey('timeago', 'i18n', $lang, self::VERSION);

		$messages = $wgMemc->get($memcKey);

		if (empty($messages)) {
			wfDebug(__METHOD__ . ": lang '{$lang}'\n");

			$messages = array();
			$keys = array(
				'year',
				'month',
				'day',
				'hour',
				'minute',
				'second',
			);
			// message names suffixes to iterate over (BugId:30226
			$suffixes = array(
				'', // handling the past
				'-from-now' // handling the future
			);

			foreach($suffixes as $suffix) {
				// get singular and plural form
				foreach($keys as $key) {
					$msgName = "timeago-{$key}{$suffix}";

					$singular = wfMsgExt($msgName, array('parsemag'), 1);
					$plural = str_replace('2', '%d', wfMsgExt($msgName, array('parsemag'),  2));

					$messages[$key . $suffix] = $singular;
					$messages[$key . 's' . $suffix] = $plural;

					// TODO: handle cases like "2 godziny" vs "5 godzin" (pl)
					/*
					$plural2 = str_replace('5', '%d', wfMsgExt("timeago-{$key}", array('parsemag'), 5));
					if ($plural != $plural2) {
						$messages["{$key}s2"] = $plural2;
					}
					*/
				}
			}

			unset($messages['second']);

			$wgMemc->set($memcKey, $messages, self::TTL);
		}

		wfProfileOut(__METHOD__);
		return $messages;
	}
}
