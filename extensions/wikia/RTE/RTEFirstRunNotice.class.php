<?php

class RTEFirstRunNotice {

	const userOptionName = 'RTENoticeDismissed';

	/**
	 * Render first run notice
	 */
	public static function render($form, $out) {
		wfProfileIn(__METHOD__);

		if (!self::isDismissed()) {
			RTE::log('showing first run notice');

			$html = '';

			$html .= Xml::openElement('div', array('id' => 'RTEFirstRunNotice', 'class' => 'plainlinks'));
			$html .= Xml::element('div', array('id' => 'RTEFirstRunNoticeClose'), ' ');
			$html .= wfMsgExt('rte-first-run-notice', array('parseinline'));
			$html .= Xml::closeElement('div');

			$out->addHtml($html);
		}
		else {
			RTE::log('first run notice is dismissed');
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Dismiss first run notice
	 *
	 * Use user option for logged-in (and cookie for anon - handled client-side)
	 */
	public static function dismiss() {
		global $wgUser;

		if ($wgUser->isLoggedIn()) {
			$wgUser->setOption(self::userOptionName, 1);
			$wgUser->saveSettings();

			$dbw = wfGetDB( DB_MASTER );
			$dbw->commit();
		}

		return array(
			'ok' => true,
		);
	}

	/**
	 * Check should we show first run notice
	 */
	private static function isDismissed() {
		global $wgUser;
		$dismissed = false;

		if ($wgUser->isLoggedIn()) {
			$dismissed = $wgUser->getOption(self::userOptionName);
		}

		return !empty($dismissed);
	}
}
