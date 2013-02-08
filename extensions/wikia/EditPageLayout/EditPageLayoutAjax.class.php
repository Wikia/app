<?php

class EditPageLayoutAjax {

	/**
	 * Perform reverse parsing on given HTML (when needed)
	 */
	static private function resolveWikitext( $content, $mode, $page, $method, $section ) {
		global $wgRequest, $wgTitle, $wgOut;
		wfProfileIn(__METHOD__);
		if($wgTitle && class_exists($page)) {
			$pageObj = new $page();
			if(is_a( $pageObj, 'SpecialCustomEditPage' )) {
				$wikitext = $pageObj->getWikitextFromRequestForPreview($wgRequest->getVal('title', 'empty'));
				$service = new EditPageService($wgTitle);
				$html = $pageObj->getOwnPreviewDiff($wikitext, $method);
				$catbox = null;
				$interlanglinks = null;

				if($html === false ) {
					$html = '';
					if($method == 'preview') {
						list($html, $catbox, $interlanglinks) = $service->getPreview($wikitext);

						// allow extensions to modify preview (BugId:8354) - this hook should only be run on article's content
						wfRunHooks('OutputPageBeforeHTML', array(&$wgOut, &$html));

						// add page title when not in section edit mode
						if ($section === '') {
							$html = '<h1 class="pagetitle">' . $wgTitle->getPrefixedText() .  '</h1>' . $html;
						}

						// allow extensions to modify preview (BugId:6721)
						wfRunHooks('EditPageLayoutModifyPreview', array($wgTitle, &$html, $wikitext));

						/**
						 * bugid: 11407
						 * Provide an appropriate preview for a redirect, based on wikitext, not revision.
						 */
						if ( preg_match( '/^#REDIRECT /m', $wikitext ) ) {
							$article = Article::newFromTitle( $wgTitle, RequestContext::getMain() );
							$matches = array();
							if ( preg_match_all( '/^#REDIRECT \[\[([^\]]+)\]\]/Um', $wikitext, $matches ) ) {
    							$redirectTitle = Title::newFromText( $matches[1][0] );
    							$html = $article->viewRedirect( array( $redirectTitle ) );
							}
						}

					} elseif($method == 'diff') {
						$html = $service->getDiff($wikitext, intval($section));
					}
				}

				$html = '<div class="WikiaArticle">'. $html .'</div>';

				$res = array(
					'html' => $html,
					'catbox' => $catbox,
					'interlanglinks' => $interlanglinks
				);

				wfProfileOut(__METHOD__);
				return $res;
			}
		}
		wfProfileOut(__METHOD__);
		return array( 'html' => '' );
	}

	/**
	 * pass request to resolveWikitext
	 */
	static private function resolveWikitextFromRequest( $method ) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$content = $wgRequest->getVal('content', '');
		$mode = $wgRequest->getVal('mode', '');
		$page = $wgRequest->getVal('page', '');
		$section = $wgRequest->getVal('section', '');

		$wikitext = self::resolveWikitext($content, $mode, $page, $method, $section);
		wfProfileOut(__METHOD__);
		return $wikitext;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function preview() {
		global $wgRequest, $wgLang;
		wfProfileIn(__METHOD__);

		$res = self::resolveWikitextFromRequest('preview');

		// parse summary

		// taken from EditPage.php
		# Truncate for whole multibyte characters. +5 bytes for ellipsis
		$summary = $wgLang->truncate($wgRequest->getText('summary'), 150);

		# Remove extra headings from summaries and new sections.
		$summary = preg_replace('/^\s*=+\s*(.*?)\s*=+\s*$/', '$1', $summary);

		if ($summary != '') {
			$res['summary'] = wfMsgExt('wikia-editor-preview-editSummary', array('parse'), $summary);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Render diff between the latest version of an article and given wikitext
	 */
	static public function diff() {
		global $wgRequest, $wgTitle;
		wfProfileIn(__METHOD__);

		$res = self::resolveWikitextFromRequest('diff');

		wfProfileOut(__METHOD__);
		return $res;
	}

	static private function updatePreferences( $name, $value ) {
		global $wgUser;
		if ($wgUser->isLoggedIn()) {
			$wgUser->setOption($name, $value);
			$wgUser->saveSettings();

			// commit changes to local db
			$dbw = wfGetDB( DB_MASTER );
			$dbw->commit();

			// commit changes to shared db
			global $wgExternalSharedDB, $wgSharedDB;
			if( isset( $wgSharedDB ) ) {
				$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
				$dbw->commit();
			}

			return true;
		} else {
			return false;
		}
	}

	static public function setWidescreen() {
		global $wgRequest;

		wfProfileIn(__METHOD__);

		$res = false;

		if ($wgRequest->wasPosted()) {
			$rawState = (bool)$wgRequest->getVal('state');
			// save it
			$res = self::updatePreferences('editwidth', $rawState);
		}

		wfProfileOut(__METHOD__);
		return array(
			'result' => $res
		);
	}

	static public function getTemplatesList() {
		global $wgTitle;

		$service = new EditPageService($wgTitle);
		$html = $service->getTemplatesList();

		return array(
			'templates' => $html,
		);
	}
}
