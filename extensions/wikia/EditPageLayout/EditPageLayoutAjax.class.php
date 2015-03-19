<?php

class EditPageLayoutAjax {

	/**
	 * Perform reverse parsing on given HTML (when needed)
	 */
	static private function resolveWikitext( $content, $mode, $page, $method, $section ) {
		global $wgRequest, $wgTitle, $wgOut, $wgEnableSlowPagesBlacklistExt, $wgEditPreviewMercury;

		wfProfileIn( __METHOD__ );

		if ( !empty( $wgEnableSlowPagesBlacklistExt ) ) {
			global $wgSlowPagesBlacklist;
			if ( in_array( $wgTitle->getFullURL(), $wgSlowPagesBlacklist ) ) {
				wfProfileOut( __METHOD__ );
				return [
					'html' => wfMessage( 'slowpagesblacklist-preview-unavailable' )->plain(),
					'catbox' => '',
					'interlanglinks' => ''
				];
			}
		}

		if ( $wgTitle && class_exists( $page ) ) {
			$pageObj = new $page();
			if ( is_a( $pageObj, 'SpecialCustomEditPage' ) ) {
				$wikitext = $pageObj->getWikitextFromRequestForPreview( $wgRequest->getVal( 'title', 'empty' ) );
				$service = new EditPageService( $wgTitle );
				$html = $pageObj->getOwnPreviewDiff( $wikitext, $method );

				/**
				 * @val String $type - partial, full or mercury
				 *
				 * full means content along with CSS and JS
				 * partial means just the article content
				 * mercury means previewing the article in Mercury skin (needs $wgEditPreviewMercuryUrlPrefix)
				 */
				$type = $wgRequest->getVal( 'type', 'partial' );

				if ( $type === 'mercury' && empty( $wgEditPreviewMercury ) ) {
					// Fall back to regular wikiamobile if Mercury is not available
					$type = 'full';
				}

				$res = [];

				if ( $html === false ) {
					$html = '';

					if ( $method == 'preview' ) {

						$asJson = ( $type === 'mercury' );
						list( $html, $catbox, $interlanglinks ) = $service->getPreview( $wikitext, $asJson );

						if ( !$asJson ) {
							// allow extensions to modify preview (BugId:8354) - this hook should only be run on article's content
							wfRunHooks( 'OutputPageBeforeHTML', array( &$wgOut, &$html ) );
						}

						if ( F::app()->checkSkin( 'wikiamobile' ) ) {
							if ( $type === 'full' ) {
								$res['html'] = F::app()->renderView(
									'WikiaMobileService',
									'preview',
									[ 'content' => $html, 'section' => $section ]
								);
							} elseif ( $type === 'mercury' ) {
								$hash = hash_hmac ( 'sha1', $html, $wgEditPreviewMercury['mwSalt'] );
								$res['html'] = F::app()->renderView(
									'EditPageLayout',
									'mercuryPreview', [
										'parserOutput' => $html,
										'mercuryUrl' => $wgEditPreviewMercury['mercuryUrl'],
										'mwHash' => $hash,
									]
								);
							} else {
								$res['html'] = $html;
							}
						} elseif ( F::app()->checkSkin( 'venus' ) ) {
							if ( $type === 'full' ) {
								$res['html'] = F::app()->renderView(
									'VenusController',
									'preview',
									[ 'content' => $html, 'section' => $section ]
								);
							} else {
								$res['html'] = $html;
							}
						} else {
							// add page title when not in section edit mode
							if ( $section === '' ) {
								$html = '<h1 class="pagetitle">' . $wgTitle->getPrefixedText() .  '</h1>' . $html;
							}

							// allow extensions to modify preview (BugId:6721)
							wfRunHooks( 'EditPageLayoutModifyPreview', array( $wgTitle, &$html, $wikitext ) );

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

							$html = '<div class="WikiaArticle">' . $html . '</div>';

							$res = [
								'html' => $html,
								'catbox' => $catbox,
								'interlanglinks' => $interlanglinks
							];
						}

					} elseif ( $method == 'diff' ) {
						$res['html'] = $service->getDiff( $wikitext, intval( $section ) );
					}
				}

				wfProfileOut( __METHOD__ );
				return $res;
			}
		}

		wfProfileOut( __METHOD__ );
		return [ 'html' => '' ];
	}

	/**
	 * pass request to resolveWikitext
	 */
	static private function resolveWikitextFromRequest( $method ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$content = $wgRequest->getVal( 'content', '' );
		$mode = $wgRequest->getVal( 'mode', '' );
		$page = $wgRequest->getVal( 'page', '' );
		$section = $wgRequest->getVal( 'section', '' );

		$wikitext = self::resolveWikitext( $content, $mode, $page, $method, $section );
		wfProfileOut( __METHOD__ );
		return $wikitext;
	}

	/**
	 * Parse provided wikitext to HTML using MW parser
	 */
	static public function preview() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$skin = $wgRequest->getVal( 'skin' );

		if ( !empty( $skin ) ) {
			RequestContext::getMain()->setSkin(
				Skin::newFromKey( $skin )
			);
		}

		$res = self::resolveWikitextFromRequest( 'preview' );

		// parse summary
		// DAR-2382 -- render edit summary the same way it's rendered on Special:WikiActivity and Special:RecentChanges
		$summary = $wgRequest->getText( 'summary' );
		$summary = RequestContext::getMain()->getSkin()->formatComment( $summary, false );

		if ( $summary != '' ) {
			$res['summary'] = wfMessage( 'wikia-editor-preview-editSummary' )->rawParams( $summary )->parse();
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * Render diff between the latest version of an article and given wikitext
	 */
	static public function diff() {
		global $wgRequest, $wgTitle;
		wfProfileIn( __METHOD__ );

		$res = self::resolveWikitextFromRequest( 'diff' );

		wfProfileOut( __METHOD__ );
		return $res;
	}

	static private function updatePreferences( $name, $value ) {
		global $wgUser;
		if ( $wgUser->isLoggedIn() ) {
			$wgUser->setOption( $name, $value );
			$wgUser->saveSettings();

			// commit changes to local db
			$dbw = wfGetDB( DB_MASTER );
			$dbw->commit();

			// commit changes to shared db
			global $wgExternalSharedDB, $wgSharedDB;
			if ( isset( $wgSharedDB ) ) {
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

		wfProfileIn( __METHOD__ );

		$res = false;

		if ( $wgRequest->wasPosted() ) {
			$rawState = (bool)$wgRequest->getVal( 'state' );
			// save it
			$res = self::updatePreferences( 'editwidth', $rawState );
		}

		wfProfileOut( __METHOD__ );
		return array(
			'result' => $res
		);
	}

	static public function getTemplatesList() {
		global $wgTitle;

		$service = new EditPageService( $wgTitle );
		$html = $service->getTemplatesList();

		return array(
			'templates' => $html,
		);
	}
}
