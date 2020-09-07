<?php
class ArticleCommentsController extends WikiaController {
	use Wikia\Logger\Loggable;

	private $dataLoaded = false;
	private static $content = null;

	public function executeIndex() {
		$this->page = $this->wg->request->getVal( 'page', 1 );
		$this->isLoadingOnDemand = ArticleComment::isLoadingOnDemand();
		$this->isMiniEditorEnabled = ArticleComment::isMiniEditorEnabled();

		if ( $this->isLoadingOnDemand ) {
			$this->response->setJsVar( 'wgArticleCommentsLoadOnDemand', true );

		} else {
			$this->getCommentsData( $this->wg->Title, $this->page );
			$this->response->addAsset( 'articlecomments' . ( $this->isMiniEditorEnabled ? '_mini_editor' : '' ) . '_scss' );
		}
	}

	/**
	 * The content for an article page. This is included on the index (for the current title)
	 * if lazy loading is disabled, otherwise it is requested via AJAX.
	 */
	public function content() {
		//this is coming via ajax we need to set correct wgTitle ourselves
		global $wgTitle, $wgArticleCommentsReadOnlyMode;

		$articleId = $this->request->getVal( 'articleId', null );
		$page = $this->request->getVal( 'page', 1 );
		$title = null;

		if ( !empty( $articleId ) ) {
			$wgTitle = $title = Title::newFromID( $articleId );
		}

		if ( !( $title instanceof Title ) ) {
			$title = $this->wg->title;
		}

		// If articleId is invalid, don't trigger a fatal error, just throw a 404 and return nothing.
		if ( $title === null ) {
			$this->response->setCode( 404 );
			$this->skipRendering();
			return;
		}

		$this->getCommentsData( $title, $page );
		$this->isMiniEditorEnabled = ArticleComment::isMiniEditorEnabled();
		$this->setVal('readOnly', $wgArticleCommentsReadOnlyMode);

		// Uncomment this when surrogate key purging works
		//Wikia::setSurrogateKeysHeaders( ArticleComment::getSurrogateKey( $articleId ) );

		// When lazy loading this request it shouldn't be cached in the browser
		if ( !empty( $this->wg->ArticleCommentsLoadOnDemand ) ) {
			$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
			$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		}
	}

	private function getCommentsData(Title $title, $page, $perPage = null, $filterid = null) {
		$key = implode( '_', [ $title->getArticleID(), $page, $perPage, $filterid ] );
		$data = null;

		// avoid going through all this when calling the method from the same round trip for the same paramenters
		// the real DB stuff is cached by ArticleCommentList in Memcached
		if ( empty( $this->dataLoaded[ $key ] ) ) {
			$commentList = ArticleCommentList::newFromTitle( $title );

			if ( !empty( $perPage ) ) {
				$commentList->setMaxPerPage( $perPage );
			}

			if ( !empty( $filterid ) ) {
				$commentList->setId( $filterid );
			}

			$data = $commentList->getData( $page );

			$this->dataLoaded[$key] = $data;
		} else {
			$data = $this->dataLoaded[$key];
		}

		if ( empty( $data ) ) {
			// Seems like we should always have data, let's leave a log somewhere if this happens
			Wikia\Logger\WikiaLogger::instance()->error(
				__METHOD__ . ' - no data, this should not happen',
				[
					'exception' => new Exception()
				]
			);
		}

		$this->ajaxicon = $this->wg->StylePath.'/common/images/ajax.gif';
		$this->pagesCount = ( $data['commentsPerPage'] > 0 ) ? ceil( $data['countComments'] / $data['commentsPerPage'] ) : 0;
		$this->response->setValues( $data );

		return $data;
	}

	public static function onSkinAfterContent( &$afterContentHookText ) {
		if ( !empty( self::$content ) ) {
			$afterContentHookText .= self::$content;
		}
		return true;
	}

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {
		if ( class_exists( 'ArticleCommentInit' ) && ArticleCommentInit::ArticleCommentCheck() ) {
			$app = F::app();

			// This is the actual entry point for Article Comment generation
			self::$content = $app->sendRequest( 'ArticleComments', 'index' );

			// Load MiniEditor assets
			if ( ArticleComment::isMiniEditorEnabled() ) {
				$app->sendRequest( 'MiniEditor', 'loadAssets', [
					'loadStyles' => !ArticleComment::isLoadingOnDemand(),
					'loadOnDemand' => true,
					'loadOnDemandAssets' => [
						'/extensions/wikia/MiniEditor/js/Wall/Wall.Animations.js'
					]
				] );
			}
		}
		return true;
	}
}
