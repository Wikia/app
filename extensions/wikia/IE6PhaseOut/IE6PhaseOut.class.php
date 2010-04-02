<?php

class IE6PhaseOut {

	/**
	 * Show message for Internet Explorer 6 users in site notice area
	 */
	public static function showNotice(&$skin, &$tpl) {
		wfProfileIn(__METHOD__);

		// show this message only in Monaco & Answers skins
		$skinName = get_class($skin);
		if (!in_array($skinName, array('SkinAnswers', 'SkinMonaco'))) {
			wfProfileOut(__METHOD__);
			return true;
		}

		wfLoadExtensionMessages('IE6PhaseOut');
		$msg = wfMsgExt('ie6-phaseout-message', array('parseinline'));

		$notice = '<div id="ie6-phaseout-message" class="usermessage" style="display: block">' . $msg . '</div>';

		$tpl->data['bodytext'] = $notice . $tpl->data['bodytext'];

		wfProfileOut(__METHOD__);
		return true;
	}
}
