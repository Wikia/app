<?php

class MyHome {

	// rc_params prefixes
	const sectionEditWithSummary = "\x7f01\x7f";
	const sectionEditWithOutSummary = "\x7f02\x7f";

	private static $editedSectionName = false;

	/*
	 * Store beginning of new article (parsed content) in recent changes table (rc_params field)
	 *
	 * Store section title when editing section of existing article
	 *
	 * @see http://www.mediawiki.org/wiki/Logging_table#log_params
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function storeInRecentChanges($rc) {
		wfProfileIn(__METHOD__);

		global $wgParser;

		switch($rc->getAttribute('rc_type')) {

			// existing article: check whether it's section edit
			case RC_EDIT:
				if (self::$editedSectionName !== false) {
					$comment = trim($rc->getAttribute('rc_comment'));

					if (preg_match('#^/\*(.*)\*/$#', $comment)) {
						// summary hasn't changed - store section name
						$rc->mAttribs['rc_params'] = self::sectionEditWithOutSummary . self::$editedSectionName;
					}
					else {
						// summary has changed - store modified summary
						$rc->mAttribs['rc_params'] = self::sectionEditWithSummary . $wgParser->stripSectionName($comment);
					}
				}
				break;

			// new article: store first x characters of parsed content
			case RC_NEW:
				$content = $wgParser->getOutput()->getText();

				// remove [edit] section links
				$content = preg_replace('#<span class="editsection">(.*)</a>]</span>#', '', $content);

				$content = trim(strip_tags($content));
				$rc->mAttribs['rc_params'] = mb_substr($content, 0, 150);

				break;
		}

		//var_dump($rc); die();

		wfProfileOut(__METHOD__);

		return true;
	}

	/*
	 * Add link to Special:MyHome in Monaco user menu
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function addToUserMenu($skin, $tpl, $custom_user_data) {
		wfProfileIn(__METHOD__);

		// don't touch anon users
		global $wgUser;
		if ($wgUser->isAnon()) {
			return true;
		}

		wfLoadExtensionMessages('MyHome');

		$skin->data['userlinks']['myhome'] = array(
			'text' => wfMsg('myhome'),
			'href' => Skin::makeSpecialUrl('MyHome'),
		);

		wfProfileOut(__METHOD__);

		return true;
	}

	/*
	 * Check if it's section edit, then try to get section name
	 *
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/EditFilter
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getSectionName($editor, $text, $section, &$error) {
		wfProfileIn(__METHOD__);

		global $wgParser;

		// check for section edit
		if (is_numeric($section)) {
			$hasmatch = preg_match( "/^ *([=]{1,6})(.*?)(\\1) *\\n/i", $editor->textbox1, $matches );

			if ( $hasmatch and strlen($matches[2]) > 0 ) {
				// this will be saved in recentchanges table in MyHome::storeInRecentChanges
				self::$editedSectionName = $wgParser->stripSectionName($matches[2]);
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/*
	 * Return page user is redirected to when title is not specified in URL
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getInitialMainPage($title) {
		wfProfileIn(__METHOD__);

		global $wgUser;
		if ($wgUser->isLoggedIn()) {
			$title = Title::newFromText('MyHome', NS_SPECIAL);
		}

		wfProfileOut(__METHOD__);

		return true;
	}
}
