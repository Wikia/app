<?php

class IE6PhaseOut {

	/**
	 * Show message for Internet Explorer 6 users below first heading
	 */
	public static function showNotice(&$skin, &$tpl) {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgRequest;

		// show this message only in Monaco & Answers skins
		$skinName = get_class($skin);
		if (!in_array($skinName, array('SkinAnswers', 'SkinMonaco'))) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// show this message only on view of main namespace pages
		$isMainNamespacePage = !empty($wgTitle) && $wgTitle->getNamespace() == NS_MAIN;
		$isPageView = in_array($wgRequest->getVal('action', 'view'), array('view', 'purge'));

		if (!$isMainNamespacePage || !$isPageView) {
			wfProfileOut(__METHOD__);
			return true;
		}

		wfLoadExtensionMessages('IE6PhaseOut');
		$msg = wfMsgExt('ie6-phaseout-message', array('parseinline'));

		$notice = '<div id="ie6-phaseout-message" class="usermessage" style="display: none">' . $msg . '</div><script type="text/javascript">wgIsIE6 = true</script>';

		// only for IE6
		$notice = "<!--[if lt IE 7]>{$notice}<![endif]-->";

		$tpl->data['bodytext'] = $notice . $tpl->data['bodytext'];

		wfProfileOut(__METHOD__);
		return true;
	}
}
