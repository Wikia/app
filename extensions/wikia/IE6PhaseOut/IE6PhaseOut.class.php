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

		// let JS check cookie and fetch message via AJAX
		$noticeTrigger = '<script type="text/javascript">var wgShowIE6PhaseOutMessage = true;</script>';

		// only for IE6
		$noticeTrigger = "\t\t<!--[if lt IE 7]>{$noticeTrigger}<![endif]-->\n";

		$tpl->data['headlinks'] .= $noticeTrigger;

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Get message for Internet Explorer 6 users via AJAX
	 */
	public static function getNotice() {
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('IE6PhaseOut');

		$msg = wfMsgExt('ie6-phaseout-message', array('parseinline'));
		$notice = '<div id="ie6-phaseout-message" class="usermessage" style="display:none">' . $msg . '</div>';

		$ret = new AjaxResponse($notice);

		wfProfileOut(__METHOD__);
		return $ret;
	}
}
