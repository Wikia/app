<?php

/**
 * CategorySelect controller.
 *
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */

class CategorySelectController extends WikiaController {
	const CACHE_TTL_AJAX = 360; // 1 hour
	const CACHE_TTL_MEMCACHE = 86400; // 1 day

	/**
	 * Returns all of the categories on the current wiki.
	 */
	public function getCategories() {
		global $wgMemc;

		wfProfileIn(__METHOD__);

		$key = wfMemcKey('CategorySelectGetCategories', 1);
		$data = $wgMemc->get($key);

		if (empty($out)) {
			$dbr = wfGetDB(DB_SLAVE);
			$res = $dbr->select(
				'category',
				'cat_title',
				array('cat_pages > 0'),
				__METHOD__,
				array('ORDER BY' => 'cat_pages DESC',
				      'LIMIT'    => '10000'));

			$categories = array();
			while($row = $dbr->fetchObject($res)) {
				$categories[] = str_replace('_', ' ', $row->cat_title);
			}

			$data = json_encode($categories);

			// TODO: clear the cache when new category is added
			$wgMemc->set($key, $data, self::CACHE_TTL_MEMCACHE);
		}

		$this->response->setData( $data );
		$this->response->setFormat( 'json' );

		wfProfileOut(__METHOD__);
	}

	/**
	 * Parse categories via AJAX from wikitext to JSON
	 * Return error on not handled syntax
	 */
	public function parseCategories( $wikitext ) {
		$data = CategorySelect::SelectCategoryAPIgetData($wikitext);
		if (trim($data['wikitext']) == '') {	//all categories handled
			$result['categories'] = $data['categories'];
		} else {	//unhandled syntax
			$result['error'] = wfMsg('categoryselect-unhandled-syntax');
		}
		return json_encode($result);
	}

	/**
	 * Save categories sent via AJAX into article
	 */
	public function saveCategories( $articleId, $categories ) {
		global $wgUser;

		if (wfReadOnly()) {
			$result['error'] = wfMsg('categoryselect-error-db-locked');
			return json_encode($result);
		}

		wfProfileIn(__METHOD__);

		Wikia::setVar('EditFromViewMode', 'CategorySelect');

		$categories = CategorySelect::changeFormat($categories, 'json', 'wiki');
		if ($categories == '') {
			$result['info'] = 'Nothing to add.';
		} else {
			$title = Title::newFromID($articleId);
			if (is_null($title)) {
				$result['error'] = wfMsg('categoryselect-error-not-exist', $articleId);
			} else {
				if ($title->userCan('edit') && !$wgUser->isBlocked()) {
					$result = null;
					$article = new Article($title);
					$article_text = $article->fetchContent();
					$article_text .= $categories;

					$dbw = wfGetDB( DB_MASTER );
					$dbw->begin();
					$editPage = new EditPage( $article );
					$editPage->edittime = $article->getTimestamp();
					$editPage->recreate = true;
					$editPage->textbox1 = $article_text;
					$editPage->summary = wfMsgForContent('categoryselect-edit-summary');
					$editPage->watchthis = $editPage->mTitle->userIsWatching();
					$bot = $wgUser->isAllowed('bot');
					$status = $editPage->internalAttemptSave( $result, $bot );
					$retval = $status->value;
					Wikia::log( __METHOD__, "editpage", "Returned value {$retval}" );

					switch($retval) {
						case EditPage::AS_SUCCESS_UPDATE:
						case EditPage::AS_SUCCESS_NEW_ARTICLE:
							$dbw->commit();
							$title->invalidateCache();
							Article::onArticleEdit($title);

							$skin = RequestContext::getMain()->getSkin();

							// return HTML with new categories
							// OutputPage::tryParserCache become deprecated in MW1.17 and removed in MW1.18 (BugId:30443)
							$parserOutput = ParserCache::singleton()->get( $article, $article->getParserOptions() );
							if ($parserOutput !== false) {
								$skin->getOutput()->addParserOutput($parserOutput);
							}

							$cats = $skin->getCategoryLinks();

							$result['info'] = 'ok';
							$result['html'] = $cats;
							break;

						case EditPage::AS_SPAM_ERROR:
							$dbw->rollback();
							$result['error'] = wfMsg('spamprotectiontext') . '<p>( Case #8 )</p>';
							break;

						default:
							$dbw->rollback();
							$result['error'] = wfMsg('categoryselect-edit-abort');
					}
				} else {
					$result['error'] = wfMsg('categoryselect-error-user-rights');
				}
			}
		}

		wfProfileOut(__METHOD__);
		return json_encode($result);
	}

	/**
	 * The template and data needed for article pages.
	 * Formerly "CategorySelectGenerateHTMLforView"
	 */
	public function articlePage() {
		$vars = array();
		CategorySelectHooksHelper::onMakeGlobalVariablesScript( $vars );

		$data = array(
			'html' => $this->app->renderView( 'CategorySelect', 'articlePage', array() ),
			'vars' => $vars,
		);

		$this->response->setData( $data );
		$this->response->setFormat( 'json' );
		$this->response->setCacheValidity( self::CACHE_TTL_AJAX, self::CACHE_TTL_AJAX, array(
			WikiaResponse::CACHE_TARGET_BROWSER,
			WikiaResponse::CACHE_TARGET_VARNISH
		));
	}

	/**
	 * The template for edit pages.
	 * Formerly "CategorySelectGenerateHTMLforEditRaw"
	 */
	public function editPage() {
		$this->response->addAsset( 'extensions/wikia/CategorySelect/js/CategorySelect.js' );
		$this->response->addAsset( 'extensions/wikia/CategorySelect/css/CategorySelect.scss' );

		$categories = '';
		if ( !empty( $this->wg->CategorySelectMetaData ) ) {
			$categories = CategorySelect::changeFormat( $this->wg->CategorySelectMetaData[ 'categories' ], 'array', 'wiki' );
		}

		$this->response->setVal( 'categories', $categories );
		$this->response->setVal( 'formId', $this->request->getVal( 'formId', '' ) );
	}

	/**
	 * Form field metadata to send along with the edit form submission.
	 */
	public function editPageMetaData() {
		$categories = '';
		if ( !empty( $this->wg->CategorySelectMetaData ) ) {
			$categories = htmlspecialchars( CategorySelect::changeFormat( $this->wg->CategorySelectMetaData[ 'categories' ], 'array', 'json' ) );
		}

		$this->response->setVal( 'categories', $categories );
	}
}