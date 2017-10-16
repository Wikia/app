<?php
/**
 * WikiaMobile page header
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobilePageHeaderService extends WikiaService {
	static $skipRendering = false;

	static function setSkipRendering( $value = false ){
		self::$skipRendering = $value;
	}

	/**
	 * Function to remove first part of title
	 * ie Blog:Me/Test -> Test
	 *
	 * @param String $title
	 *
	 * @return string
	 */
	private function getTitleText( $title, $namespace ){
		/**
		 * @var array Holding namespaces for which first part of title should not be displayed
		 * ie Blog:Me/Test -> Test
		 */
		if ( defined( 'NS_BLOG_ARTICLE' ) && in_array( $namespace, [
				NS_BLOG_ARTICLE,
				NS_BLOG_ARTICLE_TALK,
				NS_BLOG_LISTING,
				NS_BLOG_LISTING_TALK
			] )
		) {
			$titleParts = explode( '/', $title );
			array_shift( $titleParts );

			return implode( '/', $titleParts );
		}

		return $title;
	}

    private function getTitleEditUrl(){
        $editLink = '';
		$wg = $this->wg;

		if ( $wg->Request->getVal( 'action', 'view' ) == 'view' &&
			$wg->Title->getArticleId() != 0 &&
			$wg->User->isLoggedIn()
		) {
            $editLink = $wg->Title->getLocalURL( [ 'section' => 0, 'action' => 'edit' ] );
        }

        return $editLink;
    }

	public function index() {
		if ( self::$skipRendering ) {
			return false;
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$wg = $this->wg;
		$out = $wg->Out;
		$titleText = $out->getPageTitle();
		$title = $out->getTitle();
		$namespace = ($title instanceof Title) ? $title->getNamespace() : -1;

		$this->response->setVal( 'pageTitle', $this->getTitleText( $titleText, $namespace ) );

		$article = $this->wg->Article;

		if ( $article instanceof Article ) {
			$revision = $article->getPage()->getRevision();

			if ( $revision instanceof Revision ) {
				$user = User::newFromId( $revision->getRawUser() );

				$userName = $user->getName();

				if ( User::isIP( $userName ) ) {
					//For anonymous users don't display IP
					$userName = wfMessage( 'wikiamobile-anonymous-edited-by' )->text();
				} else {
					//Wrap username in a link to user page
					$userName = "<a class=userpage-link href='{$user->getUserPage()->getLocalUrl()}'>{$userName}</a>";
				}

				$this->response->setVal(
					'lastEditedOn',
					wfMessage( 'wikiamobile-last-edited-on' )
						->params( $this->wg->Lang->date( $revision->getTimestamp() ) )
						->text()
				);

				$this->response->setVal(
					'lastEditedBy',
					wfMessage( 'wikiamobile-last-edited-by' )
						->params( $userName )
						->text()
				);

			}
		}

		if( $wg->EnableArticleCommentsExt &&
			in_array( $title->getNamespace(), $wg->ContentNamespaces ) &&
			!$wg->Title->isMainPage() &&
			$wg->request->getVal( 'action', 'view' ) == 'view'
		) {
			$numberOfComments = ArticleCommentList::newFromTitle( $title )->getCountAllNested();
			$this->response->setVal(
				'commentCounter',
				wfMessage( 'wikiamobile-article-comments-counter' )
					->params( $numberOfComments )
					->text()
			);
		}

		$this->response->setVal( 'editLink', $this->getTitleEditUrl() );

		if ( $namespace == NS_CATEGORY ) {
			$this->response->setVal( 'categoryPage', wfMessage( 'wikiamobile-categories-tagline' )->inContentLanguage()->plain() );
		}

		return true;
	}
}
