<?php

class WikiaPollHooks {

	private static $alreadyAddedCSSJS = false;

	/**
	 * Use WikiaPollArticle class to render Poll namespace pages
	 *
	 * @param $title Title
	 * @param $article Article
	 */
	public static function onArticleFromTitle($title, &$article) {
		wfProfileIn(__METHOD__);

		if ($title->getNamespace() == NS_WIKIA_POLL) {
			$article = new WikiaPollArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 *  Override the edit button behavior in the menu for Poll pages
	 *  only allow the Poll creator or an admin to edit
	 */
	 public static function onMenuButtonAfterExecute (&$moduleObject, &$params) {
		global $wgTitle, $wgUser;

		if( $wgTitle instanceof Title && $wgTitle->getNamespace() == NS_WIKIA_POLL ) {
			$rev = $wgTitle->getFirstRevision();
			$isAdmin = $wgUser->isAllowed('editinterface');
			if ($isAdmin || !$wgTitle->exists() || (($rev instanceof Revision) && ($wgUser->getId() == $rev->getRawUser()))) {
				// okay to edit, do nothing
			} else {
				// remove button
				$moduleObject->action = array();
			}
		}
		return true;
	 }

	/**
	 * Override the edit button to point to the special page instead of the normal editor
	 *
	 * @param $editPage EditPage
	 */
	public static function onAlternateEdit( $editPage ) {
		global $wgOut;

		$title = $editPage->getArticle()->getTitle();

		if( $title->getNamespace() == NS_WIKIA_POLL ) {

			$specialPageTitle = Title::newFromText( 'CreatePoll', NS_SPECIAL );
			$wgOut->redirect( $specialPageTitle->getFullUrl() . '/' . $title->getDBkey() );
		}

		return true;
	}

	/**
	 * Return HTML to be used when embedding polls from inside parser
	 * TODO: replace all this with a hook inside parser
	 *
	 * @param WikiaPoll $poll
	 * @param Title $finalTitle
	 */
	public static function generate($poll, $finalTitle) {
		wfProfileIn(__METHOD__);

		if ($finalTitle instanceof Title && $finalTitle->exists() && $finalTitle->getNamespace() == NS_WIKIA_POLL) {

			$app = F::app();
			$ret = $poll->renderEmbedded();

			if (self::$alreadyAddedCSSJS == false) {
				// make sure we don't include twice if there are multiple polls on one page
				self::$alreadyAddedCSSJS = true;
				// add CSS & JS and Poll HTML together

				if( $app->checkSkin( 'wikiamobile' ) ){
					$cssLinks = AssetsManager::getInstance()->getURL( 'wikiapoll_wikiamobile_scss' );
					$jsLinks = AssetsManager::getInstance()->getURL( 'wikiapoll_wikiamobile_js' );

					$css = '';
					$js = '';

					if ( is_array( $cssLinks ) ) {
						foreach ( $cssLinks as $s ) {
							$css .= "<link rel=stylesheet href={$s} />";
						}
					}

					if ( is_array( $jsLinks ) ) {
						foreach ( $jsLinks as $s ) {
							$js .= "<script src={$s}></script>";
						}
					}

					$js .= JSMessages::printPackages( array( 'WikiaMobilePolls' ) );

					$ret = str_replace("\n", ' ', "{$css}{$ret}{$js}");
				} else {
					$sassUrl = AssetsManager::getInstance()->getSassCommonURL('/extensions/wikia/WikiaPoll/css/WikiaPoll.scss');
					$css = '<link rel="stylesheet" type="text/css" href="' . htmlspecialchars($sassUrl) . ' " />';

					$jsFile = JSSnippets::addToStack(
						array( '/extensions/wikia/WikiaPoll/js/WikiaPoll.js' ),
						array(),
						'WikiaPoll.init'
					);

					$ret = str_replace("\n", ' ', "{$css} {$ret} {$jsFile}");
				}
			}
			wfProfileOut(__METHOD__);
			return $ret;
		}

		wfProfileOut(__METHOD__);
		return '';
	}

	/**
	 * Return XML object for parser when RTE enabled
	 * called from Parser::replaceInternalLinks2
	 *
	 * @param $poll WikiaPoll
	 * @param $nt Title
	 * @param $RTE_wikitextIdx
	 */
	public static function generateRTE($poll, $nt, $RTE_wikitextIdx) {
		global $wgBlankImgUrl;

		$data = array();
		$data['type'] = 'poll';
		$data['pollId'] = $nt->getArticleId();
		$data['wikitext'] = RTEData::get('wikitext', $RTE_wikitextIdx);

		$pollData = $poll->getData();
		if (isset($pollData['question'])) {
			$data['question'] = $pollData['question'];
		}
		if (isset($pollData['answers'])) {
			foreach ($pollData["answers"] as $answer ) {
				$data['answers'][] = $answer['text'];
			}
		}
		// store data and mark HTML
		$dataIdx = RTEData::put('data', $data);

		// render poll placeholder
		$tag = Xml::element('img', array(
			'_rte_dataidx' => sprintf('%04d', $dataIdx),
			'class' => "media-placeholder placeholder-poll",
			'src' => $wgBlankImgUrl,
			'type' => 'poll',
			'width' => $poll->getRtePlaceholderWidth(),
			'height' => $poll->getRtePlaceholderHeight(),
		));
		return RTEData::addIdxToTag($dataIdx, $tag);
	}

	/**
	 * Purge poll after an edit
	 *
	 * @param $article Article
	 */
	public static function onArticleSaveComplete($article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		wfProfileIn(__METHOD__);

		$title = $article->getTitle();

		if (!empty($title) && $title->getNamespace() == NS_WIKIA_POLL) {
			$poll = WikiaPoll::newFromArticle($article);
			$poll->purge();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add support for [[:Poll:...]] used to embed polls in articles
	 *
	 * @param $s string parsed wikitext
	 * @param $nt Title
	 * @param $prefix string
	 * @param $trail string
	 * @param $RTE_wikitextIdx string
	 * @return bool
	 */
	public static function onParserReplaceInternalLinks2NoForce(&$s, $nt, $prefix, $trail, $RTE_wikitextIdx) {
		global $wgRTEParserEnabled;

		if ($nt->getNamespace() === NS_WIKIA_POLL) {
			$poll = WikiaPoll::newFromTitle($nt);
			if ($poll instanceof WikiaPoll) {
				if (!empty($wgRTEParserEnabled)) {
					$s .= $prefix . WikiaPollHooks::generateRTE($poll, $nt, $RTE_wikitextIdx) . $trail;
				} else {
					$s .= $prefix . WikiaPollHooks::generate($poll, $nt) . $trail;
				}
				return false;
			}
		}

		return true;
	}

}
